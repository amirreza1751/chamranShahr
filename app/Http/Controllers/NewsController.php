<?php

namespace App\Http\Controllers;

use App\General\GeneralFunction;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\Department;
use App\Models\News;
use App\Repositories\NewsRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class NewsController extends AppBaseController
{
    /** @var  NewsRepository */
    private $newsRepository;
    private $owner_types = array(
        'Department' => Department::class,
    );

    public function __construct(NewsRepository $newsRepo)
    {
        $this->newsRepository = $newsRepo;
    }

    /**
     * Display a listing of the News.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->newsRepository->pushCriteria(new RequestCriteria($request));

        if (Auth::user()->hasRole('developer|admin|notice_manager')) {
            $news = $this->newsRepository->all();
        } else {
            $news = collect();
            $all = $this->newsRepository->all();
            $manage_histories = Auth::user()->under_managment();
            foreach ($all as $single_news) {
                foreach ($manage_histories as $manage_history) {
                    if (isset($single_news->owner_type) && isset($single_news->owner_id)) {
                        if (get_class($manage_history->managed) == $single_news->owner_type && $manage_history->managed->id == $single_news->owner_id) {
                            $news->push($single_news);
                        }
                    }
                }
            }
        }

        return view('news.index')
            ->with('news', $news->sortByDesc('updated_at'));
    }

    /**
     * Show the form for creating a new News.
     *
     * @return Response
     */
    public function create()
    {

        $creators = collect();
        if(Auth::user()->hasRole('developer|admin|content_manager|notification_manager')){
            $creators = User::all()->pluck('full_name_scu_id', 'id');
        }
        else {
            $creators = [
                Auth::user()->id => Auth::user()->getFullNameScuIdAttribute(),
            ];
        }
        return view('news.create')
            ->with('creators', $creators)
            ->with('owner_types', $this->owner_types);
    }

    /**
     * Store a newly created News in storage.
     *
     * @param CreateNewsRequest $request
     *
     * @return Response
     */
    public function store(CreateNewsRequest $request)
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

        if($request->hasFile('path')){
            $path = $request->file('path')->store('/public/news_images/'. app($input['owner_type'])->getTable() .'/'.$input['owner_id']);

            $gf = new GeneralFunction();

            $destinationPath = public_path('storage/news_images/'. app($input['owner_type'])->getTable() .'/'.$input['owner_id']);
            $file = Storage::get($path);
            $file_name = pathinfo(basename($path), PATHINFO_FILENAME); // file name
            $file_extension = pathinfo(basename($path), PATHINFO_EXTENSION); // file extension

            $gf->createThumbnail($destinationPath, $file, $file_name, $file_extension);

            $path = str_replace('public', 'storage', $path);
            $input['path'] = '/' . $path;
        } else {
            unset($input['path']);
        }

        $news = $this->newsRepository->create($input);

        Flash::success('خبر با موفقیت ایجاد شد');

        if($input['make_notification']){
            return redirect(route('notifications.showNotifyStudentsFromNotifier', [ get_class($news), $news->id ]));
        } else {
            return redirect(route('news.index'));
        }
    }

    /**
     * Display the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('خبر وجود ندارد');

            return redirect(route('news.index'));
        }

        return view('news.show')->with('news', $news);
    }

    /**
     * Show the form for editing the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('خبر وجود ندارد');

            return redirect(route('news.index'));
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
        return view('news.edit')->with('news', $news)
            ->with('creators', $creators)
            ->with('owner_types', $this->owner_types);
    }

    /**
     * Update the specified News in storage.
     *
     * @param  int              $id
     * @param UpdateNewsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNewsRequest $request)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('خبر وجود ندارد');

            return redirect(route('news.index'));
        }

        $creator = User::find($request['creator_id']);
        if (empty($creator)) {
            Flash::error('سازنده وجود ندارد');

            return redirect(route('news.edit'));
        }

        $owner = $request['owner_type']::find($request['owner_id']);
        if (empty($owner)) {
            Flash::error('مالک وجود ندارد');

            return redirect(route('news.edit'));
        }

        $input = $request->all();

        if($request->hasFile('path')){
            $path = $request->file('path')->store('/public/news_images/'. app($input['owner_type'])->getTable() .'/'.$input['owner_id']);

            /**
             * create thumbnail of the original image
             * this image will store with a postfix '-thumbnail' beside the original image
             */
            $gf = new GeneralFunction();

            $destinationPath = public_path('storage/news_images/'. app($input['owner_type'])->getTable() .'/'.$input['owner_id']);
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
            $file_name = 'storage\\news_images\\'. app($input['owner_type'])->getTable() .'\\'.$input['owner_id'].'\\'.last(explode('/', $news->path));
            if (is_file($file_name)){
                unlink($file_name); //delete old avatar

                $thumbnail_name = pathinfo(last(explode('/', $news->path)), PATHINFO_FILENAME); // file name
                $thumbnail_extension = pathinfo(last(explode('/', $news->path)), PATHINFO_EXTENSION); // file extension
                $thumbnail = 'storage\\news_images\\'. app($input['owner_type'])->getTable() .'\\'.$input['owner_id'].'\\'. $thumbnail_name . '-thumbnail.' . $thumbnail_extension;
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

        $news = $this->newsRepository->update($input, $id);

        Flash::success('خبر با موفقیت آپدیت شد');

        return redirect(route('news.index'));
    }

    /**
     * Remove the specified News from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('خبر وجود ندارد');

            return redirect(route('news.index'));
        }


        /**
         * delete old image,
         * to prevent Accumulation of dead files
         */
//        $file_name = 'storage\\news_images\\'. app($news->owner_type)->getTable() .'\\'.$news->owner_id.'\\'.last(explode('/', $news->path));
//        if (is_file($file_name)){
//            unlink($file_name); //delete old avatar
//
//            $thumbnail_name = pathinfo(last(explode('/', $news->path)), PATHINFO_FILENAME); // file name
//            $thumbnail_extension = pathinfo(last(explode('/', $news->path)), PATHINFO_EXTENSION); // file extension
//            $thumbnail = 'storage\\news_images\\'. app($news->owner_type)->getTable() .'\\'.$news->owner_id.'\\'. $thumbnail_name . '-thumbnail.' . $thumbnail_extension;
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

        $this->newsRepository->delete($id);

        Flash::success('خبر با موفقیت حذف شد');

        return redirect(route('news.index'));
    }

    public function repoCreate($data)
    {
        $this->newsRepository->create((array)$data);
    }

    /**
     * Display the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function publicShow($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('خبر مورد نظر وجود ندارد');

            return redirect()->back();
        }

        return view('news.public_show')->with('news', $news);
    }

    public function ajaxOwner(Request $request)
    {
        $news = News::find($request->id);
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
                        if (isset($news)){
                            if ($news->owner_type == $model_name && $news->owner_id == $model->id){
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
}
