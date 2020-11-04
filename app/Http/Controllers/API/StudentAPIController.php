<?php

namespace App\Http\Controllers\API;

use App\General\TimeHandling;
use App\Http\Controllers\API\Sama\SamaRequestController;
use App\Http\Requests\API\CreateStudentAPIRequest;
use App\Http\Requests\API\UpdateStudentAPIRequest;
use App\Models\Faculty;
use App\Models\Gender;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudyArea;
use App\Models\StudyField;
use App\Models\StudyLevel;
use App\Models\StudyStatus;
use App\Models\Term;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Morilog\Jalali\Jalalian;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class StudentController
 * @package App\Http\Controllers\API
 */

class StudentAPIController extends AppBaseController
{
    /** @var  StudentRepository */
    private $studentRepository;
    private $userRepository;

    public function __construct(StudentRepository $studentRepo, UserRepository $userRepo)
    {
        $this->studentRepository = $studentRepo;
        $this->userRepository = $userRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/students",
     *      summary="Get a listing of the Students.",
     *      tags={"Student"},
     *      description="Get all Students",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Student")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->studentRepository->pushCriteria(new RequestCriteria($request));
        $this->studentRepository->pushCriteria(new LimitOffsetCriteria($request));
        $students = $this->studentRepository->all();

        return $this->sendResponse($students->toArray(), 'Students retrieved successfully');
    }

    /**
     * @param CreateStudentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/students",
     *      summary="Store a newly created Student in storage",
     *      tags={"Student"},
     *      description="Store Student",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Student that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Student")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Student"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStudentAPIRequest $request)
    {
        $input = $request->all();

        $student = $this->studentRepository->create($input);

        return $this->sendResponse($student->toArray(), 'Student saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/students/{id}",
     *      summary="Display the specified Student",
     *      tags={"Student"},
     *      description="Get Student",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Student",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Student"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($id);

        if (empty($student)) {
            return $this->sendError('Student not found');
        }

        return $this->sendResponse($student->toArray(), 'Student retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateStudentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/{id}",
     *      summary="Update the specified Student in storage",
     *      tags={"Student"},
     *      description="Update Student",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Student",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Student that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Student")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Student"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStudentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($id);

        if (empty($student)) {
            return $this->sendError('Student not found');
        }

        $student = $this->studentRepository->update($input, $id);

        return $this->sendResponse($student->toArray(), 'Student updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/students/{id}",
     *      summary="Remove the specified Student from storage",
     *      tags={"Student"},
     *      description="Delete Student",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Student",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($id);

        if (empty($student)) {
            return $this->sendError('Student not found');
        }

        $student->delete();

        return $this->sendResponse($id, 'Student deleted successfully');
    }


    /**
     *******************************************************************************************************************
     *******************************************************************************************************************
     *************************************************** CUSTOMIZATION *************************************************
     *******************************************************************************************************************
     *******************************************************************************************************************
     */



    /**
     * @return Response
     *
     * @SWG\Delete(
     *      path="/students/hardDelete",
     *      summary="Hard Delete Student",
     *      tags={"Student"},
     *      description="hard Delete Student information of authenticated user",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function hardDelete()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        $student = Student::withTrashed()->where('user_id', $user->id)->first();

        if (empty($student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */

        $student->forceDelete();
        $user->removeRole('verified');
        $user->removeRole('student');
        $user->is_verified = false;
        $user->scu_id = null;
        $user->national_id = null;
        $user->save();

        return response()->json([
            'status' => 'دانشجو با موفقیت حذف شد.',
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * @SWG\Put(
     *      path="/students/verify",
     *      summary="Verify User (as student)",
     *      tags={"Student"},
     *      description="Verify University information (as student) of authenticated User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="scu_id",
     *          description="scu_id field of users table",
     *          type="integer",
     *          required=true,
     *          in="path",
     *      ),
     *      @SWG\Parameter(
     *          name="national_id",
     *          description="national_id field of users table",
     *          type="integer",
     *          required=true,
     *          in="path",
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Student"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function verify(Request $request)
    {
        $input = $request->all();

        /**
         * validate national_id field
         */
        $validator = Validator::make($input, [
            'national_id' => 'required|regex:/^[0-9]{10}$/',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'=> 'شماره ملی صحیح نیست',
            ]);
        }

        /**
         * validate scu_id field
         */
        $validator = Validator::make($input, [
            'scu_id' => 'required|regex:/^[0-9]{6,7}$/',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'=> 'شماره دانشجویی صحیح نیست',
            ]);
        }
        /** ************************************************************************************************/
//        $student_fetch = SamaRequestController::sama_request('StudentService', 'GetStudentPersonInfo', ['studentNumber' => $input['scu_id']]);
        /** ************************************************************************************************/

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        $input = $request->all();

		$student = Student::withTrashed()->where('user_id', $user->id)->first();

        if (isset($student) && $student->trashed()) { // user verified, but has soft deleted before
            $student->restore();
            $user->assignRole('verified');
            $user->assignRole('student');
            $user->is_verified = true;
            $user->save();


            $roles = array();
            foreach ($user->roles as $role){
                array_push($roles, $role->only(['name', 'guard_name']));
            }

            $user = collect($user->toArray())
                ->only([
                    'first_name',
                    'last_name',
                    'email',
                    'phone_number',
                    'birthday',
                    'username',
                    'gender_unique_code',
                    'scu_id',
                    'national_id',
                    'last_login',
                    'avatar_path',
                    'is_verified',
                    'updated_at',
                ])
                ->all();

            $user['roles'] = $roles;
            $user['student'] = $student;

            return response()->json([
                'success' => true,
                'message' => 'اطلاعات دانشگاهی کاربر با موفقیت بازیابی شد.',
                'user' => $user,
            ]);
        }
        elseif (isset($student)) { // verified user
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات دانشگاهی خود را قبلا احراز کرده‌اید',
            ]);
        }
        elseif (empty($student)) { // user not verified
            $check_scu_id = User::where('scu_id', $input['scu_id'])->first();
            $check_national_id = User::where('national_id', $input['national_id'])->first();

            if (isset($check_scu_id) || isset($check_national_id)){
                return response()->json([
                    'success' => false,
                    'message' => 'این اطلاعات قبلا احراز شده است. اگر از صحت اطلاعات اطمینان دارید، لطفا به مدیریت سامانه اطلاع دهید',
                ]);
            }
            try {
                $student_fetch = SamaRequestController::sama_request('StudentService', 'GetStudentPersonInfo', ['studentNumber' => $input['scu_id']]);
                if($student_fetch){ // requested scu_id is valid in SAMA db
                    if (isset($student_fetch->StudentNumber)){

                        if ($student_fetch->StudentNumber == $input['scu_id']) { // Student with entered Scu Id is exist

                            if (isset($student_fetch->Person)){

                                if (isset($student_fetch->Person->NationalCode)){

                                    if ($student_fetch->Person->NationalCode == $input['national_id']) { // matched entered national id with the Scu Id

                                        /**
                                         * validate Person BirthDate field
                                         */
                                        $validator = Validator::make(['date_string' => $student_fetch->Person->BirthDate], [
                                            'date_string' => ['required','regex:/(\d{3,4}(\/)(([0-9]|(0)[0-9])|((1)[0-2]))(\/)([0-9]|[0-2][0-9]|(3)[0-1]))$/'],
                                        ]);
                                        if (!$validator->fails()) {
                                            $birthday_array = explode('/', $student_fetch->Person->BirthDate);
                                            $year = $birthday_array[0];
                                            $month = $birthday_array[1];
                                            $day = $birthday_array[2];
                                            if (TimeHandling::validateJalalian(intval($year), intval($month), intval($day))){
                                                $birthday = new Jalalian($year, $month, $day);
                                            } else {
                                                $birthday = TimeHandling::parseJalalian($year, $month, $day);
                                            }
                                        }

                                        $user_information = array(
                                            'first_name' => $student_fetch->Person->FirstName,
                                            'last_name' => $student_fetch->Person->LastName,
                                            'birthday' => ($birthday)->toCarbon(),  // convert Solar date to A.D.
                                            'scu_id' => $student_fetch->StudentNumber,
                                            'national_id' => $student_fetch->Person->NationalCode,
                                            'updated_at' => Carbon::now(), // set update time
                                            'is_verified' => true,
                                        );

                                        if(isset($student_fetch->Person->Gender)){
                                            if (isset($student_fetch->Person->Gender->GenderId))
                                                $user_information['gender_unique_code'] = strtolower(array_last(explode("\\", Gender::class))) . $student_fetch->Person->Gender->GenderId;
                                            else
                                                $user_information['gender_unique_code'] = strtolower(array_last(explode("\\", Gender::class))) . 0;
                                        } else
                                            $user_information['gender_unique_code'] = strtolower(array_last(explode("\\", Gender::class))) . 0;

                                        if(empty($user->username)){
                                            $user_information['username'] = $student_fetch->StudentNumber;
                                        }

                                        $user = $this->userRepository->update($user_information, $user->id);

                                        $user->assignRole('verified');
                                        $user->assignRole('student');

                                        /**
                                         * static part of unique_code      CONCAT      numeric part of unique_code retrieve from SAMA
                                         * example:            studyarea [CONCAT] 500 : studyarea500
                                         * example:            term [CONCAT] 128 : term128
                                         * example:            studylevel [CONCAT] 2 : studylevel2
                                         * example:            studystatus [CONCAT] 2 : studystatus2
                                         */
                                        $student_information = array(
                                            'is_active' => $student_fetch->IsActive,
                                            'is_guest' => $student_fetch->IsGuest,
                                            'is_iranian' => $student_fetch->Person->IsIranian,
                                            'total_average' => $student_fetch->TotalAverage,
                                            'user_id' => $user->id,
                                        );

                                        if(isset($student_fetch->CourseStudy)){
                                            if (isset($student_fetch->CourseStudy->CourseStudyCode))
                                                $student_information['study_area_unique_code'] = strtolower(array_last(explode("\\", StudyArea::class))) . $student_fetch->CourseStudy->CourseStudyCode;
                                        }
                                        if(isset($student_fetch->EntranceTerm)){
                                            if (isset($student_fetch->EntranceTerm->TermCode))
                                                $student_information['entrance_term_unique_code'] = Term::where('term_code', $student_fetch->EntranceTerm->TermCode)->first()->unique_code;// sama retrieve TermCode which isn't Unique (multiple null)!
                                        }
                                        if(isset($student_fetch->StudyLevel)){
                                            if (isset($student_fetch->StudyLevel->StudyLevelId))
                                                $student_information['study_level_unique_code'] = strtolower(array_last(explode("\\", StudyLevel::class))) . $student_fetch->StudyLevel->StudyLevelId;
                                        }
                                        if(isset($student_fetch->StudentStatus)){
                                            if (isset($student_fetch->StudentStatus->StudentStatusId))
                                                $student_information['study_status_unique_code'] = strtolower(array_last(explode("\\", StudyStatus::class))) . $student_fetch->StudentStatus->StudentStatusId;
                                        }

                                        $student = $this->studentRepository->create($student_information);

                                        $roles = array();
                                        foreach ($user->roles as $role){
                                            array_push($roles, $role->only(['name', 'guard_name']));
                                        }

                                        $user = collect($user->toArray())
                                            ->only([
                                                'first_name',
                                                'last_name',
                                                'email',
                                                'phone_number',
                                                'birthday',
                                                'username',
                                                'gender_unique_code',
                                                'scu_id',
                                                'national_id',
                                                'last_login',
                                                'avatar_path',
                                                'is_verified',
                                                'updated_at',
                                            ])
                                            ->all();

                                        $user['roles'] = $roles;
                                        $user['student'] = $student;

                                        return response()->json($user);

                                    } else {
                                        return response()->json([
                                            'success' => false,
                                            'message' => 'اطلاعات وارد شده صحیح نیست. لطفا مجددا تلاش کنید'
                                        ]);
                                    }
                                } else { // this user has no NationalCode !
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'متاسفانه در اطلاعات دانشگاهی شما ایرادی وجود دارد. لطفا با مدیریت ارتباط برقرار کنید'
                                    ]);
                                }
                            } else { // this user has no StudentNumber !
                                return response()->json([
                                    'success' => false,
                                    'message' => 'متاسفانه در اطلاعات دانشگاهی شما ایرادی وجود دارد. لطفا با مدیریت ارتباط برقرار کنید'
                                ]);
                            }
                        } else {
                            return response()->json([
                                'success' => false,
                                'message' => 'اطلاعات وارد شده صحیح نیست. لطفا مجددا تلاش کنید'
                            ]);
                        }
                    } else { // this user has no StudentNumber !
                        return response()->json([
                            'success' => false,
                            'message' => 'متاسفانه در اطلاعات دانشگاهی شما ایرادی وجود دارد. لطفا با مدیریت ارتباط برقرار کنید'
                        ]);
                    }
                }
                else { // invalid scu_id
                    return response()->json([
                        'success' => false,
                        'message' => 'اطلاعات وارد شده صحیح نیست. لطفا مجددا تلاش کنید'
                    ]);
                }
            } catch (\Exception $e) {
                /** ATTENTION!
                 * uncomment this just for debug because this line below may pass critical information of Server Logic.
                 */
//                return response()->json($e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'عملیات موفقیت آمیز نبود، در صورت صحت اطلاعات، لطفا به مدیریت سامانه اطلاع دهید',
                ]);
            }
        }
    }

    /**
     * @return Response
     *
     * @SWG\put(
     *      path="/students/unVerify",
     *      summary="Soft Delete Student",
     *      tags={"Student"},
     *      description="Soft Delete Student information of authenticated user",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function unVerify()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $student->delete();
        $user->removeRole('verified');
        $user->removeRole('student');
        $user->is_verified = false;

        return response()->json([
            'status' => 'اطلاعات دانشگاهی کاربر با موفقیت حذف شد.'
        ]);
    }


    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/students/byScuId",
     *      summary="Display the specified Student",
     *      tags={"Student"},
     *      description="Display the specified Student by scu_id",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="scu_id",
     *          description="scu_id of Student",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Student"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function byScuId(Request $request)
    {
        /** @var User $user */
        $user = User::where('scu_id', $request['scu_id'])->first();

        if (empty($user)) {
            return $this->sendError('کاربری با این شماره دانشگاهی وجود ندارد');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $this->authorize('show', $user);

        $roles = array();
        foreach ($user->roles as $role){
            array_push($roles, $role->only(['name', 'guard_name']));
        }

        $student['user'] = collect($user->toArray())
            ->only([
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'birthday',
                'username',
                'gender_unique_code',
                'scu_id',
                'national_id',
                'last_login',
                'avatar_path',
                'is_verified',
                'updated_at',
            ])
            ->all();

        $user['roles'] = $roles;
        $student['user'] = $user;

        return response()->json([
            'status' => 'درخواست موفقیت آمیز بود.',
            'student' => $student,
        ]);
    }


    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/students/studentInfo",
     *      summary="Retrieve Student",
     *      tags={"Student"},
     *      description="Retrieve Student information of authenticated user",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Student"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function studentInfo(Request $request)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $roles = array();
        foreach ($user->roles as $role){
            array_push($roles, $role->only(['name', 'guard_name']));
        }

        $user = collect($user->toArray())
            ->only([
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'birthday',
                'username',
                'gender_unique_code',
                'scu_id',
                'national_id',
                'last_login',
                'avatar_path',
                'is_verified',
                'updated_at',
            ])
            ->all();

        $studyArea = $student->study_area->retrieve();
        $studyField = $student->study_area->study_field->retrieveWithDepartment();
        $faculty = $student->study_area->study_field->faculty->retrieve();
        $entranceTerm = $student->entrance_term->retrieve();

        $student = collect($student->toArray())
        ->only([
            'total_average',
            'is_active',
            'is_guest',
            'is_iranian',
            'in_dormitory',
            'created_at',
            'updated_at',
        ])
        ->all();

        $user['roles'] = $roles;

        $student['user'] = $user;

        $student['studyArea'] = $studyArea;
        $student['studyField'] = $studyField;
        $student['faculty'] = $faculty;
        $student['entranceTerm'] = $entranceTerm;

        return response()->json([
            'status' => 'درخواست موفقیت آمیز بود.',
            'student' => $student,
        ]);
    }


    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/updateProfile",
     *      summary="Update Profile information",
     *      tags={"Student"},
     *      description="Update Profile information of authenticated user",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="first_name",
     *          description="first_name of User",
     *          type="string",
     *          required=false,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="last_name",
     *          description="last_name of User",
     *          type="string",
     *          required=false,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="birthday",
     *          description="birthday of User",
     *          type="string",
     *          required=false,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="in_dormitory",
     *          description="in_dormitory of Student",
     *          type="boolean",
     *          required=false,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Student"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $student = Student::where('user_id', $user->id)->first();

        if (empty($student)) {
            return $this->sendError('Student not found');
        }

        $this->authorize('updateProfile', $user);

        $input = $request->all();
        $user = $this->userRepository->update($input, $user->id);
        $user->student = $this->studentRepository->update($input, $student->id);


        return $this->sendResponse($user->toArray(), 'Profile updated successfully');
    }

    /** ************************************************** Notification **************************************************/

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="students/notifications",
     *      summary="Get Student Notifictions",
     *      tags={"Student Notification"},
     *      description="Get list of authenticated Student Notifications",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Notification")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function notifications()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->notifications;

        $retrieves = Notification::staticRetrieves($notifications);

        if (sizeof($retrieves) == 0)
            return response()->json([
                'status' => 'هیچ نوتیفیکیشنی پیدا نشد'
            ], 404);

        return $this->sendResponse($retrieves, 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="students/notificationsWithTrashed",
     *      summary="Get Student Notifictions With Trashed",
     *      tags={"Student Notification"},
     *      description="Get list of authenticated Student Notifications, including soft deleted ones",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Notification")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function notificationsWithTrashed()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->notifications;

        $retrieves = Notification::staticRetrievesWithTrashed($notifications);

        if (sizeof($retrieves) == 0)
            return response()->json([
                'status' => 'هیچ نوتیفیکیشنی پیدا نشد'
            ], 404);

        return $this->sendResponse($retrieves, 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="students/unreadNotifications",
     *      summary="Get Student Unread Notifictions",
     *      tags={"Student Notification"},
     *      description="Get list of authenticated Student Unread Notifications",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Notification")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function unreadNotifications()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->unreadNotifications;

        $retrieves = Notification::staticRetrieves($notifications);

        if (sizeof($retrieves) == 0)
            return response()->json([
                'status' => 'نوتیفیکیشن خوانده نشده‌ای پیدا نشد'
            ], 404);

        return $this->sendResponse($retrieves, 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="students/readNotifications",
     *      summary="Get Student Read Notifictions",
     *      tags={"Student Notification"},
     *      description="Get list of authenticated Student Read Notifications",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Notification")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function readNotifications()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->readNotifications()->get();

        $retrieves = Notification::staticRetrieves($notifications);


        if (sizeof($retrieves) == 0)
            return response()->json([
                'status' => 'نوتیفیکیشن خوانده شده‌ای پیدا نشد'
            ], 404);

        return $this->sendResponse($retrieves, 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/notifications/markAsRead",
     *      summary="Mark as Read Notifications",
     *      tags={"Student Notification"},
     *      description="Update the notifications shold be mark as read by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function markAsReadNotifications(Request $request)
    {
        $request->validate([
            'notifications_id' => 'required|array'
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->unreadNotifications;

        $notifications = Notification::staticRemoveTrashed($notifications); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'نوتیفیکیشن خوانده نشده‌ای پیدا نشد'
            ], 404);

        $notFoundNotificationsId = array();
        foreach ($input['notifications_id'] as $index => $notification_id){
            $notification = $notifications->find($notification_id);
            if(isset($notification))
                $notification->markAsRead();
            else
                array_push($notFoundNotificationsId, $notification_id);
        }

        if (sizeof($notFoundNotificationsId) > 0)
            return response()->json([
                'status' => 'بعضی از نوتیفیکیشن ها در لیست خوانده نشده‌ها وجود ندارند',
                'data' => $notFoundNotificationsId,
            ]);
        return response()->json([
            'status' => 'عملیات موفقیت آمیز بود'
        ]);
//        return $this->sendResponse($notifications->toArray(), 'Student updated successfully');
    }


    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/notifications/markAsUnread",
     *      summary="Mark as Unread Notifications",
     *      tags={"Student Notification"},
     *      description="Update the notifications shold be mark as unread by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function markAsUnreadNotifications(Request $request)
    {
        $request->validate([
            'notifications_id' => 'required|array'
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->readNotifications;

        $notifications = Notification::staticRemoveTrashed($notifications); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'نوتیفیکیشن خوانده شده‌ای پیدا نشد'
            ], 404);

        $notFoundNotificationsId = array();
        foreach ($input['notifications_id'] as $index => $notification_id){
            $notification = $notifications->find($notification_id);
            if(isset($notification)) /** check for soft deleted notifications */
                $notification->markAsUnread();
            else
                array_push($notFoundNotificationsId, $notification_id);
        }

        if (sizeof($notFoundNotificationsId) > 0)
            return response()->json([
                'status' => 'بعضی از نوتیفیکیشن ها در لیست خوانده شده‌ها وجود ندارند',
                'data' => $notFoundNotificationsId,
            ]);
        return response()->json([
            'status' => 'عملیات موفقیت آمیز بود'
        ]);
//        return $this->sendResponse($notifications->toArray(), 'Student updated successfully');
    }


    /**
     * @return Response
     *
     * @SWG\Delete(
     *      path="/students/notifications/delete",
     *      summary="Soft Delete Notifications",
     *      tags={"Student Notification"},
     *      description="soft delete the notifications should be deleted by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function deleteNotifications(Request $request)
    {
        $request->validate([
            'notifications_id' => 'required|array'
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->notifications;

        $notifications = Notification::staticRemoveTrashed($notifications); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'هیچ نوتیفیکیشنی پیدا نشد'
            ], 404);

        $notFoundNotificationsId = array();
        foreach ($input['notifications_id'] as $index => $notification_id){
            $notification = $notifications->find($notification_id);
            if(isset($notification)){
//                $notification->markAsUnread();
                $notification->deleted_at = Carbon::now();
                $notification->save();
            }
            else
                array_push($notFoundNotificationsId, $notification_id);
        }

        if (sizeof($notFoundNotificationsId) > 0)
            return response()->json([
                'status' => 'بعضی از نوتیفیکیشن ها در لیست خوانده شده‌ها وجود ندارند',
                'data' => $notFoundNotificationsId,
            ]);
        return response()->json([
            'status' => 'عملیات موفقیت آمیز بود'
        ]);
//        return $this->sendResponse($notifications->toArray(), 'Student updated successfully');
    }


    /**
     * @return Response
     *
     * @SWG\Delete(
     *      path="/students/notifications/deleteAll",
     *      summary="Soft Delete All Notifications",
     *      tags={"Student Notification"},
     *      description="soft delete all the notifications should be deleted by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function deleteAllNotifications()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->notifications;

        $notifications = Notification::staticRemoveTrashed($notifications); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'هیچ نوتیفیکیشنی پیدا نشد'
            ], 404);

        foreach ($notifications as $notification){
            $notification->deleted_at = Carbon::now();
            $notification->save();
        }

        return response()->json([
            'status' => 'عملیات موفقیت آمیز بود'
        ]);
    }


    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/notifications/restore",
     *      summary="Restore soft deleted Notifications",
     *      tags={"Student Notification"},
     *      description="restore notifications has been deleted by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function restoreNotifications(Request $request)
    {
        $request->validate([
            'notifications_id' => 'required|array'
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->notifications;

        $notifications = Notification::staticRemoveUnTrashed($notifications); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'هیچ نوتیفیکیشن حذف شدهای پیدا نشد'
            ], 404);

        $notFoundNotificationsId = array();
        foreach ($input['notifications_id'] as $index => $notification_id){
            $notification = $notifications->find($notification_id);
            if(isset($notification)){
//                $notification->markAsUnread();
                $notification->deleted_at = null;
                $notification->save();
            }
            else
                array_push($notFoundNotificationsId, $notification_id);
        }

        if (sizeof($notFoundNotificationsId) > 0)
            return response()->json([
                'status' => 'بعضی از نوتیفیکیشن ها در لیست خوانده شده‌ها وجود ندارند',
                'data' => $notFoundNotificationsId,
            ]);
        return response()->json([
            'status' => 'عملیات موفقیت آمیز بود'
        ]);
//        return $this->sendResponse($notifications->toArray(), 'Student updated successfully');
    }


    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/notifications/restoreAll",
     *      summary="Restore All soft deleted Notifications",
     *      tags={"Student Notification"},
     *      description="restore all notifications has been deleted by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function restoreAllNotifications()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notifications = $student->notifications;

        $notifications = Notification::staticRemoveUnTrashed($notifications); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'هیچ نوتیفیکیشن حذف شده ای پیدا نشد'
            ], 404);

        $notFoundNotificationsId = array();
        foreach ($notifications as $notification){
            $notification->deleted_at = null;
            $notification->save();
        }

        return response()->json([
            'status' => 'عملیات موفقیت آمیز بود'
        ]);
    }

    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/notification/markAsRead",
     *      summary="Mark as Read Notification",
     *      tags={"Student Notification"},
     *      description="Update the notification shold be mark as read by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="$notifications_id",
     *          description="id of notification",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function markAsReadNotification(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|string'
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notification = $student->unreadNotifications()->find($input['notification_id']);
        if(isset($notification) && empty($notification->deleted_at)) /** check for soft deleted notifications */
        {
            $notification->markAsRead();
            return response()->json([
                'status' => 'عملیات موفقیت آمیز بود'
            ]);
        }

        return response()->json([
            'status' => 'نوتیفیکیشن خوانده نشده‌ای با این مشخصات پیدا نشد'
        ], 404);
    }

    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/notification/markAsUnread",
     *      summary="Mark as Unread Notification",
     *      tags={"Student Notification"},
     *      description="Update the notification shold be mark as unread by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="$notification_id",
     *          description="id of notification",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function markAsUnreadNotification(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|string'
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notification = $student->readNotifications()->find($input['notification_id']);
        if(isset($notification) && empty($notification->deleted_at)) /** check for soft deleted notifications */
        {
            $notification->markAsUnread();
            return response()->json([
                'status' => 'عملیات موفقیت آمیز بود'
            ]);
        }

        return response()->json([
            'status' => 'نوتیفیکیشن خوانده شده‌ای با این مشخصات پیدا نشد'
        ], 404);
    }

    /**
     * @return Response
     *
     * @SWG\Delete(
     *      path="/students/notification/delete",
     *      summary="Soft Delete Notification",
     *      tags={"Student Notification"},
     *      description="soft delete the notification should be deleted by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="$notification_id",
     *          description="id of notification",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function deleteNotification(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|string'
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notification = $student->notifications()->find($input['notification_id']);
        $console = new ConsoleOutput();
        if(isset($notification) && empty($notification->deleted_at)) /** check for notifications has been deleted  */
        {
            $notification->deleted_at = Carbon::now();
            $notification->save();
            return response()->json([
                'status' => 'عملیات موفقیت آمیز بود'
            ]);
        }

        return response()->json([
            'status' => 'نوتیفیکیشنی با این مشخصات پیدا نشد'
        ], 404);
    }

    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/notification/restore",
     *      summary="Restore soft deleted Notification",
     *      tags={"Student Notification"},
     *      description="restore the notification has been deleted by authenticated Student",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="$notification_id",
     *          description="id of notification",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function restoreNotification(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|string'
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            return $this->sendError('کاربر اطلاعات دانشگاهی خود را احراز نکرده است.');
        }

        /** @var Student $student */
        $student = $this->studentRepository->findWithoutFail($user->student->id);

        $notification = $student->notifications()->find($input['notification_id']);
        if(isset($notification) && isset($notification->deleted_at)) /** check for notifications has been deleted  */
        {
            $notification->deleted_at = null;
            $notification->save();
            return response()->json([
                'status' => 'عملیات موفقیت آمیز بود'
            ]);
        }

        return response()->json([
            'status' => 'نوتیفیکیشنی با این مشخصات پیدا نشد'
        ], 404);
    }
}
