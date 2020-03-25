<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateManageHistoryRequest;
use App\Http\Requests\UpdateManageHistoryRequest;
use App\Repositories\ManageHistoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ManageHistoryController extends AppBaseController
{
    /** @var  ManageHistoryRepository */
    private $manageHistoryRepository;

    public function __construct(ManageHistoryRepository $manageHistoryRepo)
    {
        $this->manageHistoryRepository = $manageHistoryRepo;
    }

    /**
     * Display a listing of the ManageHistory.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->manageHistoryRepository->pushCriteria(new RequestCriteria($request));
        $manageHistories = $this->manageHistoryRepository->all();

        return view('manage_histories.index')
            ->with('manageHistories', $manageHistories);
    }

    /**
     * Show the form for creating a new ManageHistory.
     *
     * @return Response
     */
    public function create()
    {
        return view('manage_histories.create');
    }

    /**
     * Store a newly created ManageHistory in storage.
     *
     * @param CreateManageHistoryRequest $request
     *
     * @return Response
     */
    public function store(CreateManageHistoryRequest $request)
    {
        $input = $request->all();

        $manageHistory = $this->manageHistoryRepository->create($input);

        Flash::success('Manage History saved successfully.');

        return redirect(route('manageHistories.index'));
    }

    /**
     * Display the specified ManageHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $manageHistory = $this->manageHistoryRepository->findWithoutFail($id);

        if (empty($manageHistory)) {
            Flash::error('Manage History not found');

            return redirect(route('manageHistories.index'));
        }

        return view('manage_histories.show')->with('manageHistory', $manageHistory);
    }

    /**
     * Show the form for editing the specified ManageHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $manageHistory = $this->manageHistoryRepository->findWithoutFail($id);

        if (empty($manageHistory)) {
            Flash::error('Manage History not found');

            return redirect(route('manageHistories.index'));
        }

        return view('manage_histories.edit')->with('manageHistory', $manageHistory);
    }

    /**
     * Update the specified ManageHistory in storage.
     *
     * @param  int              $id
     * @param UpdateManageHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateManageHistoryRequest $request)
    {
        $manageHistory = $this->manageHistoryRepository->findWithoutFail($id);

        if (empty($manageHistory)) {
            Flash::error('Manage History not found');

            return redirect(route('manageHistories.index'));
        }

        $manageHistory = $this->manageHistoryRepository->update($request->all(), $id);

        Flash::success('Manage History updated successfully.');

        return redirect(route('manageHistories.index'));
    }

    /**
     * Remove the specified ManageHistory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $manageHistory = $this->manageHistoryRepository->findWithoutFail($id);

        if (empty($manageHistory)) {
            Flash::error('Manage History not found');

            return redirect(route('manageHistories.index'));
        }

        $this->manageHistoryRepository->delete($id);

        Flash::success('Manage History deleted successfully.');

        return redirect(route('manageHistories.index'));
    }
}
