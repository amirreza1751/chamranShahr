<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudyAreaRequest;
use App\Http\Requests\UpdateStudyAreaRequest;
use App\Repositories\StudyAreaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class StudyAreaController extends AppBaseController
{
    /** @var  StudyAreaRepository */
    private $studyAreaRepository;

    public function __construct(StudyAreaRepository $studyAreaRepo)
    {
        $this->studyAreaRepository = $studyAreaRepo;
    }

    /**
     * Display a listing of the StudyArea.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->studyAreaRepository->pushCriteria(new RequestCriteria($request));
        $studyAreas = $this->studyAreaRepository->all();

        return view('study_areas.index')
            ->with('studyAreas', $studyAreas);
    }

    /**
     * Show the form for creating a new StudyArea.
     *
     * @return Response
     */
    public function create()
    {
        return view('study_areas.create');
    }

    /**
     * Store a newly created StudyArea in storage.
     *
     * @param CreateStudyAreaRequest $request
     *
     * @return Response
     */
    public function store(CreateStudyAreaRequest $request)
    {
        $input = $request->all();

        $studyArea = $this->studyAreaRepository->create($input);

        Flash::success('Study Area saved successfully.');

        return redirect(route('studyAreas.index'));
    }

    /**
     * Display the specified StudyArea.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $studyArea = $this->studyAreaRepository->findWithoutFail($id);

        if (empty($studyArea)) {
            Flash::error('Study Area not found');

            return redirect(route('studyAreas.index'));
        }

        return view('study_areas.show')->with('studyArea', $studyArea);
    }

    /**
     * Show the form for editing the specified StudyArea.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $studyArea = $this->studyAreaRepository->findWithoutFail($id);

        if (empty($studyArea)) {
            Flash::error('Study Area not found');

            return redirect(route('studyAreas.index'));
        }

        return view('study_areas.edit')->with('studyArea', $studyArea);
    }

    /**
     * Update the specified StudyArea in storage.
     *
     * @param  int              $id
     * @param UpdateStudyAreaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStudyAreaRequest $request)
    {
        $studyArea = $this->studyAreaRepository->findWithoutFail($id);

        if (empty($studyArea)) {
            Flash::error('Study Area not found');

            return redirect(route('studyAreas.index'));
        }

        $studyArea = $this->studyAreaRepository->update($request->all(), $id);

        Flash::success('Study Area updated successfully.');

        return redirect(route('studyAreas.index'));
    }

    /**
     * Remove the specified StudyArea from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $studyArea = $this->studyAreaRepository->findWithoutFail($id);

        if (empty($studyArea)) {
            Flash::error('Study Area not found');

            return redirect(route('studyAreas.index'));
        }

        $this->studyAreaRepository->delete($id);

        Flash::success('Study Area deleted successfully.');

        return redirect(route('studyAreas.index'));
    }
}
