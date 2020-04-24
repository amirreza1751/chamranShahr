<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Faculty;
use App\Models\News;
use App\Models\Notice;
use App\Models\Student;
use App\Models\StudyArea;
use App\Models\StudyField;
use App\Models\StudyStatus;
use App\Models\Term;
use App\Notifications\NoticeNotification;
use App\Repositories\NotificationRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class NotificationController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notification.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->notificationRepository->pushCriteria(new RequestCriteria($request));
        $notifications = $this->notificationRepository->all();

        return view('notifications.index')
            ->with('notifications', $notifications);
    }

    /**
     * Show the form for creating a new Notification.
     *
     * @return Response
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Store a newly created Notification in storage.
     *
     * @param CreateNotificationRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationRequest $request)
    {
        $input = $request->all();

        $notification = $this->notificationRepository->create($input);

        Flash::success('Notification saved successfully.');

        return redirect(route('notifications.index'));
    }

    /**
     * Display the specified Notification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        return view('notifications.show')->with('notification', $notification);
    }

    /**
     * Show the form for editing the specified Notification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        return view('notifications.edit')->with('notification', $notification);
    }

    /**
     * Update the specified Notification in storage.
     *
     * @param  int              $id
     * @param UpdateNotificationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationRequest $request)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        $notification = $this->notificationRepository->update($request->all(), $id);

        Flash::success('Notification updated successfully.');

        return redirect(route('notifications.index'));
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        $this->notificationRepository->delete($id);

        Flash::success('Notification deleted successfully.');

        return redirect(route('notifications.index'));
    }


    /**
     *******************************************************************************************************************
     *******************************************************************************************************************
     *************************************************** CUSTOMIZATION *************************************************
     *******************************************************************************************************************
     *******************************************************************************************************************
     */

    public function showNotifyStudents()
    {
        $notifiers = [
            'Notice' => Notice::class,
            'News' => News::class,
        ];
        $faculties = Faculty::all()->pluck('unique_code', 'title');
        $entrance_terms = Term::orderBy('begin_date', 'desc')->pluck('unique_code', 'title');
        return view('notifications.notify_students')
            ->with('faculties', $faculties)
            ->with('entrance_terms', $entrance_terms)
            ->with('notifiers', $notifiers);
    }

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

        Flash::success('Notification sent successfully.');

        return redirect(route('notifications.index'));
    }

    public function ajaxNotifier(Request $request)
    {
        if(Auth::user()->hasRole('developer') || Auth::user()->hasRole('admin')){
            $model_name =  $request['model_name'];
            $model = new $model_name();
            $models = $model::all();
            foreach ($models as $model){
                $model->title = $model->getTitleOwnerAttribute();
                if ($model->owner_type == $request['type'] && $model->owner_id == $request['id']){
                    $model['selected'] = true;
                }
            }
            return $models;
        } else {
//            $departments = Auth::user()
        }
    }

    public function ajaxStudyField(Request $request)
    {
        $faculty = Faculty::where('unique_code', $request->faculty_unique_code)->first();
        return $faculty->study_fields->pluck('title', 'unique_code');
    }

    public function ajaxStudyArea(Request $request)
    {
        $study_field = StudyField::where('unique_code', $request->study_field_unique_code)->first();
        return $study_field->study_areas->pluck('title', 'unique_code');
    }
}
