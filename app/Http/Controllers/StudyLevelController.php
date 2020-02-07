<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudyLevelRequest;
use App\Http\Requests\UpdateStudyLevelRequest;
use App\Repositories\StudyLevelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class StudyLevelController extends AppBaseController
{
    /** @var  StudyLevelRepository */
    private $studyLevelRepository;

    public function __construct(StudyLevelRepository $studyLevelRepo)
    {
        $this->studyLevelRepository = $studyLevelRepo;
    }

    /**
     * Display a listing of the StudyLevel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->studyLevelRepository->pushCriteria(new RequestCriteria($request));
        $studyLevels = $this->studyLevelRepository->all();

        return view('study_levels.index')
            ->with('studyLevels', $studyLevels);
    }

    /**
     * Show the form for creating a new StudyLevel.
     *
     * @return Response
     */
    public function create()
    {
        return view('study_levels.create');
    }

    /**
     * Store a newly created StudyLevel in storage.
     *
     * @param CreateStudyLevelRequest $request
     *
     * @return Response
     */
    public function store(CreateStudyLevelRequest $request)
    {
        $input = $request->all();

        $studyLevel = $this->studyLevelRepository->create($input);

        Flash::success('Study Level saved successfully.');

        return redirect(route('studyLevels.index'));
    }

    /**
     * Display the specified StudyLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $studyLevel = $this->studyLevelRepository->findWithoutFail($id);

        if (empty($studyLevel)) {
            Flash::error('Study Level not found');

            return redirect(route('studyLevels.index'));
        }

        return view('study_levels.show')->with('studyLevel', $studyLevel);
    }

    /**
     * Show the form for editing the specified StudyLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $studyLevel = $this->studyLevelRepository->findWithoutFail($id);

        if (empty($studyLevel)) {
            Flash::error('Study Level not found');

            return redirect(route('studyLevels.index'));
        }

        return view('study_levels.edit')->with('studyLevel', $studyLevel);
    }

    /**
     * Update the specified StudyLevel in storage.
     *
     * @param  int              $id
     * @param UpdateStudyLevelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStudyLevelRequest $request)
    {
        $studyLevel = $this->studyLevelRepository->findWithoutFail($id);

        if (empty($studyLevel)) {
            Flash::error('Study Level not found');

            return redirect(route('studyLevels.index'));
        }

        $studyLevel = $this->studyLevelRepository->update($request->all(), $id);

        Flash::success('Study Level updated successfully.');

        return redirect(route('studyLevels.index'));
    }

    /**
     * Remove the specified StudyLevel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $studyLevel = $this->studyLevelRepository->findWithoutFail($id);

        if (empty($studyLevel)) {
            Flash::error('Study Level not found');

            return redirect(route('studyLevels.index'));
        }

        $this->studyLevelRepository->delete($id);

        Flash::success('Study Level deleted successfully.');

        return redirect(route('studyLevels.index'));
    }
}
