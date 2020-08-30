<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDepartmentAPIRequest;
use App\Http\Requests\API\UpdateDepartmentAPIRequest;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DepartmentController
 * @package App\Http\Controllers\API
 */

class DepartmentAPIController extends AppBaseController
{
    /** @var  DepartmentRepository */
    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/departments",
     *      summary="Get a listing of the Departments.",
     *      tags={"Department"},
     *      description="Get all Departments",
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
     *                  @SWG\Items(ref="#/definitions/Department")
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
        $this->departmentRepository->pushCriteria(new RequestCriteria($request));
        $this->departmentRepository->pushCriteria(new LimitOffsetCriteria($request));
        $departments = $this->departmentRepository->all();

        return $this->sendResponse($departments->toArray(), 'Departments retrieved successfully');
    }

    /**
     * @param CreateDepartmentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/departments",
     *      summary="Store a newly created Department in storage",
     *      tags={"Department"},
     *      description="Store Department",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Department that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Department")
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
     *                  ref="#/definitions/Department"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDepartmentAPIRequest $request)
    {
        $input = $request->all();

        $department = $this->departmentRepository->create($input);

        return $this->sendResponse($department->toArray(), 'Department saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/departments/{id}",
     *      summary="Display the specified Department",
     *      tags={"Department"},
     *      description="Get Department",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Department",
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
     *                  ref="#/definitions/Department"
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
        /** @var Department $department */
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            return $this->sendError('دپارتمان وجود ندارد');
        }
        /** **** Customization **** */

        $this->authorize('view', $department);

        $department->retrieve();

        return $this->sendResponse($department, 'Department retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDepartmentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/departments/{id}",
     *      summary="Update the specified Department in storage",
     *      tags={"Department"},
     *      description="Update Department",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Department",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Department that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Department")
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
     *                  ref="#/definitions/Department"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDepartmentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Department $department */
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            return $this->sendError('Department not found');
        }

        $department = $this->departmentRepository->update($input, $id);

        return $this->sendResponse($department->toArray(), 'Department updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/departments/{id}",
     *      summary="Remove the specified Department from storage",
     *      tags={"Department"},
     *      description="Delete Department",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Department",
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
        /** @var Department $department */
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            return $this->sendError('Department not found');
        }

        $department->delete();

        return $this->sendResponse($id, 'Department deleted successfully');
    }
}
