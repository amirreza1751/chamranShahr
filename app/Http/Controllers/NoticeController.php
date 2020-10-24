<?php

namespace App\Http\Controllers;

use App\General\GeneralFunction;
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
use Illuminate\Support\Facades\Storage;
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

        if (Auth::user()->hasRole('developer|admin|notification_manager')) {
            $notices = $this->noticeRepository->all();
        }
        else {
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
            ->with('notices', $notices->sortByDesc('updated_at'));
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
        if(Auth::user()->hasRole('developer|admin|content_manager|notification_manager')){
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
            Flash::error('سازنده وجود ندارد');

            return redirect(route('notices.create'));
        }

        $owner = $input['owner_type']::find($input['owner_id']);
        if (empty($owner)) {
            Flash::error('مالک وجود ندارد');

            return redirect(route('notices.create'));
        }

        $this->authorize('store', [ $owner, $creator ]);

        if($request->hasFile('path')){
            $path = $request->file('path')->store('/public/notices_images/'. app($input['owner_type'])->getTable() .'/'.$input['owner_id']);

            $gf = new GeneralFunction();

            $destinationPath = public_path('storage/notices_images/'. app($input['owner_type'])->getTable() .'/'.$input['owner_id']);
            $file = Storage::get($path);
            $file_name = pathinfo(basename($path), PATHINFO_FILENAME); // file name
            $file_extension = pathinfo(basename($path), PATHINFO_EXTENSION); // file extension

            $gf->createThumbnail($destinationPath, $file, $file_name, $file_extension);

            $path = str_replace('public', 'storage', $path);
            $input['path'] = '/' . $path;
        } else {
            unset($input['path']);
        }

        $notice = $this->noticeRepository->create($input);

        Flash::success('اطلاعیه با موفقیت ایجاد شد');

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
            Flash::error('اطلاعیه وجود ندارد');

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
            Flash::error('اطلاعیه وجود ندارد');

            return redirect(route('notices.index'));
        }

        $creators = collect();
        if(Auth::user()->hasRole('developer|admin|content_manager|notification_manager')){
            $creators = User::all()->pluck('full_name_scu_id', 'id');
        }
        else {
            $creators = [
                Auth::user()->id => Auth::user()->getFullNameScuIdAttribute(),
            ];
        }
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
            Flash::error('اطلاعیه وجود ندارد');

            return redirect(route('notices.index'));
        }

        $creator = User::find($request['creator_id']);
        if (empty($creator)) {
            Flash::error('سازنده وجود ندارد');

            return redirect(route('notices.edit'));
        }

        $owner = $request['owner_type']::find($request['owner_id']);
        if (empty($owner)) {
            Flash::error('مالک وجود ندارد');

            return redirect(route('notices.edit'));
        }

        $input = $request->all();

        if($request->hasFile('path')){
            $path = $request->file('path')->store('/public/notices_images/'. app($input['owner_type'])->getTable() .'/'.$input['owner_id']);

            /**
             * create thumbnail of the original image
             * this image will store with a postfix '-thumbnail' beside the original image
             */
            $gf = new GeneralFunction();

            $destinationPath = public_path('storage/notices_images/'. app($input['owner_type'])->getTable() .'/'.$input['owner_id']);
            $file = Storage::get($path);
            $file_name = pathinfo(basename($path), PATHINFO_FILENAME); // file name
            $file_extension = pathinfo(basename($path), PATHINFO_EXTENSION); // file extension

            $gf->createThumbnail($destinationPath, $file, $file_name, $file_extension);

            $path = str_replace('public', 'storage', $path);
            $input['path'] = '/' . $path;

            /**
             * delete old image,
             * to prevent Accumulation of dead files
             */
            $file_name = 'storage\\notices_images\\'. app($input['owner_type'])->getTable() .'\\'.$input['owner_id'].'\\'.last(explode('/', $notice->path));
            if (is_file($file_name)){
                unlink($file_name); //delete old avatar

                $thumbnail_name = pathinfo(last(explode('/', $notice->path)), PATHINFO_FILENAME); // file name
                $thumbnail_extension = pathinfo(last(explode('/', $notice->path)), PATHINFO_EXTENSION); // file extension
                $thumbnail = 'storage\\notices_images\\'. app($input['owner_type'])->getTable() .'\\'.$input['owner_id'].'\\'. $thumbnail_name . '-thumbnail.' . $thumbnail_extension;
                if(is_file($thumbnail)){
                    unlink($thumbnail);
                }

                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln('حذف: ' . $file_name);
            } else {
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln('تصویر پیدا نشد.');
            }
        }

        $notice = $this->noticeRepository->update($input, $id);

        Flash::success('اطلاعیه با موفقیت به روز رسانی شد');

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
            Flash::error('اطلاعیه وجود ندارد');

            return redirect(route('notices.index'));
        }

        /**
         * delete old image,
         * to prevent Accumulation of dead files
         */
//        $file_name = 'storage\\notices_images\\'. app($notice->owner_type)->getTable() .'\\'.$notice->owner_id.'\\'.last(explode('/', $notice->path));
//        if (is_file($file_name)){
//            unlink($file_name); //delete old avatar
//
//            $thumbnail_name = pathinfo(last(explode('/', $notice->path)), PATHINFO_FILENAME); // file name
//            $thumbnail_extension = pathinfo(last(explode('/', $notice->path)), PATHINFO_EXTENSION); // file extension
//            $thumbnail = 'storage\\notices_images\\'. app($notice->owner_type)->getTable() .'\\'.$notice->owner_id.'\\'. $thumbnail_name . '-thumbnail.' . $thumbnail_extension;
//            if(is_file($thumbnail)){
//                unlink($thumbnail);
//            }
//
//            $out = new \Symfony\Component\Console\Output\ConsoleOutput();
//            $out->writeln('حذف: ' . $file_name);
//        } else {
//            $out = new \Symfony\Component\Console\Output\ConsoleOutput();
//            $out->writeln('تصویر پیدا نشد.');
//        }

        $this->noticeRepository->delete($id);

        Flash::success('اطلاعیه با موفقیت حذف شد');

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
        if(Auth::user()->hasRole('developer')){
            $owners = $models;
        }
        elseif (Auth::user()->hasRole('admin')){
            $owners = $models;
        }
        elseif (Auth::user()->hasRole('content_manager')){
            $owners = $models;
        }
        elseif (Auth::user()->hasRole('notification_manager')){
            $owners = $models;
        } elseif (sizeof(Auth::user()->under_managment()) > 0){
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
        }
        return $owners;
    }

    /**
     * Display the specified Notice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function publicShow($id)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

//        $this->authorize('view', $notice);

        if (empty($notice)) {
            Flash::error('اطلاعیه ی مورد نظر وجود ندارد');

            return redirect()->back();
        }

        return view('notices.public_show')->with('notice', $notice);
    }
}
