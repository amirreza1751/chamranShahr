<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoticeRequest;
use App\Http\Requests\UpdateNoticeRequest;
use App\Models\Department;
use App\Models\Notice;
use App\Repositories\NoticeRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class NoticeController extends AppBaseController
{
    /** @var  NoticeRepository */
    private $noticeRepository;
    private $owner_types = array(
        'Department' => Department::class,
    );

    public function __construct(NoticeRepository $noticeRepo)
    {
        $this->noticeRepository = $noticeRepo;
    }

    /**
     * Display a listing of the Notice.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('anyView', Notice::class);

        $this->noticeRepository->pushCriteria(new RequestCriteria($request));
        $notices = $this->noticeRepository->all();

        if (Auth::user()->hasRole('developer')) {
            $notices = $this->noticeRepository->all();
        } elseif (Auth::user()->hasRole('admin')) {
            $notices = $this->noticeRepository->all();
        } elseif (Auth::user()->hasRole('notification_manager')) {
            $notices = $this->noticeRepository->all();
        } else {
            $notices = collect();
            $all = $this->noticeRepository->all();
            $manage_histories = Auth::user()->under_managment();
            foreach ($all as $notice) {
                foreach ($manage_histories as $manage_history) {
                    if (isset($notice->owner_type) && isset($notice->owner_id)) {
                        if (get_class($manage_history->managed) == $notice->owner_type && $manage_history->managed->id == $notice->owner_id) {
                            $notices->push($notice);
                        }
                    }
                }
            }

        }

        return view('notices.index')
            ->with('notices', $notices);
    }

    /**
     * Show the form for creating a new Notice.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Notice::class);

        $creators = collect();
        if(Auth::user()->hasRole('developer')){
            $creators = User::all()->pluck('full_name_scu_id', 'id');
        }
        elseif (Auth::user()->hasRole('admin')){
            $creators = User::all()->pluck('full_name_scu_id', 'id');
        }
        elseif (Auth::user()->hasRole('content_manager')){
            $creators = User::all()->pluck('full_name_scu_id', 'id');
        }
        elseif (Auth::user()->hasRole('notification_manager')){
            $creators = User::all()->pluck('full_name_scu_id', 'id');
        }
        else {
            $creators = [
                Auth::user()->id => Auth::user()->getFullNameScuIdAttribute(),
            ];
        }
        return view('notices.create')
            ->with('creators', $creators)
            ->with('owner_types', $this->owner_types);
    }

    /**
     * Store a newly created Notice in storage.
     *
     * @param CreateNoticeRequest $request
     *
     * @return Response
     */
    public function store(CreateNoticeRequest $request)
    {
        $input = $request->all();

        $creator = User::find($request['creator_id']);
        if (empty($creator)) {
            Flash::error('Creator not found');

            return redirect(route('notices.create'));
        }

        $owner = $input['owner_type']::find($input['owner_id']);
        if (empty($owner)) {
            Flash::error('Owner not found');

            return redirect(route('notices.create'));
        }

        $this->authorize('store', [ $owner, $creator ]);

        $notice = $this->noticeRepository->create($input);

        Flash::success('Notice saved successfully.');

        if($input['make_notification']){
            return redirect(route('notifications.showNotifyStudentsFromNotifier', [ get_class($notice), $notice->id ]));
        } else {
            return redirect(route('notices.index'));
        }
    }

    /**
     * Display the specified Notice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

        $this->authorize('view', $notice);

        if (empty($notice)) {
            Flash::error('Notice not found');

            return redirect(route('notices.index'));
        }

        return view('notices.show')->with('notice', $notice);
    }

    /**
     * Show the form for editing the specified Notice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

        $this->authorize('update', $notice);

        if (empty($notice)) {
            Flash::error('Notice not found');

            return redirect(route('notices.index'));
        }

        $creators = User::all()->pluck('full_name_scu_id', 'id');
        return view('notices.edit')->with('notice', $notice)
            ->with('creators', $creators)
            ->with('owner_types', $this->owner_types);
    }

    /**
     * Update the specified Notice in storage.
     *
     * @param  int              $id
     * @param UpdateNoticeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNoticeRequest $request)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

        $this->authorize('update', $notice);

        if (empty($notice)) {
            Flash::error('Notice not found');

            return redirect(route('notices.index'));
        }

        $creator = User::find($request['creator_id']);
        if (empty($creator)) {
            Flash::error('Creator not found');

            return redirect(route('notices.edit'));
        }

        $owner = $request['owner_type']::find($request['owner_id']);
        if (empty($owner)) {
            Flash::error('Owner not found');

            return redirect(route('notices.edit'));
        }

        $notice = $this->noticeRepository->update($request->all(), $id);

        Flash::success('Notice updated successfully.');


        if($request['make_notification']){
            return redirect(route('notifications.showNotifyStudentsFromNotifier', [ get_class($notice), $notice->id ]));
        } else {
            return redirect(route('notices.index'));
        }
    }

    /**
     * Remove the specified Notice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

        $this->authorize('delete', $notice);

        if (empty($notice)) {
            Flash::error('Notice not found');

            return redirect(route('notices.index'));
        }

        $this->noticeRepository->delete($id);

        Flash::success('Notice deleted successfully.');

        return redirect(route('notices.index'));
    }

    public function repoCreate($data)
    {
        $this->noticeRepository->create((array)$data);
    }

    public function ajaxOwner(Request $request)
    {
        $notice = Notice::find($request->id);
        $model_name =  $request['model_name'];
        $model = new $model_name();
        $models = $model::all();
        $owners = collect();
        $manage_histories = Auth::user()->under_managment();
        foreach ($manage_histories as $manage_history){
            foreach ($models as $model){
                if($manage_history->managed == $model){
                    if (isset($notice)){
                        if ($notice->owner_type == $model_name && $notice->owner_id == $model->id){
                            $model['selected'] = true;
                        }
                    }
                    $owners->push($model);
                }
            }
        }
        return $owners;
    }
}
