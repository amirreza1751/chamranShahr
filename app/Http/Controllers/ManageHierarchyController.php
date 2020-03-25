<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateManageHierarchyRequest;
use App\Http\Requests\UpdateManageHierarchyRequest;
use App\Repositories\ManageHierarchyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ManageHierarchyController extends AppBaseController
{
    /** @var  ManageHierarchyRepository */
    private $manageHierarchyRepository;

    public function __construct(ManageHierarchyRepository $manageHierarchyRepo)
    {
        $this->manageHierarchyRepository = $manageHierarchyRepo;
    }

    /**
     * Display a listing of the ManageHierarchy.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->manageHierarchyRepository->pushCriteria(new RequestCriteria($request));
        $manageHierarchies = $this->manageHierarchyRepository->all();

        return view('manage_hierarchies.index')
            ->with('manageHierarchies', $manageHierarchies);
    }

    /**
     * Show the form for creating a new ManageHierarchy.
     *
     * @return Response
     */
    public function create()
    {
        return view('manage_hierarchies.create');
    }

    /**
     * Store a newly created ManageHierarchy in storage.
     *
     * @param CreateManageHierarchyRequest $request
     *
     * @return Response
     */
    public function store(CreateManageHierarchyRequest $request)
    {
        $input = $request->all();

        $manageHierarchy = $this->manageHierarchyRepository->create($input);

        Flash::success('Manage Hierarchy saved successfully.');

        return redirect(route('manageHierarchies.index'));
    }

    /**
     * Display the specified ManageHierarchy.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $manageHierarchy = $this->manageHierarchyRepository->findWithoutFail($id);

        if (empty($manageHierarchy)) {
            Flash::error('Manage Hierarchy not found');

            return redirect(route('manageHierarchies.index'));
        }

        return view('manage_hierarchies.show')->with('manageHierarchy', $manageHierarchy);
    }

    /**
     * Show the form for editing the specified ManageHierarchy.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $manageHierarchy = $this->manageHierarchyRepository->findWithoutFail($id);

        if (empty($manageHierarchy)) {
            Flash::error('Manage Hierarchy not found');

            return redirect(route('manageHierarchies.index'));
        }

        return view('manage_hierarchies.edit')->with('manageHierarchy', $manageHierarchy);
    }

    /**
     * Update the specified ManageHierarchy in storage.
     *
     * @param  int              $id
     * @param UpdateManageHierarchyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateManageHierarchyRequest $request)
    {
        $manageHierarchy = $this->manageHierarchyRepository->findWithoutFail($id);

        if (empty($manageHierarchy)) {
            Flash::error('Manage Hierarchy not found');

            return redirect(route('manageHierarchies.index'));
        }

        $manageHierarchy = $this->manageHierarchyRepository->update($request->all(), $id);

        Flash::success('Manage Hierarchy updated successfully.');

        return redirect(route('manageHierarchies.index'));
    }

    /**
     * Remove the specified ManageHierarchy from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $manageHierarchy = $this->manageHierarchyRepository->findWithoutFail($id);

        if (empty($manageHierarchy)) {
            Flash::error('Manage Hierarchy not found');

            return redirect(route('manageHierarchies.index'));
        }

        $this->manageHierarchyRepository->delete($id);

        Flash::success('Manage Hierarchy deleted successfully.');

        return redirect(route('manageHierarchies.index'));
    }
}
