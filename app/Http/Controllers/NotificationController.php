<?php

namespace App\Http\Controllers;

use App\General\Constants;
use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\NotifyRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Faculty;
use App\Models\News;
use App\Models\Notice;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudyArea;
use App\Models\StudyField;
use App\Models\StudyLevel;
use App\Models\StudyStatus;
use App\Models\Term;
use App\Notifications\EducationalNotification;
use App\Notifications\GeneralNotification;
use App\Notifications\NoticeNotification;
use App\Repositories\NotificationRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Symfony\Component\Console\Output\ConsoleOutput;

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
        $this->authorize('viewAny', Notification::class);

        $this->notificationRepository->pushCriteria(new RequestCriteria($request));

        if (Auth::user()->hasRole('developer')) {
            $notifications = $this->notificationRepository->all();
        } elseif (Auth::user()->hasRole('admin')) {
            $notifications = $this->notificationRepository->all();
        } elseif (Auth::user()->hasRole('notification_manager')) {
            $notifications = $this->notificationRepository->all();
        } else {
            $notifications = collect();
            $all = $this->notificationRepository->all();
            $manage_histories = Auth::user()->under_managment();
            foreach ($all as $notification) {
                foreach ($manage_histories as $manage_history) {
                    if (isset($notification->notifier) && isset($notification->notifier->owner)) {
                        if (get_class($manage_history->managed) == get_class($notification->notifier->owner) && $manage_history->managed->id == $notification->notifier->owner->id) {
                            $notifications->push($notification);
                        }
                    }
                }
            }
        }

        return view('notifications.index')
            ->with('notifications', $notifications);
    }

//    /**
//     * Show the form for creating a new Notification.
//     *
//     * @return Response
//     */
//    public function create()
//    {
//        $this->authorize('create', Notification::class);
//
//        return view('notifications.create');
//    }
//
//    /**
//     * Store a newly created Notification in storage.
//     *
//     * @param CreateNotificationRequest $request
//     *
//     * @return Response
//     */
//    public function store(CreateNotificationRequest $request)
//    {
//        $input = $request->all();
//
//        $notification = $this->notificationRepository->create($input);
//
//        Flash::success('Notification saved successfully.');
//
//        return redirect(route('notifications.index'));
//    }

    /**
     * Display the specified Notification.
     *
     * @param int $id
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
     * @param int $id
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
     * @param int $id
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
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        $this->authorize('delete', $notification);

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

    public function showNotify()
    {
        $this->authorize('showNotify', Notification::class);

        $notifiers = [
            'Notice' => Notice::class,
            'News' => News::class,
        ];
        $faculties = Faculty::all()->pluck('unique_code', 'title');
        $study_levels = StudyLevel::all()->pluck('unique_code', 'title');
        $entrance_terms = Term::orderBy('begin_date', 'desc')->pluck('unique_code', 'title');
        $study_statuses = StudyStatus::all()->pluck('unique_code', 'title');
        return view('notifications.notify_students')
            ->with('faculties', $faculties)
            ->with('study_levels', $study_levels)
            ->with('entrance_terms', $entrance_terms)
            ->with('study_statuses', $study_statuses)
            ->with('notifier_types', Constants::notifier_types)
            ->with('notification_types', Constants::notification_types)
            ->with('user_types', Constants::user_types);
    }

    public function showNotifyFromNotifier($notifier_type, $notifier_id)
    {
        $this->authorize('notify', [$notifier_type, $notifier_id]);

        $notifier = $notifier_type::find($notifier_id);

        $faculties = Faculty::all()->pluck('unique_code', 'title');
        $study_levels = StudyLevel::all()->pluck('unique_code', 'title');
        $entrance_terms = Term::orderBy('begin_date', 'desc')->pluck('unique_code', 'title');
        $study_statuses = StudyStatus::all()->pluck('unique_code', 'title');
        return view('notifications.notify_students')
            ->with('faculties', $faculties)
            ->with('study_levels', $study_levels)
            ->with('entrance_terms', $entrance_terms)
            ->with('study_statuses', $study_statuses)
            ->with('notifier_types', Constants::notifier_types)
            ->with('notifier', $notifier)
            ->with('notification_types', Constants::notification_types)
            ->with('user_types', Constants::user_types);
    }

    public function notify(NotifyRequest $request)
    {
        $input = $request->all();
        $title = null;
        $brief_description = null;

        $this->authorize('notify', [$input['notifier_type'], $input['notifier_id']]);

        $notifier = $input['notifier_type']::find($input['notifier_id']);

        if(isset($input['use_notifier_title']) && $input['use_notifier_title']){
            if(isset($notifier->title)){
                $title = $notifier->title;
            }
        } else {
            if(isset($input['title'])){
                $title = $input['title'];
            }
        }

        if(isset($input['use_notifier_description']) && $input['use_notifier_description']){
            if(isset($notifier->description)){
//                $brief_description = substr($notifier->description, 0, 48) . '...';
                $brief_description = mb_substr($notifier->description, 0, 142, "utf-8") . '...';
            }
        } else {
            if(isset($input['brief_description'])){
                $brief_description = $input['brief_description'];
            }
        }

        $input['title'] = $title;
        $input['brief_description'] = $brief_description;

        $input_deadline = Carbon::createFromFormat('Y-m-d', $input['deadline']);
        $input['deadline'] = Carbon::create($input_deadline->year, $input_deadline->month, $input_deadline->day, 0, 0, 0)->addDays(1)->subSecond(1);

        if ($input['user_type'] == Constants::ALL_USERS){
            $this->notifyUsers($input);
        } elseif ($input['user_type'] == Constants::STUDENTS){
            $this->notifyStudents($input);
        }

        Flash::success('نوتیفیکیشن با موفقیت ایجاد شد');

        return redirect(route('notificationSamples.index'));
    }

    public function notifyUsers($input)
    {
        $users = User::all();

        if ($users->isEmpty()) {
            Flash::error('کاربری با مشخصات انتخابی پیدا نشد.');

            return redirect(route('notificationSamples.index'));
        }

        $this->send($users, $input['notifier_type'], $input['notifier_id'], $input['deadline'], $input['title'], $input['brief_description'], $input['type']);

    }

    public function notifyStudents($input)
    {
        $students = Student::all();

        if (isset($input['faculty_unique_code'])) {
//            $students = $students->where('faculty_unique_code', $input['faculty_unique_code']);
            $students = Faculty::where('unique_code', $input['faculty_unique_code'])->first()->students();
        }

        if (isset($input['study_field_unique_code'])) {
//            $students = $students->where('study_field_unique_code', $input['study_field_unique_code']);
            $students = StudyField::where('unique_code', $input['study_field_unique_code'])->first()->students();
        }

        if (isset($input['study_area_unique_code'])) {
            $students = $students->where('study_area_unique_code', $input['study_area_unique_code']);
        }

        if (isset($input['study_level_unique_code'])) {
            $students = $students->where('study_level_unique_code', $input['study_level_unique_code']);
        }

        if (isset($input['entrance_term_unique_code'])) {
            $students = $students->where('entrance_term_unique_code', $input['entrance_term_unique_code']);
        }

        if (isset($input['study_status_unique_code'])) {
            $students = $students->where('study_status_unique_code', $input['study_status_unique_code']);
        }

        if ($students->isEmpty()) {
            Flash::error('دانشجویی با شخصات انتخابی پیدا نشد.');

            return redirect(route('notificationSamples.index'));
        }

        $this->send($students, $input['notifier_type'], $input['notifier_id'], $input['deadline'], $input['title'], $input['brief_description'], $input['type']);

    }

    public function ajaxNotifier(Request $request)
    {
        $model_name = $request['model_name'];
        $model = new $model_name();
        $result = new Collection();
        if (Auth::user()->hasRole('developer') || Auth::user()->hasRole('admin')) {
            $models = $model::all();
            foreach ($models as $model) {
                $model->title = $model->getTitleOwnerAttribute(); // must setup on target models, define as notifiers top of this class
                if ($model->owner_type == $request['notifier_id'] && $model->owner_id == $request['id']) {
                    $model['selected'] = true;
                }
            }
            $result = $models;
        } else {
            $manage_histories = Auth::user()->under_managment();
            foreach ($manage_histories as $manage_history) {
                $models = $model::where('owner_type', get_class($manage_history->managed))
                    ->where('owner_id', $manage_history->managed->id)->get();
                foreach ($models as $model) {
                    if ($model_name == $request['notifier_type'] && $model->id == $request['notifier_id']) {
                        $model->selected = true;
                    }
                    $result->push($model);
                }
            }
        }
        return $result;
    }

    public function ajaxStudyField(Request $request)
    {
        $faculty = Faculty::where('unique_code', $request->faculty_unique_code)->first();
        return $faculty->study_fields->pluck('title', 'unique_code');
    }

    public function ajaxStudyArea(Request $request)
    {
        $study_field = StudyField::where('unique_code', $request->study_field_unique_code)->first();
//        if(!is_null($request->study_level_unique_code))
//            return $study_field->study_areas->where('study_level_unique_code', $request->study_level_unique_code)->pluck('title', 'unique_code');
//        else
            return $study_field->study_areas->pluck('title', 'unique_code');
    }

    public function send($students, $notifier_type, $notifier_id, $deadline, $title, $brief_description, $type)
    {
        \Illuminate\Support\Facades\Notification::send($students, new GeneralNotification($notifier_type, $notifier_id, $deadline, $title, $brief_description, $type));
    }
}
