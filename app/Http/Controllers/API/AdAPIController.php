<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAdAPIRequest;
use App\Http\Requests\API\UpdateAdAPIRequest;
use App\Models\Ad;
use App\Repositories\AdRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AdController
 * @package App\Http\Controllers\API
 */

class AdAPIController extends AppBaseController
{
    /** @var  AdRepository */
    private $adRepository;

    public function __construct(AdRepository $adRepo)
    {
        $this->adRepository = $adRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/ads",
     *      summary="Get a listing of the Ads.",
     *      tags={"Ad"},
     *      description="Get all Ads",
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
     *                  @SWG\Items(ref="#/definitions/Ad")
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
        $this->adRepository->pushCriteria(new RequestCriteria($request));
        $this->adRepository->pushCriteria(new LimitOffsetCriteria($request));
        $ads = $this->adRepository->all();

        return $this->sendResponse($ads->toArray(), 'Ads retrieved successfully');
    }

    /**
     * @param CreateAdAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/ads",
     *      summary="Store a newly created Ad in storage",
     *      tags={"Ad"},
     *      description="Store Ad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Ad that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Ad")
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
     *                  ref="#/definitions/Ad"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAdAPIRequest $request)
    {
        $input = $request->all();

        $ad = $this->adRepository->create($input);

        return $this->sendResponse($ad->toArray(), 'Ad saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/ads/{id}",
     *      summary="Display the specified Ad",
     *      tags={"Ad"},
     *      description="Get Ad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ad",
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
     *                  ref="#/definitions/Ad"
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
        /** @var Ad $ad */
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            return $this->sendError('Ad not found');
        }

        return $this->sendResponse($ad->toArray(), 'Ad retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAdAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/ads/{id}",
     *      summary="Update the specified Ad in storage",
     *      tags={"Ad"},
     *      description="Update Ad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ad",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Ad that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Ad")
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
     *                  ref="#/definitions/Ad"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAdAPIRequest $request)
    {
        $input = $request->all();

        /** @var Ad $ad */
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            return $this->sendError('Ad not found');
        }

        $ad = $this->adRepository->update($input, $id);

        return $this->sendResponse($ad->toArray(), 'Ad updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/ads/{id}",
     *      summary="Remove the specified Ad from storage",
     *      tags={"Ad"},
     *      description="Delete Ad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ad",
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
        /** @var Ad $ad */
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            return $this->sendError('Ad not found');
        }

        $ad->delete();

        return $this->sendSuccess('Ad deleted successfully');
    }
}
