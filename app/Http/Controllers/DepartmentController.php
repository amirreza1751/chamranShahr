<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentProfileRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\ManageLevel;
use App\Repositories\DepartmentRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Morilog\Jalali\Jalalian;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DepartmentController extends AppBaseController
{
    /** @var  DepartmentRepository */
    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * Display a listing of the Department.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->departmentRepository->pushCriteria(new RequestCriteria($request));

        if (Auth::user()->hasRole('developer')) {
            $departments = $this->departmentRepository->all();
        } elseif (Auth::user()->hasRole('admin')) {
            $departments = $this->departmentRepository->all();
        } elseif (Auth::user()->hasRole('department_manager')) {
            $departments = $this->departmentRepository->all();
        } else {
            $departments = collect();
            $manage_histories = Auth::user()->under_managment();
            foreach ($manage_histories as $manage_history) {
                if (isset($manage_history->managed)) {
                    $department = Department::where('id', $manage_history->managed->id)->first();
                    if (isset($department)){
                        $departments->push($department);
                    }
                }
            }
        }

        return view('departments.index')
            ->with('departments', $departments);
    }

    /**
     * Show the form for creating a new Department.
     *
     * @return Response
     */
    public function create()
    {
        return view('departments.create')
            ->with('manage_levels', ManageLevel::all()->pluck('management_title_level', 'id'));
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param CreateDepartmentRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $input = $request->all();

        $department = $this->departmentRepository->create($input);

        Flash::success('Department saved successfully.');

        return redirect(route('departments.index'));
    }

    /**
     * Display the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect(route('departments.index'));
        }

        return view('departments.show')->with('department', $department);
    }

    /**
     * Show the form for editing the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect(route('departments.index'));
        }

        return view('departments.edit')->with('department', $department)
            ->with('manage_levels', ManageLevel::all()->pluck('management_title_level', 'id'));
    }

    /**
     * Update the specified Department in storage.
     *
     * @param  int              $id
     * @param UpdateDepartmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentRequest $request)
    {
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect(route('departments.index'));
        }

        $department = $this->departmentRepository->update($request->all(), $id);

        Flash::success('Department updated successfully.');

        return redirect(route('departments.index'));
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect(route('departments.index'));
        }

        $this->departmentRepository->delete($id);

        Flash::success('Department deleted successfully.');

        return redirect(route('departments.index'));
    }

    /**
     *******************************************************************************************************************
     *******************************************************************************************************************
     *************************************************** CUSTOMIZATION *************************************************
     *******************************************************************************************************************
     *******************************************************************************************************************
     */

    public function profile($id)
    {
//        $this->authorize('showProfile', User::class);

        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            Flash::error('همچین مدیریتی وجود ندارد');

            return redirect()->back();
        }

        return view('departments.profile')
            ->with('department', $department);
    }

    public function editProfile($id)
    {
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            Flash::error('مدیریت مورد نظر وجود ندارد');

            return redirect()->back();
        }

//        $this->authorize('updateProfile', $department);

        return view('departments.edit_profile')
            ->with('department', $department);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function updateProfile($id, UpdateDepartmentProfileRequest $request)
    {
        $department = $this->departmentRepository->findWithoutFail($id);
        $input = collect(request()->only(['title', 'english_title', 'description', 'path']))->filter(function($value) {
            return null !== $value;
        })->toArray();

        if (empty($department)) {
            Flash::error('مدیریت مورد نظر وجود ندارد');

            return redirect()->back();
        }

//        $this->authorize('updateProfile', $user);

        if($request->hasFile('path')){
            $path = $request->file('path')->store('/public/departments/cover');
            $path = str_replace('public', 'storage', $path);
            $input['path'] = '/'.$path;
        }

        $department = $this->departmentRepository->update($input, $department->id);

        Flash::success('صفحه‌ی مدیریت با موفقیت به روز شد');

        return redirect(route('departments.profile', [ $department->id ]));
    }

}
