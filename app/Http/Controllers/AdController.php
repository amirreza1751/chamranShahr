<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Repositories\AdRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdController extends AppBaseController
{
    /** @var  AdRepository */
    private $adRepository;

    public function __construct(AdRepository $adRepo)
    {
        $this->adRepository = $adRepo;
    }

    /**
     * Display a listing of the Ad.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->adRepository->pushCriteria(new RequestCriteria($request));
        $ads = $this->adRepository->all();

        return view('ads.index')
            ->with('ads', $ads);
    }

    /**
     * Show the form for creating a new Ad.
     *
     * @return Response
     */
    public function create()
    {
        return view('ads.create');
    }

    /**
     * Store a newly created Ad in storage.
     *
     * @param CreateAdRequest $request
     *
     * @return Response
     */
    public function store(CreateAdRequest $request)
    {
        $input = $request->all();

        $ad = $this->adRepository->create($input);

        Flash::success('Ad saved successfully.');

        return redirect(route('ads.index'));
    }

    /**
     * Display the specified Ad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            Flash::error('Ad not found');

            return redirect(route('ads.index'));
        }

        return view('ads.show')->with('ad', $ad);
    }

    /**
     * Show the form for editing the specified Ad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            Flash::error('Ad not found');

            return redirect(route('ads.index'));
        }

        return view('ads.edit')->with('ad', $ad);
    }

    /**
     * Update the specified Ad in storage.
     *
     * @param  int              $id
     * @param UpdateAdRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdRequest $request)
    {
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            Flash::error('Ad not found');

            return redirect(route('ads.index'));
        }

        $ad = $this->adRepository->update($request->all(), $id);

        Flash::success('Ad updated successfully.');

        return redirect(route('ads.index'));
    }

    /**
     * Remove the specified Ad from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            Flash::error('Ad not found');

            return redirect(route('ads.index'));
        }

        $this->adRepository->delete($id);

        Flash::success('Ad deleted successfully.');

        return redirect(route('ads.index'));
    }
}
