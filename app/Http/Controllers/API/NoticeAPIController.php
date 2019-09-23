<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNoticeAPIRequest;
use App\Http\Requests\API\UpdateNoticeAPIRequest;
use App\Models\Notice;
use App\Repositories\NoticeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NoticeController
 * @package App\Http\Controllers\API
 */

class NoticeAPIController extends AppBaseController
{
    /** @var  NoticeRepository */
    private $noticeRepository;

    public function __construct(NoticeRepository $noticeRepo)
    {
        $this->noticeRepository = $noticeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/notices",
     *      summary="Get a listing of the Notices.",
     *      tags={"Notice"},
     *      description="Get all Notices",
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
     *                  @SWG\Items(ref="#/definitions/Notice")
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
        $this->noticeRepository->pushCriteria(new RequestCriteria($request));
        $this->noticeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $notices = $this->noticeRepository->all();

        return $this->sendResponse($notices->toArray(), 'Notices retrieved successfully');
    }

    /**
     * @param CreateNoticeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/notices",
     *      summary="Store a newly created Notice in storage",
     *      tags={"Notice"},
     *      description="Store Notice",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notice that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Notice")
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
     *                  ref="#/definitions/Notice"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNoticeAPIRequest $request)
    {
        $input = $request->all();

        $notice = $this->noticeRepository->create($input);

        return $this->sendResponse($notice->toArray(), 'Notice saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/notices/{id}",
     *      summary="Display the specified Notice",
     *      tags={"Notice"},
     *      description="Get Notice",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notice",
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
     *                  ref="#/definitions/Notice"
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
        /** @var Notice $notice */
        $notice = $this->noticeRepository->findWithoutFail($id);

        if (empty($notice)) {
            return $this->sendError('Notice not found');
        }

        return $this->sendResponse($notice->toArray(), 'Notice retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNoticeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/notices/{id}",
     *      summary="Update the specified Notice in storage",
     *      tags={"Notice"},
     *      description="Update Notice",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notice",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notice that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Notice")
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
     *                  ref="#/definitions/Notice"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNoticeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Notice $notice */
        $notice = $this->noticeRepository->findWithoutFail($id);

        if (empty($notice)) {
            return $this->sendError('Notice not found');
        }

        $notice = $this->noticeRepository->update($input, $id);

        return $this->sendResponse($notice->toArray(), 'Notice updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/notices/{id}",
     *      summary="Remove the specified Notice from storage",
     *      tags={"Notice"},
     *      description="Delete Notice",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notice",
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
        /** @var Notice $notice */
        $notice = $this->noticeRepository->findWithoutFail($id);

        if (empty($notice)) {
            return $this->sendError('Notice not found');
        }

        $notice->delete();

        return $this->sendResponse($id, 'Notice deleted successfully');
    }
}
