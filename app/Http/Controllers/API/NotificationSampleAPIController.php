<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNotificationSampleAPIRequest;
use App\Http\Requests\API\UpdateNotificationSampleAPIRequest;
use App\Models\NotificationSample;
use App\Repositories\NotificationSampleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NotificationSampleController
 * @package App\Http\Controllers\API
 */

class NotificationSampleAPIController extends AppBaseController
{
    /** @var  NotificationSampleRepository */
    private $notificationSampleRepository;

    public function __construct(NotificationSampleRepository $notificationSampleRepo)
    {
        $this->notificationSampleRepository = $notificationSampleRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/notificationSamples",
     *      summary="Get a listing of the NotificationSamples.",
     *      tags={"NotificationSample"},
     *      description="Get all NotificationSamples",
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
     *                  @SWG\Items(ref="#/definitions/NotificationSample")
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
        $this->notificationSampleRepository->pushCriteria(new RequestCriteria($request));
        $this->notificationSampleRepository->pushCriteria(new LimitOffsetCriteria($request));
        $notificationSamples = $this->notificationSampleRepository->all();

        return $this->sendResponse($notificationSamples->toArray(), 'Notification Samples retrieved successfully');
    }

    /**
     * @param CreateNotificationSampleAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/notificationSamples",
     *      summary="Store a newly created NotificationSample in storage",
     *      tags={"NotificationSample"},
     *      description="Store NotificationSample",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NotificationSample that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NotificationSample")
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
     *                  ref="#/definitions/NotificationSample"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNotificationSampleAPIRequest $request)
    {
        $input = $request->all();

        $notificationSample = $this->notificationSampleRepository->create($input);

        return $this->sendResponse($notificationSample->toArray(), 'Notification Sample saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/notificationSamples/{id}",
     *      summary="Display the specified NotificationSample",
     *      tags={"NotificationSample"},
     *      description="Get NotificationSample",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NotificationSample",
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
     *                  ref="#/definitions/NotificationSample"
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
        /** @var NotificationSample $notificationSample */
        $notificationSample = $this->notificationSampleRepository->findWithoutFail($id);

        if (empty($notificationSample)) {
            return $this->sendError('Notification Sample not found');
        }

        return $this->sendResponse($notificationSample->toArray(), 'Notification Sample retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNotificationSampleAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/notificationSamples/{id}",
     *      summary="Update the specified NotificationSample in storage",
     *      tags={"NotificationSample"},
     *      description="Update NotificationSample",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NotificationSample",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NotificationSample that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NotificationSample")
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
     *                  ref="#/definitions/NotificationSample"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNotificationSampleAPIRequest $request)
    {
        $input = $request->all();

        /** @var NotificationSample $notificationSample */
        $notificationSample = $this->notificationSampleRepository->findWithoutFail($id);

        if (empty($notificationSample)) {
            return $this->sendError('Notification Sample not found');
        }

        $notificationSample = $this->notificationSampleRepository->update($input, $id);

        return $this->sendResponse($notificationSample->toArray(), 'NotificationSample updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/notificationSamples/{id}",
     *      summary="Remove the specified NotificationSample from storage",
     *      tags={"NotificationSample"},
     *      description="Delete NotificationSample",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NotificationSample",
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
        /** @var NotificationSample $notificationSample */
        $notificationSample = $this->notificationSampleRepository->findWithoutFail($id);

        if (empty($notificationSample)) {
            return $this->sendError('Notification Sample not found');
        }

        $notificationSample->delete();

        return $this->sendSuccess('Notification Sample deleted successfully');
    }
}
