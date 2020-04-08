<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExternalServiceTypeRequest;
use App\Http\Requests\UpdateExternalServiceTypeRequest;
use App\Repositories\ExternalServiceTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ExternalServiceTypeController extends AppBaseController
{
    /** @var  ExternalServiceTypeRepository */
    private $externalServiceTypeRepository;

    public function __construct(ExternalServiceTypeRepository $externalServiceTypeRepo)
    {
        $this->externalServiceTypeRepository = $externalServiceTypeRepo;
    }

    /**
     * Display a listing of the ExternalServiceType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->externalServiceTypeRepository->pushCriteria(new RequestCriteria($request));
        $externalServiceTypes = $this->externalServiceTypeRepository->all();

        return view('external_service_types.index')
            ->with('externalServiceTypes', $externalServiceTypes);
    }

    /**
     * Show the form for creating a new ExternalServiceType.
     *
     * @return Response
     */
    public function create()
    {
        return view('external_service_types.create');
    }

    /**
     * Store a newly created ExternalServiceType in storage.
     *
     * @param CreateExternalServiceTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateExternalServiceTypeRequest $request)
    {
        $input = $request->all();

        $externalServiceType = $this->externalServiceTypeRepository->create($input);

        Flash::success('External Service Type saved successfully.');

        return redirect(route('externalServiceTypes.index'));
    }

    /**
     * Display the specified ExternalServiceType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $externalServiceType = $this->externalServiceTypeRepository->findWithoutFail($id);

        if (empty($externalServiceType)) {
            Flash::error('External Service Type not found');

            return redirect(route('externalServiceTypes.index'));
        }

        return view('external_service_types.show')->with('externalServiceType', $externalServiceType);
    }

    /**
     * Show the form for editing the specified ExternalServiceType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $externalServiceType = $this->externalServiceTypeRepository->findWithoutFail($id);

        if (empty($externalServiceType)) {
            Flash::error('External Service Type not found');

            return redirect(route('externalServiceTypes.index'));
        }

        return view('external_service_types.edit')->with('externalServiceType', $externalServiceType);
    }

    /**
     * Update the specified ExternalServiceType in storage.
     *
     * @param  int              $id
     * @param UpdateExternalServiceTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExternalServiceTypeRequest $request)
    {
        $externalServiceType = $this->externalServiceTypeRepository->findWithoutFail($id);

        if (empty($externalServiceType)) {
            Flash::error('External Service Type not found');

            return redirect(route('externalServiceTypes.index'));
        }

        $externalServiceType = $this->externalServiceTypeRepository->update($request->all(), $id);

        Flash::success('External Service Type updated successfully.');

        return redirect(route('externalServiceTypes.index'));
    }

    /**
     * Remove the specified ExternalServiceType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $externalServiceType = $this->externalServiceTypeRepository->findWithoutFail($id);

        if (empty($externalServiceType)) {
            Flash::error('External Service Type not found');

            return redirect(route('externalServiceTypes.index'));
        }

        $this->externalServiceTypeRepository->delete($id);

        Flash::success('External Service Type deleted successfully.');

        return redirect(route('externalServiceTypes.index'));
    }
}
