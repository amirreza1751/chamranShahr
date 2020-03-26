<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStudyFieldAPIRequest;
use App\Http\Requests\API\UpdateStudyFieldAPIRequest;
use App\Models\StudyField;
use App\Repositories\StudyFieldRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class StudyFieldController
 * @package App\Http\Controllers\API
 */

class StudyFieldAPIController extends AppBaseController
{
    /** @var  StudyFieldRepository */
    private $studyFieldRepository;

    public function __construct(StudyFieldRepository $studyFieldRepo)
    {
        $this->studyFieldRepository = $studyFieldRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/studyFields",
     *      summary="Get a listing of the StudyFields.",
     *      tags={"StudyField"},
     *      description="Get all StudyFields",
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
     *                  @SWG\Items(ref="#/definitions/StudyField")
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
        $this->studyFieldRepository->pushCriteria(new RequestCriteria($request));
        $this->studyFieldRepository->pushCriteria(new LimitOffsetCriteria($request));
        $studyFields = $this->studyFieldRepository->all();

        return $this->sendResponse($studyFields->toArray(), 'Study Fields retrieved successfully');
    }

    /**
     * @param CreateStudyFieldAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/studyFields",
     *      summary="Store a newly created StudyField in storage",
     *      tags={"StudyField"},
     *      description="Store StudyField",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StudyField that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StudyField")
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
     *                  ref="#/definitions/StudyField"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStudyFieldAPIRequest $request)
    {
        $input = $request->all();

        $studyField = $this->studyFieldRepository->create($input);

        return $this->sendResponse($studyField->toArray(), 'Study Field saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/studyFields/{id}",
     *      summary="Display the specified StudyField",
     *      tags={"StudyField"},
     *      description="Get StudyField",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyField",
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
     *                  ref="#/definitions/StudyField"
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
        /** @var StudyField $studyField */
        $studyField = $this->studyFieldRepository->findWithoutFail($id);

        if (empty($studyField)) {
            return $this->sendError('Study Field not found');
        }

        return $this->sendResponse($studyField->toArray(), 'Study Field retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateStudyFieldAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/studyFields/{id}",
     *      summary="Update the specified StudyField in storage",
     *      tags={"StudyField"},
     *      description="Update StudyField",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyField",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StudyField that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StudyField")
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
     *                  ref="#/definitions/StudyField"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStudyFieldAPIRequest $request)
    {
        $input = $request->all();

        /** @var StudyField $studyField */
        $studyField = $this->studyFieldRepository->findWithoutFail($id);

        if (empty($studyField)) {
            return $this->sendError('Study Field not found');
        }

        $studyField = $this->studyFieldRepository->update($input, $id);

        return $this->sendResponse($studyField->toArray(), 'StudyField updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/studyFields/{id}",
     *      summary="Remove the specified StudyField from storage",
     *      tags={"StudyField"},
     *      description="Delete StudyField",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StudyField",
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
        /** @var StudyField $studyField */
        $studyField = $this->studyFieldRepository->findWithoutFail($id);

        if (empty($studyField)) {
            return $this->sendError('Study Field not found');
        }

        $studyField->delete();

        return $this->sendResponse($id, 'Study Field deleted successfully');
    }
}
