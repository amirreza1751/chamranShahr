<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateManageHierarchyAPIRequest;
use App\Http\Requests\API\UpdateManageHierarchyAPIRequest;
use App\Models\ManageHierarchy;
use App\Repositories\ManageHierarchyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ManageHierarchyController
 * @package App\Http\Controllers\API
 */

class ManageHierarchyAPIController extends AppBaseController
{
    /** @var  ManageHierarchyRepository */
    private $manageHierarchyRepository;

    public function __construct(ManageHierarchyRepository $manageHierarchyRepo)
    {
        $this->manageHierarchyRepository = $manageHierarchyRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/manageHierarchies",
     *      summary="Get a listing of the ManageHierarchies.",
     *      tags={"ManageHierarchy"},
     *      description="Get all ManageHierarchies",
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
     *                  @SWG\Items(ref="#/definitions/ManageHierarchy")
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
        $this->manageHierarchyRepository->pushCriteria(new RequestCriteria($request));
        $this->manageHierarchyRepository->pushCriteria(new LimitOffsetCriteria($request));
        $manageHierarchies = $this->manageHierarchyRepository->all();

        return $this->sendResponse($manageHierarchies->toArray(), 'Manage Hierarchies retrieved successfully');
    }

    /**
     * @param CreateManageHierarchyAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/manageHierarchies",
     *      summary="Store a newly created ManageHierarchy in storage",
     *      tags={"ManageHierarchy"},
     *      description="Store ManageHierarchy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ManageHierarchy that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ManageHierarchy")
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
     *                  ref="#/definitions/ManageHierarchy"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateManageHierarchyAPIRequest $request)
    {
        $input = $request->all();

        $manageHierarchy = $this->manageHierarchyRepository->create($input);

        return $this->sendResponse($manageHierarchy->toArray(), 'Manage Hierarchy saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/manageHierarchies/{id}",
     *      summary="Display the specified ManageHierarchy",
     *      tags={"ManageHierarchy"},
     *      description="Get ManageHierarchy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ManageHierarchy",
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
     *                  ref="#/definitions/ManageHierarchy"
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
        /** @var ManageHierarchy $manageHierarchy */
        $manageHierarchy = $this->manageHierarchyRepository->findWithoutFail($id);

        if (empty($manageHierarchy)) {
            return $this->sendError('Manage Hierarchy not found');
        }

        return $this->sendResponse($manageHierarchy->toArray(), 'Manage Hierarchy retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateManageHierarchyAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/manageHierarchies/{id}",
     *      summary="Update the specified ManageHierarchy in storage",
     *      tags={"ManageHierarchy"},
     *      description="Update ManageHierarchy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ManageHierarchy",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ManageHierarchy that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ManageHierarchy")
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
     *                  ref="#/definitions/ManageHierarchy"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateManageHierarchyAPIRequest $request)
    {
        $input = $request->all();

        /** @var ManageHierarchy $manageHierarchy */
        $manageHierarchy = $this->manageHierarchyRepository->findWithoutFail($id);

        if (empty($manageHierarchy)) {
            return $this->sendError('Manage Hierarchy not found');
        }

        $manageHierarchy = $this->manageHierarchyRepository->update($input, $id);

        return $this->sendResponse($manageHierarchy->toArray(), 'ManageHierarchy updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/manageHierarchies/{id}",
     *      summary="Remove the specified ManageHierarchy from storage",
     *      tags={"ManageHierarchy"},
     *      description="Delete ManageHierarchy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ManageHierarchy",
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
        /** @var ManageHierarchy $manageHierarchy */
        $manageHierarchy = $this->manageHierarchyRepository->findWithoutFail($id);

        if (empty($manageHierarchy)) {
            return $this->sendError('Manage Hierarchy not found');
        }

        $manageHierarchy->delete();

        return $this->sendResponse($id, 'Manage Hierarchy deleted successfully');
    }
}
