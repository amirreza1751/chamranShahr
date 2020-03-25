<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateManageLevelRequest;
use App\Http\Requests\UpdateManageLevelRequest;
use App\Repositories\ManageLevelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ManageLevelController extends AppBaseController
{
    /** @var  ManageLevelRepository */
    private $manageLevelRepository;

    public function __construct(ManageLevelRepository $manageLevelRepo)
    {
        $this->manageLevelRepository = $manageLevelRepo;
    }

    /**
     * Display a listing of the ManageLevel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->manageLevelRepository->pushCriteria(new RequestCriteria($request));
        $manageLevels = $this->manageLevelRepository->all();

        return view('manage_levels.index')
            ->with('manageLevels', $manageLevels);
    }

    /**
     * Show the form for creating a new ManageLevel.
     *
     * @return Response
     */
    public function create()
    {
        return view('manage_levels.create');
    }

    /**
     * Store a newly created ManageLevel in storage.
     *
     * @param CreateManageLevelRequest $request
     *
     * @return Response
     */
    public function store(CreateManageLevelRequest $request)
    {
        $input = $request->all();

        $manageLevel = $this->manageLevelRepository->create($input);

        Flash::success('Manage Level saved successfully.');

        return redirect(route('manageLevels.index'));
    }

    /**
     * Display the specified ManageLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $manageLevel = $this->manageLevelRepository->findWithoutFail($id);

        if (empty($manageLevel)) {
            Flash::error('Manage Level not found');

            return redirect(route('manageLevels.index'));
        }

        return view('manage_levels.show')->with('manageLevel', $manageLevel);
    }

    /**
     * Show the form for editing the specified ManageLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $manageLevel = $this->manageLevelRepository->findWithoutFail($id);

        if (empty($manageLevel)) {
            Flash::error('Manage Level not found');

            return redirect(route('manageLevels.index'));
        }

        return view('manage_levels.edit')->with('manageLevel', $manageLevel);
    }

    /**
     * Update the specified ManageLevel in storage.
     *
     * @param  int              $id
     * @param UpdateManageLevelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateManageLevelRequest $request)
    {
        $manageLevel = $this->manageLevelRepository->findWithoutFail($id);

        if (empty($manageLevel)) {
            Flash::error('Manage Level not found');

            return redirect(route('manageLevels.index'));
        }

        $manageLevel = $this->manageLevelRepository->update($request->all(), $id);

        Flash::success('Manage Level updated successfully.');

        return redirect(route('manageLevels.index'));
    }

    /**
     * Remove the specified ManageLevel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $manageLevel = $this->manageLevelRepository->findWithoutFail($id);

        if (empty($manageLevel)) {
            Flash::error('Manage Level not found');

            return redirect(route('manageLevels.index'));
        }

        $this->manageLevelRepository->delete($id);

        Flash::success('Manage Level deleted successfully.');

        return redirect(route('manageLevels.index'));
    }
}
