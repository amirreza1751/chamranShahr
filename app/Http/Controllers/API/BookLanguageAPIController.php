<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBookLanguageAPIRequest;
use App\Http\Requests\API\UpdateBookLanguageAPIRequest;
use App\Models\BookLanguage;
use App\Repositories\BookLanguageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class BookLanguageController
 * @package App\Http\Controllers\API
 */

class BookLanguageAPIController extends AppBaseController
{
    /** @var  BookLanguageRepository */
    private $bookLanguageRepository;

    public function __construct(BookLanguageRepository $bookLanguageRepo)
    {
        $this->bookLanguageRepository = $bookLanguageRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/bookLanguages",
     *      summary="Get a listing of the BookLanguages.",
     *      tags={"BookLanguage"},
     *      description="Get all BookLanguages",
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
     *                  @SWG\Items(ref="#/definitions/BookLanguage")
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
        $this->bookLanguageRepository->pushCriteria(new RequestCriteria($request));
        $this->bookLanguageRepository->pushCriteria(new LimitOffsetCriteria($request));
        $bookLanguages = $this->bookLanguageRepository->all();

        return $this->sendResponse($bookLanguages->toArray(), 'Book Languages retrieved successfully');
    }

    /**
     * @param CreateBookLanguageAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/bookLanguages",
     *      summary="Store a newly created BookLanguage in storage",
     *      tags={"BookLanguage"},
     *      description="Store BookLanguage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BookLanguage that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BookLanguage")
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
     *                  ref="#/definitions/BookLanguage"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBookLanguageAPIRequest $request)
    {
        $input = $request->all();

        $bookLanguage = $this->bookLanguageRepository->create($input);

        return $this->sendResponse($bookLanguage->toArray(), 'Book Language saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/bookLanguages/{id}",
     *      summary="Display the specified BookLanguage",
     *      tags={"BookLanguage"},
     *      description="Get BookLanguage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BookLanguage",
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
     *                  ref="#/definitions/BookLanguage"
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
        /** @var BookLanguage $bookLanguage */
        $bookLanguage = $this->bookLanguageRepository->findWithoutFail($id);

        if (empty($bookLanguage)) {
            return $this->sendError('Book Language not found');
        }

        return $this->sendResponse($bookLanguage->toArray(), 'Book Language retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBookLanguageAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/bookLanguages/{id}",
     *      summary="Update the specified BookLanguage in storage",
     *      tags={"BookLanguage"},
     *      description="Update BookLanguage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BookLanguage",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BookLanguage that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BookLanguage")
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
     *                  ref="#/definitions/BookLanguage"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBookLanguageAPIRequest $request)
    {
        $input = $request->all();

        /** @var BookLanguage $bookLanguage */
        $bookLanguage = $this->bookLanguageRepository->findWithoutFail($id);

        if (empty($bookLanguage)) {
            return $this->sendError('Book Language not found');
        }

        $bookLanguage = $this->bookLanguageRepository->update($input, $id);

        return $this->sendResponse($bookLanguage->toArray(), 'BookLanguage updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/bookLanguages/{id}",
     *      summary="Remove the specified BookLanguage from storage",
     *      tags={"BookLanguage"},
     *      description="Delete BookLanguage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BookLanguage",
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
        /** @var BookLanguage $bookLanguage */
        $bookLanguage = $this->bookLanguageRepository->findWithoutFail($id);

        if (empty($bookLanguage)) {
            return $this->sendError('Book Language not found');
        }

        $bookLanguage->delete();

        return $this->sendSuccess('Book Language deleted successfully');
    }
}
