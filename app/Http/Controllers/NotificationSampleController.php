<?php

namespace App\Http\Controllers;

use App\General\Constants;
use App\Http\Requests\CreateNotificationSampleRequest;
use App\Http\Requests\UpdateNotificationSampleRequest;
use App\Models\News;
use App\Models\Notice;
use App\Repositories\NotificationSampleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Symfony\Component\Console\Output\ConsoleOutput;

class NotificationSampleController extends AppBaseController
{
    /** @var  NotificationSampleRepository */
    private $notificationSampleRepository;

    public function __construct(NotificationSampleRepository $notificationSampleRepo)
    {
        $this->notificationSampleRepository = $notificationSampleRepo;
    }

    /**
     * Display a listing of the NotificationSample.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->notificationSampleRepository->pushCriteria(new RequestCriteria($request));
        $notificationSamples = $this->notificationSampleRepository->all();

        if (Auth::user()->hasRole('developer|admin|notification_manager')) {
            $notificationSamples = $this->notificationSampleRepository->all();
        } else {
            $notificationSamples = collect();
            $all = $this->notificationSampleRepository->all();
            $manage_histories = Auth::user()->under_managment();
            foreach ($all as $notificationSample) {
                foreach ($manage_histories as $manage_history) {
                    if (isset($notificationSample->notifier) && isset($notificationSample->notifier->owner)) {
                        if (get_class($manage_history->managed) == get_class($notificationSample->notifier->owner) && $manage_history->managed->id == $notificationSample->notifier->owner->id) {
                            $notificationSamples->push($notificationSample);
                        }
                    }
                }
            }
        }

        return view('notification_samples.index')
            ->with('notificationSamples', $notificationSamples->sortByDesc('updated_at'))
            ->with('notification_types', Constants::notification_types);
    }

    /**
     * Show the form for creating a new NotificationSample.
     *
     * @return Response
     */
    public function create()
    {
        return view('notification_samples.create');
    }

    /**
     * Store a newly created NotificationSample in storage.
     *
     * @param CreateNotificationSampleRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationSampleRequest $request)
    {
        $input = $request->all();

        $notificationSample = $this->notificationSampleRepository->create($input);

        Flash::success('نوتیفیکیشن با موفقیت ایجاد شد');

        return redirect(route('notificationSamples.index'));
    }

    /**
     * Display the specified NotificationSample.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notificationSample = $this->notificationSampleRepository->findWithoutFail($id);

        if (empty($notificationSample)) {
            Flash::error('این نوتیفیکیشن وجود ندارد');

            return redirect(route('notificationSamples.index'));
        }

        return view('notification_samples.show')
            ->with('notificationSample', $notificationSample)
            ->with('notifications', $notificationSample->notifications)
            ->with('notification_types', Constants::notification_types);
    }

    /**
     * Show the form for editing the specified NotificationSample.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notificationSample = $this->notificationSampleRepository->findWithoutFail($id);

        if (empty($notificationSample)) {
            Flash::error('این نوتیفیکیشن وجود ندارد');

            return redirect(route('notificationSamples.index'));
        }

        $notifiers = [
            'Notice' => Notice::class,
            'News' => News::class,
        ];

        return view('notification_samples.edit')
            ->with('notificationSample', $notificationSample)
            ->with('notifiers', $notifiers)
            ->with('notification_types', Constants::notification_types);
    }

    /**
     * Update the specified NotificationSample in storage.
     *
     * @param  int              $id
     * @param UpdateNotificationSampleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationSampleRequest $request)
    {
        $notificationSample = $this->notificationSampleRepository->findWithoutFail($id);

        if (empty($notificationSample)) {
            Flash::error('این نوتیفیکیشن وجود ندارد');

            return redirect(route('notificationSamples.index'));
        }
        $input = $request->all();

        if (empty($input['deadline']))
            unset($input['deadline']);

        $notificationSample = $this->notificationSampleRepository->update($input, $id);

        Flash::success('نوتیفیکیشن با موفقیت ویرایش شد');

        return redirect(route('notificationSamples.index'));
    }

    /**
     * Remove the specified NotificationSample from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notificationSample = $this->notificationSampleRepository->findWithoutFail($id);

        if (empty($notificationSample)) {
            Flash::error('این نوتیفیکیشن وجود ندارد');

            return redirect(route('notificationSamples.index'));
        }

        $this->notificationSampleRepository->delete($id);

        Flash::success('نوتیفیکیشن با موفقیت حذف شد');

        return redirect(route('notificationSamples.index'));
    }
}
