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
        $this->noticeRepository->pushCriteria(new RequestCriteria($request));
        $notices = $this->noticeRepository->all();

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
        $creators = User::all()->pluck('full_name_scu_id', 'id');
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

        $notice = $this->noticeRepository->create($input);

        Flash::success('Notice saved successfully.');

        return redirect(route('notices.index'));
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

        if (empty($notice)) {
            Flash::error('Notice not found');

            return redirect(route('notices.index'));
        }

        $notice = $this->noticeRepository->update($request->all(), $id);

        Flash::success('Notice updated successfully.');

        return redirect(route('notices.index'));
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
        foreach ($models as $model){
            if (isset($notice)){
                if ($notice->owner_type == $model_name && $notice->owner_id == $model->id){
                    $model['selected'] = true;
                }
            }
        }
        return $models;
    }
}
