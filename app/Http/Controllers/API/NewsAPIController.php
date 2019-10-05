<?php

namespace App\Http\Controllers\API;

use App\CollectionHelper;
use App\Http\Requests\API\CreateNewsAPIRequest;
use App\Http\Requests\API\UpdateNewsAPIRequest;
use App\Models\News;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NewsController
 * @package App\Http\Controllers\API
 */

class NewsAPIController extends AppBaseController
{
    /** @var  NewsRepository */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepo)
    {
        $this->newsRepository = $newsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/news",
     *      summary="Get a listing of the News.",
     *      tags={"News"},
     *      description="Get all News",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/News")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->newsRepository->pushCriteria(new RequestCriteria($request));
        $this->newsRepository->pushCriteria(new LimitOffsetCriteria($request));
//        $news = $this->newsRepository->orderBy('created_at', 'desc')->all();

//        $total = $news->count();
//        $pageSize = 10;
//        $paginated = CollectionHelper::paginate($news, $total, $pageSize);

//        return $this->sendResponse($paginated->toArray(), 'News retrieved successfully');
        return DB::table('news')->orderBy('created_at', 'desc')->paginate(10)->toArray(); // comment this for https test


        // uncomment this section for https test >
//        $paginated = DB::table('news')->orderBy('created_at', 'desc')->paginate(10)->toArray();
//        foreach ($paginated['data'] as $pagi){
//            $pagi->path = 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png';
//        }
//        return $paginated;
        // uncomment this section for https test <
    }

    /**
     * @param CreateNewsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/news",
     *      summary="Store a newly created News in storage",
     *      tags={"News"},
     *      description="Store News",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="News that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/News")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/News"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNewsAPIRequest $request)
    {
        $input = $request->all();

        $news = $this->newsRepository->create($input);

        return $this->sendResponse($news->toArray(), 'News saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/news/{id}",
     *      summary="Display the specified News",
     *      tags={"News"},
     *      description="Get News",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of News",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/News"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var News $news */
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        return $this->sendResponse($news->toArray(), 'News retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNewsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/news/{id}",
     *      summary="Update the specified News in storage",
     *      tags={"News"},
     *      description="Update News",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of News",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="News that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/News")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/News"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNewsAPIRequest $request)
    {
        $input = $request->all();

        /** @var News $news */
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        $news = $this->newsRepository->update($input, $id);

        return $this->sendResponse($news->toArray(), 'News updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/news/{id}",
     *      summary="Remove the specified News from storage",
     *      tags={"News"},
     *      description="Delete News",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of News",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var News $news */
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        $news->delete();

        return $this->sendResponse($id, 'News deleted successfully');
    }
}
