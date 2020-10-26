<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationSampleRequest;
use App\Http\Requests\UpdateNotificationSampleRequest;
use App\Repositories\NotificationSampleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

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

        return view('notification_samples.index')
            ->with('notificationSamples', $notificationSamples);
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

        Flash::success('Notification Sample saved successfully.');

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
            Flash::error('Notification Sample not found');

            return redirect(route('notificationSamples.index'));
        }

        return view('notification_samples.show')->with('notificationSample', $notificationSample);
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
            Flash::error('Notification Sample not found');

            return redirect(route('notificationSamples.index'));
        }

        return view('notification_samples.edit')->with('notificationSample', $notificationSample);
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
            Flash::error('Notification Sample not found');

            return redirect(route('notificationSamples.index'));
        }

        $notificationSample = $this->notificationSampleRepository->update($request->all(), $id);

        Flash::success('Notification Sample updated successfully.');

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
            Flash::error('Notification Sample not found');

            return redirect(route('notificationSamples.index'));
        }

        $this->notificationSampleRepository->delete($id);

        Flash::success('Notification Sample deleted successfully.');

        return redirect(route('notificationSamples.index'));
    }
}
