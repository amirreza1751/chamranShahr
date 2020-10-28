<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExternalServiceRequest;
use App\Http\Requests\UpdateExternalServiceRequest;
use App\Models\Department;
use App\Models\ExternalService;
use App\Models\ExternalServiceType;
use App\Models\News;
use App\Models\Notice;
use App\Repositories\ExternalServiceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ExternalServiceController extends AppBaseController
{
    /** @var  ExternalServiceRepository */
    private $externalServiceRepository;
    private $content_types = [
        'Notice' => Notice::class,
        'News' => News::class,
    ];
    private $owner_types = [
        'Department' => Department::class,
    ];

    public function __construct(ExternalServiceRepository $externalServiceRepo)
    {
        $this->externalServiceRepository = $externalServiceRepo;
    }

    /**
     * Display a listing of the ExternalService.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->externalServiceRepository->pushCriteria(new RequestCriteria($request));


        if (Auth::user()->hasRole('developer')) {
            $externalServices = $this->externalServiceRepository->all();
        } elseif (Auth::user()->hasRole('admin')) {
            $externalServices = $this->externalServiceRepository->all();
        } elseif (Auth::user()->hasRole('content_manager')) {
            $externalServices = $this->externalServiceRepository->all();
        } else {
            $externalServices = collect();
            $manage_histories = Auth::user()->under_managment();
            foreach ($manage_histories as $manage_history) {
                if (isset($manage_history->managed)) {
                    $department = Department::where('id', $manage_history->managed->id)->first();
                    if (isset($department)){
                        foreach ($department->externalServices as $externalService){
                            $externalServices->push($externalService);
                        }
                    }
                }
            }
        }

        return view('external_services.index')
            ->with('externalServices', $externalServices);
    }

    /**
     * Show the form for creating a new ExternalService.
     *
     * @return Response
     */
    public function create()
    {
        return view('external_services.create')
            ->with('external_service_types', ExternalServiceType::all()->pluck('title', 'id'))
            ->with('content_types', $this->content_types)
            ->with('owner_types', $this->owner_types);
    }

    /**
     * Store a newly created ExternalService in storage.
     *
     * @param CreateExternalServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateExternalServiceRequest $request)
    {
        $input = $request->all();

        $externalService = $this->externalServiceRepository->create($input);

        Flash::success('سرویس خارجی با موفقیت ذخیره شد');

        return redirect(route('externalServices.index'));
    }

    /**
     * Display the specified ExternalService.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            Flash::error('سرویس خراجی پیدا نشد');

            return redirect(route('externalServices.index'));
        }

        return view('external_services.show')->with('externalService', $externalService);
    }

    /**
     * Show the form for editing the specified ExternalService.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $external_service = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($external_service)) {
            Flash::error('سرویس خارجی پیدا نشد');

            return redirect(route('externalServices.index'));
        }

        return view('external_services.edit')->with('external_service', $external_service)
            ->with('external_service_types', ExternalServiceType::all()->pluck('title', 'id'))
            ->with('content_types', $this->content_types)
            ->with('owner_types', $this->owner_types);
    }

    /**
     * Update the specified ExternalService in storage.
     *
     * @param  int              $id
     * @param UpdateExternalServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExternalServiceRequest $request)
    {
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            Flash::error('سروسی خارجی پیدا نشد');

            return redirect(route('externalServices.index'));
        }

        $externalService = $this->externalServiceRepository->update($request->all(), $id);

        Flash::success('سرویس خارجی باموفقیت به روز رسانی شد ');

        return redirect(route('externalServices.index'));
    }

    /**
     * Remove the specified ExternalService from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            Flash::error('سرویس خارجی پیدا نشد');

            return redirect(route('externalServices.index'));
        }

        $this->externalServiceRepository->delete($id);

        Flash::success('سرویس خارجی باموفقیت حذف شد');

        return redirect(route('externalServices.index'));
    }

    public function ajaxOwner(Request $request)
    {

        $external_service = ExternalService::find($request->id);
        $model_name =  $request['model_name'];
        $model = new $model_name();
        $models = collect();

        if (Auth::user()->hasRole('developer')) {
            $models = $model::all();
        } elseif (Auth::user()->hasRole('admin')) {
            $models = $model::all();
        } elseif (Auth::user()->hasRole('content_manager')) {
            $models = $model::all();
        } elseif(Auth::user()->hasRole('manager')) {
            $manage_histories = Auth::user()->under_managment();
            foreach ($manage_histories as $manage_history) {
                if (isset($manage_history->managed)) {
                    $model = $model_name::where('id', $manage_history->managed->id)->first();
                    if (isset($model)){
                        $models->push($model);
                    }
                }
            }
        }

        foreach ($models as $model){
            if (isset($external_service)){
                if ($external_service->owner_type == $model_name && $external_service->owner_id == $model->id){
                    $model['selected'] = true;
                }
            }
        }
        return $models;
    }

    public function fetch($id)
    {
        echo '<html>
<head>
    <style>
        .center-screen {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 100vh;
            font-weight: 800;
            direction: rtl;
        }
        .center-screen > p {
            max-width: 300px;
            padding: 20px;
            border: white solid 1px;
            border-radius: 0.5rem;
            background: whitesmoke;
        }
        body {
            background-color: #3c8dbc;
        }
    </style>
</head>
<body>
<div class="center-screen">
    <p>فرایند استخراج اطلاعات از سرویس خارجی ممکن است تا چند دقیقه زمان ببرد. لطفا تا پایان فرایند و انتقال به صفحه‌ی نتایج شکیبا باشید.</p>
</div>
</body>
</html>';

        try {
            $single_fetch_exitcode = Artisan::call('news:single_fetch', ['id' => $id]);
        } catch (\Exception $e) {
            Flash::error('به روزرسانی محتوای سرویس خارجی موفقیت آمیز نبود. لطفا مجددا تلاش کنید');

            return redirect(route('externalServices.index'));
        }

        Flash::success('محتوای سرویس خارجی باموفقیت به روز رسانی شد');

        return redirect(route('news.index'));

    }
}
