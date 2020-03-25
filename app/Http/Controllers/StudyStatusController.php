<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudyStatusRequest;
use App\Http\Requests\UpdateStudyStatusRequest;
use App\Repositories\StudyStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class StudyStatusController extends AppBaseController
{
    /** @var  StudyStatusRepository */
    private $studyStatusRepository;

    public function __construct(StudyStatusRepository $studyStatusRepo)
    {
        $this->studyStatusRepository = $studyStatusRepo;
    }

    /**
     * Display a listing of the StudyStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->studyStatusRepository->pushCriteria(new RequestCriteria($request));
        $studyStatuses = $this->studyStatusRepository->all();

        return view('study_statuses.index')
            ->with('studyStatuses', $studyStatuses);
    }

    /**
     * Show the form for creating a new StudyStatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('study_statuses.create');
    }

    /**
     * Store a newly created StudyStatus in storage.
     *
     * @param CreateStudyStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateStudyStatusRequest $request)
    {
        $input = $request->all();

        $studyStatus = $this->studyStatusRepository->create($input);

        Flash::success('Study Status saved successfully.');

        return redirect(route('studyStatuses.index'));
    }

    /**
     * Display the specified StudyStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $studyStatus = $this->studyStatusRepository->findWithoutFail($id);

        if (empty($studyStatus)) {
            Flash::error('Study Status not found');

            return redirect(route('studyStatuses.index'));
        }

        return view('study_statuses.show')->with('studyStatus', $studyStatus);
    }

    /**
     * Show the form for editing the specified StudyStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $studyStatus = $this->studyStatusRepository->findWithoutFail($id);

        if (empty($studyStatus)) {
            Flash::error('Study Status not found');

            return redirect(route('studyStatuses.index'));
        }

        return view('study_statuses.edit')->with('studyStatus', $studyStatus);
    }

    /**
     * Update the specified StudyStatus in storage.
     *
     * @param  int              $id
     * @param UpdateStudyStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStudyStatusRequest $request)
    {
        $studyStatus = $this->studyStatusRepository->findWithoutFail($id);

        if (empty($studyStatus)) {
            Flash::error('Study Status not found');

            return redirect(route('studyStatuses.index'));
        }

        $studyStatus = $this->studyStatusRepository->update($request->all(), $id);

        Flash::success('Study Status updated successfully.');

        return redirect(route('studyStatuses.index'));
    }

    /**
     * Remove the specified StudyStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $studyStatus = $this->studyStatusRepository->findWithoutFail($id);

        if (empty($studyStatus)) {
            Flash::error('Study Status not found');

            return redirect(route('studyStatuses.index'));
        }

        $this->studyStatusRepository->delete($id);

        Flash::success('Study Status deleted successfully.');

        return redirect(route('studyStatuses.index'));
    }
}
