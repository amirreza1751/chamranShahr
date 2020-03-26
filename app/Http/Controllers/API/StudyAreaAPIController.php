<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStudyAreaAPIRequest;
use App\Http\Requests\API\UpdateStudyAreaAPIRequest;
use App\Models\StudyArea;
use App\Repositories\StudyAreaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class StudyAreaController
 * @package App\Http\Controllers\API
 */

class StudyAreaAPIController extends AppBaseController
{
    /** @var  StudyAreaRepository */
    private $studyAreaRepository;

    public function __construct(StudyAreaRepository $studyAreaRepo)
    {
        $this->studyAreaRepository = $studyAreaRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/studyAreas",
     *      summary="Get a listing of the StudyAreas.",
     *      tags={"StudyArea"},
     *      description="Get all StudyAreas",
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
     *                  @SWG\Items(ref="#/definitions/StudyArea")
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
        $this->studyAreaRepository->pushCriteria(new RequestCriteria($request));
        $this->studyAreaRepository->pushCriteria(new LimitOffsetCriteria($request));
        $studyAreas = $this->studyAreaRepository->all();

        return $this->sendResponse($studyAreas->toArray(), 'Study Areas retrieved successfully');
    }

    /**
     * @param CreateStudyAreaAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/studyAreas",
     *      summary="Store a newly created StudyArea in storage",
     *      tags={"StudyArea"},
     *      description="Store StudyArea",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StudyArea that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StudyArea")
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
     *                  ref="#/definitions/StudyArea"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStudyAreaAPIRequest $request)
    {
        $input = $request->all();

        $studyArea = $this->studyAreaRepository->create($input);

        return $this->sendResponse($studyArea->toArray(), 'Study Area saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/studyAreas/{id}",
     *      summary="Display the specified StudyArea",
     *      tags={"StudyArea"},
     *      description="Get StudyArea",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyArea",
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
     *                  ref="#/definitions/StudyArea"
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
        /** @var StudyArea $studyArea */
        $studyArea = $this->studyAreaRepository->findWithoutFail($id);

        if (empty($studyArea)) {
            return $this->sendError('Study Area not found');
        }

        return $this->sendResponse($studyArea->toArray(), 'Study Area retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateStudyAreaAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/studyAreas/{id}",
     *      summary="Update the specified StudyArea in storage",
     *      tags={"StudyArea"},
     *      description="Update StudyArea",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyArea",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StudyArea that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StudyArea")
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
     *                  ref="#/definitions/StudyArea"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStudyAreaAPIRequest $request)
    {
        $input = $request->all();

        /** @var StudyArea $studyArea */
        $studyArea = $this->studyAreaRepository->findWithoutFail($id);

        if (empty($studyArea)) {
            return $this->sendError('Study Area not found');
        }

        $studyArea = $this->studyAreaRepository->update($input, $id);

        return $this->sendResponse($studyArea->toArray(), 'StudyArea updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/studyAreas/{id}",
     *      summary="Remove the specified StudyArea from storage",
     *      tags={"StudyArea"},
     *      description="Delete StudyArea",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyArea",
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
        /** @var StudyArea $studyArea */
        $studyArea = $this->studyAreaRepository->findWithoutFail($id);

        if (empty($studyArea)) {
            return $this->sendError('Study Area not found');
        }

        $studyArea->delete();

        return $this->sendResponse($id, 'Study Area deleted successfully');
    }
}
