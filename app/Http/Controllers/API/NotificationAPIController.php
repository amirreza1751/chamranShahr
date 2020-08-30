<?php

namespace App\Http\Controllers\API;

use App\General\ConsoleColor;
use App\Http\Requests\API\CreateNotificationAPIRequest;
use App\Http\Requests\API\UpdateNotificationAPIRequest;
use App\Models\Faculty;
use App\Models\Notice;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudyArea;
use App\Models\StudyField;
use App\Models\StudyStatus;
use App\Models\Term;
use App\Notifications\NoticeNotification;
use App\Notifications\PrivateNotification;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NotificationController
 * @package App\Http\Controllers\API
 */

class NotificationAPIController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/notifications",
     *      summary="Get a listing of the Notifications.",
     *      tags={"Notification"},
     *      description="Get all Notifications",
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
     *                  @SWG\Items(ref="#/definitions/Notification")
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
        $this->notificationRepository->pushCriteria(new RequestCriteria($request));
        $this->notificationRepository->pushCriteria(new LimitOffsetCriteria($request));
        $notifications = $this->notificationRepository->all();

        return $this->sendResponse($notifications->toArray(), 'Notifications retrieved successfully');
    }

    /**
     * @param CreateNotificationAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/notifications",
     *      summary="Store a newly created Notification in storage",
     *      tags={"Notification"},
     *      description="Store Notification",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notification that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Notification")
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
     *                  ref="#/definitions/Notification"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNotificationAPIRequest $request)
    {
        $input = $request->all();

        $notification = $this->notificationRepository->create($input);

        return $this->sendResponse($notification->toArray(), 'Notification saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/notifications/{id}",
     *      summary="Display the specified Notification",
     *      tags={"Notification"},
     *      description="Get Notification",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notification",
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
     *                  ref="#/definitions/Notification"
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
        /** @var Notification $notification */
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        return $this->sendResponse($notification->toArray(), 'Notification retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNotificationAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/notifications/{id}",
     *      summary="Update the specified Notification in storage",
     *      tags={"Notification"},
     *      description="Update Notification",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notification",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notification that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Notification")
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
     *                  ref="#/definitions/Notification"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNotificationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Notification $notification */
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification = $this->notificationRepository->update($input, $id);

        return $this->sendResponse($notification->toArray(), 'Notification updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/notifications/{id}",
     *      summary="Remove the specified Notification from storage",
     *      tags={"Notification"},
     *      description="Delete Notification",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notification",
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
        /** @var Notification $notification */
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification->delete();

        return $this->sendResponse($id, 'Notification deleted successfully');
    }


    /**
     *******************************************************************************************************************
     *******************************************************************************************************************
     *************************************************** CUSTOMIZATION *************************************************
     *******************************************************************************************************************
     *******************************************************************************************************************
     */

    public function notify_students(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'notifier_type' => 'required|string',
            'notifier_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'deadline' => 'required|date',
            'study_status_unique_code' => 'string|regex:/' . strtolower(array_last(explode("\\", StudyStatus::class))) . '[0-9]/',
            'faculty_unique_code' => 'string|regex:/' . strtolower(array_last(explode("\\", Faculty::class))) . '[0-9]/',
            'study_field_unique_code' => 'string|regex:/' . strtolower(array_last(explode("\\", StudyField::class))) . '[0-9]/',
            'study_area_unique_code' => 'string|regex:/' . strtolower(array_last(explode("\\", StudyArea::class))) . '[0-9]/',
            'entrance_term_unique_code' => 'string|regex:/' . strtolower(array_last(explode("\\", Term::class))) . '[0-9]/',
        ]);

        $students = Student::all();

        if(isset($input['study_status_unique_code'])){
            $students = $students->where('study_status_unique_code', $input['study_status_unique_code']);
        }

        if(isset($input['study_area_unique_code'])){
            $students = $students->where('study_area_unique_code', $input['study_area_unique_code']);
        }

        if(isset($input['entrance_term_unique_code'])){
            $students = $students->where('entrance_term_unique_code', $input['entrance_term_unique_code']);
        }

        error_log(Carbon::now());
        \Illuminate\Support\Facades\Notification::send($students, new NoticeNotification($input['notifier_type'], $input['notifier_id'], Carbon::now()));
        return $students;
//        Notification::send($users, new InvoicePaid($invoice));


//        $notification = $this->notificationRepository->create($input);

        return 'OK';
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/notifications/{id}/notifierOwner",
     *      summary="Display Notifier Owner",
     *      tags={"Notification"},
     *      description="Get the specified Notification Notifier Owner",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notification",
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
    public function notifierOwner($id)
    {

        /** @var Notification $notification */
        $notification = $this->notificationRepository->findWithoutFail($id);

        $this->authorize('view', $notification);

        if (empty($notification)) {
            return $this->sendError('این نوتیفیکیشن وجود ندارد.');
        }

        if (empty($notification->notifier)){
            return $this->sendError('مرجع نامشخص');
        }

        $department = $notification->notifier->owner->retrieve();

        return $this->sendResponse($department, 'Notification retrieved successfully');
    }
}
