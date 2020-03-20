<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdTypeRequest;
use App\Http\Requests\UpdateAdTypeRequest;
use App\Repositories\AdTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdTypeController extends AppBaseController
{
    /** @var  AdTypeRepository */
    private $adTypeRepository;

    public function __construct(AdTypeRepository $adTypeRepo)
    {
        $this->adTypeRepository = $adTypeRepo;
    }

    /**
     * Display a listing of the AdType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->adTypeRepository->pushCriteria(new RequestCriteria($request));
        $adTypes = $this->adTypeRepository->all();

        return view('ad_types.index')
            ->with('adTypes', $adTypes);
    }

    /**
     * Show the form for creating a new AdType.
     *
     * @return Response
     */
    public function create()
    {
        return view('ad_types.create');
    }

    /**
     * Store a newly created AdType in storage.
     *
     * @param CreateAdTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateAdTypeRequest $request)
    {
        $input = $request->all();

        $adType = $this->adTypeRepository->create($input);

        Flash::success('Ad Type saved successfully.');

        return redirect(route('adTypes.index'));
    }

    /**
     * Display the specified AdType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $adType = $this->adTypeRepository->findWithoutFail($id);

        if (empty($adType)) {
            Flash::error('Ad Type not found');

            return redirect(route('adTypes.index'));
        }

        return view('ad_types.show')->with('adType', $adType);
    }

    /**
     * Show the form for editing the specified AdType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $adType = $this->adTypeRepository->findWithoutFail($id);

        if (empty($adType)) {
            Flash::error('Ad Type not found');

            return redirect(route('adTypes.index'));
        }

        return view('ad_types.edit')->with('adType', $adType);
    }

    /**
     * Update the specified AdType in storage.
     *
     * @param  int              $id
     * @param UpdateAdTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdTypeRequest $request)
    {
        $adType = $this->adTypeRepository->findWithoutFail($id);

        if (empty($adType)) {
            Flash::error('Ad Type not found');

            return redirect(route('adTypes.index'));
        }

        $adType = $this->adTypeRepository->update($request->all(), $id);

        Flash::success('Ad Type updated successfully.');

        return redirect(route('adTypes.index'));
    }

    /**
     * Remove the specified AdType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $adType = $this->adTypeRepository->findWithoutFail($id);

        if (empty($adType)) {
            Flash::error('Ad Type not found');

            return redirect(route('adTypes.index'));
        }

        $this->adTypeRepository->delete($id);

        Flash::success('Ad Type deleted successfully.');

        return redirect(route('adTypes.index'));
    }
}
