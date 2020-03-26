<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateManageHistoryAPIRequest;
use App\Http\Requests\API\UpdateManageHistoryAPIRequest;
use App\Models\ManageHistory;
use App\Repositories\ManageHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ManageHistoryController
 * @package App\Http\Controllers\API
 */

class ManageHistoryAPIController extends AppBaseController
{
    /** @var  ManageHistoryRepository */
    private $manageHistoryRepository;

    public function __construct(ManageHistoryRepository $manageHistoryRepo)
    {
        $this->manageHistoryRepository = $manageHistoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/manageHistories",
     *      summary="Get a listing of the ManageHistories.",
     *      tags={"ManageHistory"},
     *      description="Get all ManageHistories",
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
     *                  @SWG\Items(ref="#/definitions/ManageHistory")
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
        $this->manageHistoryRepository->pushCriteria(new RequestCriteria($request));
        $this->manageHistoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $manageHistories = $this->manageHistoryRepository->all();

        return $this->sendResponse($manageHistories->toArray(), 'Manage Histories retrieved successfully');
    }

    /**
     * @param CreateManageHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/manageHistories",
     *      summary="Store a newly created ManageHistory in storage",
     *      tags={"ManageHistory"},
     *      description="Store ManageHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ManageHistory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ManageHistory")
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
     *                  ref="#/definitions/ManageHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateManageHistoryAPIRequest $request)
    {
        $input = $request->all();

        $manageHistory = $this->manageHistoryRepository->create($input);

        return $this->sendResponse($manageHistory->toArray(), 'Manage History saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/manageHistories/{id}",
     *      summary="Display the specified ManageHistory",
     *      tags={"ManageHistory"},
     *      description="Get ManageHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ManageHistory",
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
     *                  ref="#/definitions/ManageHistory"
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
        /** @var ManageHistory $manageHistory */
        $manageHistory = $this->manageHistoryRepository->findWithoutFail($id);

        if (empty($manageHistory)) {
            return $this->sendError('Manage History not found');
        }

        return $this->sendResponse($manageHistory->toArray(), 'Manage History retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateManageHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/manageHistories/{id}",
     *      summary="Update the specified ManageHistory in storage",
     *      tags={"ManageHistory"},
     *      description="Update ManageHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ManageHistory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ManageHistory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ManageHistory")
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
     *                  ref="#/definitions/ManageHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateManageHistoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var ManageHistory $manageHistory */
        $manageHistory = $this->manageHistoryRepository->findWithoutFail($id);

        if (empty($manageHistory)) {
            return $this->sendError('Manage History not found');
        }

        $manageHistory = $this->manageHistoryRepository->update($input, $id);

        return $this->sendResponse($manageHistory->toArray(), 'ManageHistory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/manageHistories/{id}",
     *      summary="Remove the specified ManageHistory from storage",
     *      tags={"ManageHistory"},
     *      description="Delete ManageHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ManageHistory",
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
        /** @var ManageHistory $manageHistory */
        $manageHistory = $this->manageHistoryRepository->findWithoutFail($id);

        if (empty($manageHistory)) {
            return $this->sendError('Manage History not found');
        }

        $manageHistory->delete();

        return $this->sendResponse($id, 'Manage History deleted successfully');
    }
}
