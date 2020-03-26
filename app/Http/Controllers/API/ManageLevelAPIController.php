<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateManageLevelAPIRequest;
use App\Http\Requests\API\UpdateManageLevelAPIRequest;
use App\Models\ManageLevel;
use App\Repositories\ManageLevelRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ManageLevelController
 * @package App\Http\Controllers\API
 */

class ManageLevelAPIController extends AppBaseController
{
    /** @var  ManageLevelRepository */
    private $manageLevelRepository;

    public function __construct(ManageLevelRepository $manageLevelRepo)
    {
        $this->manageLevelRepository = $manageLevelRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/manageLevels",
     *      summary="Get a listing of the ManageLevels.",
     *      tags={"ManageLevel"},
     *      description="Get all ManageLevels",
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
     *                  @SWG\Items(ref="#/definitions/ManageLevel")
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
        $this->manageLevelRepository->pushCriteria(new RequestCriteria($request));
        $this->manageLevelRepository->pushCriteria(new LimitOffsetCriteria($request));
        $manageLevels = $this->manageLevelRepository->all();

        return $this->sendResponse($manageLevels->toArray(), 'Manage Levels retrieved successfully');
    }

    /**
     * @param CreateManageLevelAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/manageLevels",
     *      summary="Store a newly created ManageLevel in storage",
     *      tags={"ManageLevel"},
     *      description="Store ManageLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ManageLevel that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ManageLevel")
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
     *                  ref="#/definitions/ManageLevel"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateManageLevelAPIRequest $request)
    {
        $input = $request->all();

        $manageLevel = $this->manageLevelRepository->create($input);

        return $this->sendResponse($manageLevel->toArray(), 'Manage Level saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/manageLevels/{id}",
     *      summary="Display the specified ManageLevel",
     *      tags={"ManageLevel"},
     *      description="Get ManageLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ManageLevel",
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
     *                  ref="#/definitions/ManageLevel"
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
        /** @var ManageLevel $manageLevel */
        $manageLevel = $this->manageLevelRepository->findWithoutFail($id);

        if (empty($manageLevel)) {
            return $this->sendError('Manage Level not found');
        }

        return $this->sendResponse($manageLevel->toArray(), 'Manage Level retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateManageLevelAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/manageLevels/{id}",
     *      summary="Update the specified ManageLevel in storage",
     *      tags={"ManageLevel"},
     *      description="Update ManageLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ManageLevel",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ManageLevel that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ManageLevel")
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
     *                  ref="#/definitions/ManageLevel"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateManageLevelAPIRequest $request)
    {
        $input = $request->all();

        /** @var ManageLevel $manageLevel */
        $manageLevel = $this->manageLevelRepository->findWithoutFail($id);

        if (empty($manageLevel)) {
            return $this->sendError('Manage Level not found');
        }

        $manageLevel = $this->manageLevelRepository->update($input, $id);

        return $this->sendResponse($manageLevel->toArray(), 'ManageLevel updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/manageLevels/{id}",
     *      summary="Remove the specified ManageLevel from storage",
     *      tags={"ManageLevel"},
     *      description="Delete ManageLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ManageLevel",
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
        /** @var ManageLevel $manageLevel */
        $manageLevel = $this->manageLevelRepository->findWithoutFail($id);

        if (empty($manageLevel)) {
            return $this->sendError('Manage Level not found');
        }

        $manageLevel->delete();

        return $this->sendResponse($id, 'Manage Level deleted successfully');
    }
}
