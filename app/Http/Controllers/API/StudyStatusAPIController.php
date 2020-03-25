<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStudyStatusAPIRequest;
use App\Http\Requests\API\UpdateStudyStatusAPIRequest;
use App\Models\StudyStatus;
use App\Repositories\StudyStatusRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class StudyStatusController
 * @package App\Http\Controllers\API
 */

class StudyStatusAPIController extends AppBaseController
{
    /** @var  StudyStatusRepository */
    private $studyStatusRepository;

    public function __construct(StudyStatusRepository $studyStatusRepo)
    {
        $this->studyStatusRepository = $studyStatusRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/studyStatuses",
     *      summary="Get a listing of the StudyStatuses.",
     *      tags={"StudyStatus"},
     *      description="Get all StudyStatuses",
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
     *                  @SWG\Items(ref="#/definitions/StudyStatus")
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
        $this->studyStatusRepository->pushCriteria(new RequestCriteria($request));
        $this->studyStatusRepository->pushCriteria(new LimitOffsetCriteria($request));
        $studyStatuses = $this->studyStatusRepository->all();

        return $this->sendResponse($studyStatuses->toArray(), 'Study Statuses retrieved successfully');
    }

    /**
     * @param CreateStudyStatusAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/studyStatuses",
     *      summary="Store a newly created StudyStatus in storage",
     *      tags={"StudyStatus"},
     *      description="Store StudyStatus",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StudyStatus that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StudyStatus")
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
     *                  ref="#/definitions/StudyStatus"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStudyStatusAPIRequest $request)
    {
        $input = $request->all();

        $studyStatus = $this->studyStatusRepository->create($input);

        return $this->sendResponse($studyStatus->toArray(), 'Study Status saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/studyStatuses/{id}",
     *      summary="Display the specified StudyStatus",
     *      tags={"StudyStatus"},
     *      description="Get StudyStatus",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyStatus",
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
     *                  ref="#/definitions/StudyStatus"
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
        /** @var StudyStatus $studyStatus */
        $studyStatus = $this->studyStatusRepository->findWithoutFail($id);

        if (empty($studyStatus)) {
            return $this->sendError('Study Status not found');
        }

        return $this->sendResponse($studyStatus->toArray(), 'Study Status retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateStudyStatusAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/studyStatuses/{id}",
     *      summary="Update the specified StudyStatus in storage",
     *      tags={"StudyStatus"},
     *      description="Update StudyStatus",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyStatus",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StudyStatus that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StudyStatus")
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
     *                  ref="#/definitions/StudyStatus"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStudyStatusAPIRequest $request)
    {
        $input = $request->all();

        /** @var StudyStatus $studyStatus */
        $studyStatus = $this->studyStatusRepository->findWithoutFail($id);

        if (empty($studyStatus)) {
            return $this->sendError('Study Status not found');
        }

        $studyStatus = $this->studyStatusRepository->update($input, $id);

        return $this->sendResponse($studyStatus->toArray(), 'StudyStatus updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/studyStatuses/{id}",
     *      summary="Remove the specified StudyStatus from storage",
     *      tags={"StudyStatus"},
     *      description="Delete StudyStatus",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyStatus",
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
        /** @var StudyStatus $studyStatus */
        $studyStatus = $this->studyStatusRepository->findWithoutFail($id);

        if (empty($studyStatus)) {
            return $this->sendError('Study Status not found');
        }

        $studyStatus->delete();

        return $this->sendResponse($id, 'Study Status deleted successfully');
    }
}
