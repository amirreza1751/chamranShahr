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
        $externalServices = $this->externalServiceRepository->all();

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

        Flash::success('External Service saved successfully.');

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
            Flash::error('External Service not found');

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
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            Flash::error('External Service not found');

            return redirect(route('externalServices.index'));
        }

        return view('external_services.edit')->with('externalService', $externalService);
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
            Flash::error('External Service not found');

            return redirect(route('externalServices.index'));
        }

        $externalService = $this->externalServiceRepository->update($request->all(), $id);

        Flash::success('External Service updated successfully.');

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
            Flash::error('External Service not found');

            return redirect(route('externalServices.index'));
        }

        $this->externalServiceRepository->delete($id);

        Flash::success('External Service deleted successfully.');

        return redirect(route('externalServices.index'));
    }

    public function ajaxOwner(Request $request)
    {
        $external_service = ExternalService::find($request->id);
        $model_name =  $request['model_name'];
        $model = new $model_name();
        $models = $model::all();
        foreach ($models as $model){
            if (isset($external_service)){
                if ($external_service->owner_type == $model_name && $external_service->owner_id == $model->id){
                    $model['selected'] = true;
                }
            }
        }
        return $models;
    }
}
