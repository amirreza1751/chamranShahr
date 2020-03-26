<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudyFieldRequest;
use App\Http\Requests\UpdateStudyFieldRequest;
use App\Repositories\StudyFieldRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class StudyFieldController extends AppBaseController
{
    /** @var  StudyFieldRepository */
    private $studyFieldRepository;

    public function __construct(StudyFieldRepository $studyFieldRepo)
    {
        $this->studyFieldRepository = $studyFieldRepo;
    }

    /**
     * Display a listing of the StudyField.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->studyFieldRepository->pushCriteria(new RequestCriteria($request));
        $studyFields = $this->studyFieldRepository->all();

        return view('study_fields.index')
            ->with('studyFields', $studyFields);
    }

    /**
     * Show the form for creating a new StudyField.
     *
     * @return Response
     */
    public function create()
    {
        return view('study_fields.create');
    }

    /**
     * Store a newly created StudyField in storage.
     *
     * @param CreateStudyFieldRequest $request
     *
     * @return Response
     */
    public function store(CreateStudyFieldRequest $request)
    {
        $input = $request->all();

        $studyField = $this->studyFieldRepository->create($input);

        Flash::success('Study Field saved successfully.');

        return redirect(route('studyFields.index'));
    }

    /**
     * Display the specified StudyField.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $studyField = $this->studyFieldRepository->findWithoutFail($id);

        if (empty($studyField)) {
            Flash::error('Study Field not found');

            return redirect(route('studyFields.index'));
        }

        return view('study_fields.show')->with('studyField', $studyField);
    }

    /**
     * Show the form for editing the specified StudyField.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $studyField = $this->studyFieldRepository->findWithoutFail($id);

        if (empty($studyField)) {
            Flash::error('Study Field not found');

            return redirect(route('studyFields.index'));
        }

        return view('study_fields.edit')->with('studyField', $studyField);
    }

    /**
     * Update the specified StudyField in storage.
     *
     * @param  int              $id
     * @param UpdateStudyFieldRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStudyFieldRequest $request)
    {
        $studyField = $this->studyFieldRepository->findWithoutFail($id);

        if (empty($studyField)) {
            Flash::error('Study Field not found');

            return redirect(route('studyFields.index'));
        }

        $studyField = $this->studyFieldRepository->update($request->all(), $id);

        Flash::success('Study Field updated successfully.');

        return redirect(route('studyFields.index'));
    }

    /**
     * Remove the specified StudyField from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $studyField = $this->studyFieldRepository->findWithoutFail($id);

        if (empty($studyField)) {
            Flash::error('Study Field not found');

            return redirect(route('studyFields.index'));
        }

        $this->studyFieldRepository->delete($id);

        Flash::success('Study Field deleted successfully.');

        return redirect(route('studyFields.index'));
    }
}
