<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Sama\SamaRequestController;
use App\Http\Requests\API\CreateStudentAPIRequest;
use App\Http\Requests\API\UpdateStudentAPIRequest;
use App\Models\Faculty;
use App\Models\Gender;
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
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Morilog\Jalali\Jalalian;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

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
        $request->validate([
            'scu_id' => 'required|regex:/[0-9]{6,7}/|max:7',
            'national_id' => 'required|regex:/[0-9]{10}/|max:10',
        ]);

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

            $user['student'] = $user->student;

            return response()->json([
                'status' => 'اطلاعات دانشگاهی کاربر با موفقیت بازیابی شد.',
                'result' => $user,
            ]);
        }
        elseif (isset($student)) { // verified user
            return response()->json([
                'status' => 'کاربر اطلاعات دانشگاهی خود را قبلا احراز کرده است.'
            ], 400);
        }
        elseif (empty($student)) { // user not verified
            try {
                $student_fetch = SamaRequestController::sama_request('StudentService', 'GetStudentPersonInfo', ['studentNumber' => $input['scu_id']]);
                if ($student_fetch->StudentNumber == $input['scu_id']) { // Student with entered Scu Id is exist

                    if ($student_fetch->Person->NationalCode == $input['national_id']) { // matched entered national id with the Scu Id

                        $birthday_array = explode('/', $student_fetch->Person->BirthDate);
                        $jalalian_begin = new Jalalian($birthday_array[0], $birthday_array[1], $birthday_array[2]); // extract Solar date from String
                        $user_information = array(
                            'first_name' => $student_fetch->Person->FirstName,
                            'last_name' => $student_fetch->Person->LastName,
                            'birthday' => ($jalalian_begin)->toCarbon(),  // convert Solar date to A.D.
                            'scu_id' => $student_fetch->StudentNumber,
                            'national_id' => $student_fetch->Person->NationalCode,
                            'gender_unique_code' => strtolower(array_last(explode("\\", Gender::class))) . $student_fetch->Person->Gender->GenderId,
                            'updated_at' => Carbon::now(), // set update time
                            'is_verified' => true,
                        );
                        if(empty($user->username)){
                            $user_information['username'] = str_random(8) . $student_fetch->StudentNumber;
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
                            'study_area_unique_code' => strtolower(array_last(explode("\\", StudyArea::class))) . $student_fetch->CourseStudy->CourseStudyCode,
                            'entrance_term_unique_code' => Term::where('term_code', $student_fetch->EntranceTerm->TermCode)->first()->unique_code, // sama retrieve TermCode which isn't Unique (multiple null)!
                            'study_level_unique_code' => strtolower(array_last(explode("\\", StudyLevel::class))) . $student_fetch->StudyLevel->StudyLevelId,
                            'study_status_unique_code' => strtolower(array_last(explode("\\", StudyStatus::class))) . $student_fetch->StudentStatus->StudentStatusId,

                            'is_active' => $student_fetch->IsActive,
                            'is_guest' => $student_fetch->IsGuest,
                            'is_iranian' => $student_fetch->Person->IsIranian,
                            'total_average' => $student_fetch->TotalAverage,
                            'user_id' => $user->id,
                        );
                        $student = $this->studentRepository->create($student_information);
                        $user['student'] = $student;
                        return response()->json($user);

                    } else {
                        return $this->sendError('شماره ملی یا شماره دانشجویی صحیح نیست.');
                    }
                } else {
                    return $this->sendError('شماره ملی یا شماره دانشجویی صحیح نیست.');
                }
            } catch (\Exception $e) {
                /** ATTENTION!
                 * uncomment this just for debug because this line below may pass critical information of Server Logic.
                 */
//                return response()->json($e->getMessage());
                return response()->json([
                    'status' => 'An internal error has occurred. Please contact your administrator.',
                    'e' => $e
                ], 500);
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
     *      tags={"Student"},
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

        $notifications = $student->notifications()->get();

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'هیچ نوتیفیکیشنی پیدا نشد'
            ], 404);

        return $this->sendResponse($notifications->toArray(), 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="students/unreadNotifications",
     *      summary="Get Student Unread Notifictions",
     *      tags={"Student"},
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

        $notifications = $student->unreadNotifications()->get();

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'نوتیفیکیشن خوانده نشده‌ای پیدا نشد'
            ], 404);

        return $this->sendResponse($notifications->toArray(), 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="students/readNotifications",
     *      summary="Get Student Read Notifictions",
     *      tags={"Student"},
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

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'نوتیفیکیشن خوانده شده‌ای پیدا نشد'
            ], 404);

        return $this->sendResponse($notifications->toArray(), 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/notifications/markAsRead",
     *      summary="Mark as Read Notifications",
     *      tags={"Student"},
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

        $notifications = $student->unreadNotifications()->get();

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
     *      tags={"Student"},
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

        $notifications = $student->readNotifications()->get();

        if (sizeof($notifications) == 0)
            return response()->json([
                'status' => 'نوتیفیکیشن خوانده شده‌ای پیدا نشد'
            ], 404);

        $notFoundNotificationsId = array();
        foreach ($input['notifications_id'] as $index => $notification_id){
            $notification = $notifications->find($notification_id);
            if(isset($notification))
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
     * @SWG\Put(
     *      path="/students/notification/markAsRead",
     *      summary="Mark as Read Notification",
     *      tags={"Student"},
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
        if(isset($notification)){
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
     *      tags={"Student"},
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
        if(isset($notification)){
            $notification->markAsUnread();
            return response()->json([
                'status' => 'عملیات موفقیت آمیز بود'
            ]);
        }

        return response()->json([
            'status' => 'نوتیفیکیشن خوانده شده‌ای با این مشخصات پیدا نشد'
        ], 404);
    }
}
