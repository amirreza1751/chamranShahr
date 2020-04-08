<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateExternalServiceAPIRequest;
use App\Http\Requests\API\UpdateExternalServiceAPIRequest;
use App\Models\ExternalService;
use App\Repositories\ExternalServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ExternalServiceController
 * @package App\Http\Controllers\API
 */

class ExternalServiceAPIController extends AppBaseController
{
    /** @var  ExternalServiceRepository */
    private $externalServiceRepository;

    public function __construct(ExternalServiceRepository $externalServiceRepo)
    {
        $this->externalServiceRepository = $externalServiceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/externalServices",
     *      summary="Get a listing of the ExternalServices.",
     *      tags={"ExternalService"},
     *      description="Get all ExternalServices",
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
     *                  @SWG\Items(ref="#/definitions/ExternalService")
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
        $this->externalServiceRepository->pushCriteria(new RequestCriteria($request));
        $this->externalServiceRepository->pushCriteria(new LimitOffsetCriteria($request));
        $externalServices = $this->externalServiceRepository->all();

        return $this->sendResponse($externalServices->toArray(), 'External Services retrieved successfully');
    }

    /**
     * @param CreateExternalServiceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/externalServices",
     *      summary="Store a newly created ExternalService in storage",
     *      tags={"ExternalService"},
     *      description="Store ExternalService",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ExternalService that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ExternalService")
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
     *                  ref="#/definitions/ExternalService"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateExternalServiceAPIRequest $request)
    {
        $input = $request->all();

        $externalService = $this->externalServiceRepository->create($input);

        return $this->sendResponse($externalService->toArray(), 'External Service saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/externalServices/{id}",
     *      summary="Display the specified ExternalService",
     *      tags={"ExternalService"},
     *      description="Get ExternalService",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ExternalService",
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
     *                  ref="#/definitions/ExternalService"
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
        /** @var ExternalService $externalService */
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            return $this->sendError('External Service not found');
        }

        return $this->sendResponse($externalService->toArray(), 'External Service retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateExternalServiceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/externalServices/{id}",
     *      summary="Update the specified ExternalService in storage",
     *      tags={"ExternalService"},
     *      description="Update ExternalService",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ExternalService",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ExternalService that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ExternalService")
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
     *                  ref="#/definitions/ExternalService"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateExternalServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var ExternalService $externalService */
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            return $this->sendError('External Service not found');
        }

        $externalService = $this->externalServiceRepository->update($input, $id);

        return $this->sendResponse($externalService->toArray(), 'ExternalService updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/externalServices/{id}",
     *      summary="Remove the specified ExternalService from storage",
     *      tags={"ExternalService"},
     *      description="Delete ExternalService",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ExternalService",
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
        /** @var ExternalService $externalService */
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            return $this->sendError('External Service not found');
        }

        $externalService->delete();

        return $this->sendResponse($id, 'External Service deleted successfully');
    }
}
