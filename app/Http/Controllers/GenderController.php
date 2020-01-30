<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGenderRequest;
use App\Http\Requests\UpdateGenderRequest;
use App\Repositories\GenderRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GenderController extends AppBaseController
{
    /** @var  GenderRepository */
    private $genderRepository;

    public function __construct(GenderRepository $genderRepo)
    {
        $this->genderRepository = $genderRepo;
    }

    /**
     * Display a listing of the Gender.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->genderRepository->pushCriteria(new RequestCriteria($request));
        $genders = $this->genderRepository->all();

        return view('genders.index')
            ->with('genders', $genders);
    }

    /**
     * Show the form for creating a new Gender.
     *
     * @return Response
     */
    public function create()
    {
        return view('genders.create');
    }

    /**
     * Store a newly created Gender in storage.
     *
     * @param CreateGenderRequest $request
     *
     * @return Response
     */
    public function store(CreateGenderRequest $request)
    {
        $input = $request->all();

        $gender = $this->genderRepository->create($input);

        Flash::success('Gender saved successfully.');

        return redirect(route('genders.index'));
    }

    /**
     * Display the specified Gender.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $gender = $this->genderRepository->findWithoutFail($id);

        if (empty($gender)) {
            Flash::error('Gender not found');

            return redirect(route('genders.index'));
        }

        return view('genders.show')->with('gender', $gender);
    }

    /**
     * Show the form for editing the specified Gender.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $gender = $this->genderRepository->findWithoutFail($id);

        if (empty($gender)) {
            Flash::error('Gender not found');

            return redirect(route('genders.index'));
        }

        return view('genders.edit')->with('gender', $gender);
    }

    /**
     * Update the specified Gender in storage.
     *
     * @param  int              $id
     * @param UpdateGenderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGenderRequest $request)
    {
        $gender = $this->genderRepository->findWithoutFail($id);

        if (empty($gender)) {
            Flash::error('Gender not found');

            return redirect(route('genders.index'));
        }

        $gender = $this->genderRepository->update($request->all(), $id);

        Flash::success('Gender updated successfully.');

        return redirect(route('genders.index'));
    }

    /**
     * Remove the specified Gender from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $gender = $this->genderRepository->findWithoutFail($id);

        if (empty($gender)) {
            Flash::error('Gender not found');

            return redirect(route('genders.index'));
        }

        $this->genderRepository->delete($id);

        Flash::success('Gender deleted successfully.');

        return redirect(route('genders.index'));
    }
}
