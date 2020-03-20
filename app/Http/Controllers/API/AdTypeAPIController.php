<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAdTypeAPIRequest;
use App\Http\Requests\API\UpdateAdTypeAPIRequest;
use App\Models\AdType;
use App\Repositories\AdTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AdTypeController
 * @package App\Http\Controllers\API
 */

class AdTypeAPIController extends AppBaseController
{
    /** @var  AdTypeRepository */
    private $adTypeRepository;

    public function __construct(AdTypeRepository $adTypeRepo)
    {
        $this->adTypeRepository = $adTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/adTypes",
     *      summary="Get a listing of the AdTypes.",
     *      tags={"AdType"},
     *      description="Get all AdTypes",
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
     *                  @SWG\Items(ref="#/definitions/AdType")
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
        $this->adTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->adTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $adTypes = $this->adTypeRepository->all();

        return $this->sendResponse($adTypes->toArray(), 'Ad Types retrieved successfully');
    }

    /**
     * @param CreateAdTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/adTypes",
     *      summary="Store a newly created AdType in storage",
     *      tags={"AdType"},
     *      description="Store AdType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AdType that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AdType")
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
     *                  ref="#/definitions/AdType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAdTypeAPIRequest $request)
    {
        $input = $request->all();

        $adType = $this->adTypeRepository->create($input);

        return $this->sendResponse($adType->toArray(), 'Ad Type saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/adTypes/{id}",
     *      summary="Display the specified AdType",
     *      tags={"AdType"},
     *      description="Get AdType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AdType",
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
     *                  ref="#/definitions/AdType"
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
        /** @var AdType $adType */
        $adType = $this->adTypeRepository->findWithoutFail($id);

        if (empty($adType)) {
            return $this->sendError('Ad Type not found');
        }

        return $this->sendResponse($adType->toArray(), 'Ad Type retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAdTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/adTypes/{id}",
     *      summary="Update the specified AdType in storage",
     *      tags={"AdType"},
     *      description="Update AdType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AdType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AdType that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AdType")
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
     *                  ref="#/definitions/AdType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAdTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var AdType $adType */
        $adType = $this->adTypeRepository->findWithoutFail($id);

        if (empty($adType)) {
            return $this->sendError('Ad Type not found');
        }

        $adType = $this->adTypeRepository->update($input, $id);

        return $this->sendResponse($adType->toArray(), 'AdType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/adTypes/{id}",
     *      summary="Remove the specified AdType from storage",
     *      tags={"AdType"},
     *      description="Delete AdType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AdType",
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
        /** @var AdType $adType */
        $adType = $this->adTypeRepository->findWithoutFail($id);

        if (empty($adType)) {
            return $this->sendError('Ad Type not found');
        }

        $adType->delete();

        return $this->sendSuccess('Ad Type deleted successfully');
    }
}
