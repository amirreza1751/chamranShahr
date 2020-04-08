<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateExternalServiceTypeAPIRequest;
use App\Http\Requests\API\UpdateExternalServiceTypeAPIRequest;
use App\Models\ExternalServiceType;
use App\Repositories\ExternalServiceTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ExternalServiceTypeController
 * @package App\Http\Controllers\API
 */

class ExternalServiceTypeAPIController extends AppBaseController
{
    /** @var  ExternalServiceTypeRepository */
    private $externalServiceTypeRepository;

    public function __construct(ExternalServiceTypeRepository $externalServiceTypeRepo)
    {
        $this->externalServiceTypeRepository = $externalServiceTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/externalServiceTypes",
     *      summary="Get a listing of the ExternalServiceTypes.",
     *      tags={"ExternalServiceType"},
     *      description="Get all ExternalServiceTypes",
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
     *                  @SWG\Items(ref="#/definitions/ExternalServiceType")
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
        $this->externalServiceTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->externalServiceTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $externalServiceTypes = $this->externalServiceTypeRepository->all();

        return $this->sendResponse($externalServiceTypes->toArray(), 'External Service Types retrieved successfully');
    }

    /**
     * @param CreateExternalServiceTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/externalServiceTypes",
     *      summary="Store a newly created ExternalServiceType in storage",
     *      tags={"ExternalServiceType"},
     *      description="Store ExternalServiceType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ExternalServiceType that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ExternalServiceType")
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
     *                  ref="#/definitions/ExternalServiceType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateExternalServiceTypeAPIRequest $request)
    {
        $input = $request->all();

        $externalServiceType = $this->externalServiceTypeRepository->create($input);

        return $this->sendResponse($externalServiceType->toArray(), 'External Service Type saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/externalServiceTypes/{id}",
     *      summary="Display the specified ExternalServiceType",
     *      tags={"ExternalServiceType"},
     *      description="Get ExternalServiceType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ExternalServiceType",
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
     *                  ref="#/definitions/ExternalServiceType"
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
        /** @var ExternalServiceType $externalServiceType */
        $externalServiceType = $this->externalServiceTypeRepository->findWithoutFail($id);

        if (empty($externalServiceType)) {
            return $this->sendError('External Service Type not found');
        }

        return $this->sendResponse($externalServiceType->toArray(), 'External Service Type retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateExternalServiceTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/externalServiceTypes/{id}",
     *      summary="Update the specified ExternalServiceType in storage",
     *      tags={"ExternalServiceType"},
     *      description="Update ExternalServiceType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ExternalServiceType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ExternalServiceType that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ExternalServiceType")
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
     *                  ref="#/definitions/ExternalServiceType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateExternalServiceTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var ExternalServiceType $externalServiceType */
        $externalServiceType = $this->externalServiceTypeRepository->findWithoutFail($id);

        if (empty($externalServiceType)) {
            return $this->sendError('External Service Type not found');
        }

        $externalServiceType = $this->externalServiceTypeRepository->update($input, $id);

        return $this->sendResponse($externalServiceType->toArray(), 'ExternalServiceType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/externalServiceTypes/{id}",
     *      summary="Remove the specified ExternalServiceType from storage",
     *      tags={"ExternalServiceType"},
     *      description="Delete ExternalServiceType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ExternalServiceType",
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
        /** @var ExternalServiceType $externalServiceType */
        $externalServiceType = $this->externalServiceTypeRepository->findWithoutFail($id);

        if (empty($externalServiceType)) {
            return $this->sendError('External Service Type not found');
        }

        $externalServiceType->delete();

        return $this->sendResponse($id, 'External Service Type deleted successfully');
    }
}
