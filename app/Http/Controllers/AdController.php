<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Repositories\AdRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdController extends AppBaseController
{
    /** @var  AdRepository */
    private $adRepository;
    private $bookRepository;

    public function __construct(AdRepository $adRepo, BookRepository $bookRepo)
    {
        $this->adRepository = $adRepo;
        $this->bookRepository = $bookRepo;
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









    public function verify_ad($id){
        /** Admin can change the status of advertisement from pending to accepted. */


        /**  Check for Admin Role
         *
         *  !!!Only Admin Role!!!
         *
        /** Check for Admin Role */

        if (!Auth('web')->user()->hasRole('admin') || !Auth('web')->user()->hasRole('developer')){
            Flash::error('You do not have the "admin" role.');

            return redirect(route('ads.index'));
        }

        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            Flash::error('Ad not found');

            return redirect(route('ads.index'));
        }

        if ($ad->is_verified == 0){
            $ad->is_verified = 1;
        } else{
            $ad->is_verified = 0;
        }
        $ad->save();

//        Flash::success('Changes saved.');
//return response()->json(['message' => $ad->is_verified]);
        return redirect(route('ads.index'));
    }

    public function toggle_special_book_ad(){
        /** Admin can set an advertisement to special or not. */

    }

    public function show_advertisable($id){
        $ad = $this->adRepository->with(['adType', 'category', 'advertisable.size', 'advertisable.language', 'advertisable.edition'])->where('id', $id)->first();
        return $ad;
    }



}
