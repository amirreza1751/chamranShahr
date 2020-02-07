<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStudyLevelAPIRequest;
use App\Http\Requests\API\UpdateStudyLevelAPIRequest;
use App\Models\StudyLevel;
use App\Repositories\StudyLevelRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class StudyLevelController
 * @package App\Http\Controllers\API
 */

class StudyLevelAPIController extends AppBaseController
{
    /** @var  StudyLevelRepository */
    private $studyLevelRepository;

    public function __construct(StudyLevelRepository $studyLevelRepo)
    {
        $this->studyLevelRepository = $studyLevelRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/studyLevels",
     *      summary="Get a listing of the StudyLevels.",
     *      tags={"StudyLevel"},
     *      description="Get all StudyLevels",
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
     *                  @SWG\Items(ref="#/definitions/StudyLevel")
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
        $this->studyLevelRepository->pushCriteria(new RequestCriteria($request));
        $this->studyLevelRepository->pushCriteria(new LimitOffsetCriteria($request));
        $studyLevels = $this->studyLevelRepository->all();

        return $this->sendResponse($studyLevels->toArray(), 'Study Levels retrieved successfully');
    }

    /**
     * @param CreateStudyLevelAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/studyLevels",
     *      summary="Store a newly created StudyLevel in storage",
     *      tags={"StudyLevel"},
     *      description="Store StudyLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StudyLevel that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StudyLevel")
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
     *                  ref="#/definitions/StudyLevel"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStudyLevelAPIRequest $request)
    {
        $input = $request->all();

        $studyLevel = $this->studyLevelRepository->create($input);

        return $this->sendResponse($studyLevel->toArray(), 'Study Level saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/studyLevels/{id}",
     *      summary="Display the specified StudyLevel",
     *      tags={"StudyLevel"},
     *      description="Get StudyLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyLevel",
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
     *                  ref="#/definitions/StudyLevel"
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
        /** @var StudyLevel $studyLevel */
        $studyLevel = $this->studyLevelRepository->findWithoutFail($id);

        if (empty($studyLevel)) {
            return $this->sendError('Study Level not found');
        }

        return $this->sendResponse($studyLevel->toArray(), 'Study Level retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateStudyLevelAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/studyLevels/{id}",
     *      summary="Update the specified StudyLevel in storage",
     *      tags={"StudyLevel"},
     *      description="Update StudyLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyLevel",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StudyLevel that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StudyLevel")
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
     *                  ref="#/definitions/StudyLevel"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStudyLevelAPIRequest $request)
    {
        $input = $request->all();

        /** @var StudyLevel $studyLevel */
        $studyLevel = $this->studyLevelRepository->findWithoutFail($id);

        if (empty($studyLevel)) {
            return $this->sendError('Study Level not found');
        }

        $studyLevel = $this->studyLevelRepository->update($input, $id);

        return $this->sendResponse($studyLevel->toArray(), 'StudyLevel updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/studyLevels/{id}",
     *      summary="Remove the specified StudyLevel from storage",
     *      tags={"StudyLevel"},
     *      description="Delete StudyLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyLevel",
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
        /** @var StudyLevel $studyLevel */
        $studyLevel = $this->studyLevelRepository->findWithoutFail($id);

        if (empty($studyLevel)) {
            return $this->sendError('Study Level not found');
        }

        $studyLevel->delete();

        return $this->sendResponse($id, 'Study Level deleted successfully');
    }
}
