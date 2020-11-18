<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Sama\SamaRequestController;
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\Gender;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudyArea;
use App\Models\StudyLevel;
use App\Models\StudyStatus;
use App\Models\Term;
use App\Repositories\StudentRepository;
use App\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Morilog\Jalali\Jalalian;
use mysql_xdevapi\Exception;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;
    private $studentRepository;

    public function __construct(UserRepository $userRepo, StudentRepository $studentRepo)
    {
        $this->userRepository = $userRepo;
        $this->studentRepository = $studentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/users",
     *      summary="Get a listing of the User.",
     *      tags={"User"},
     *      description="Get all User",
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
     *                  @SWG\Items(ref="App/User")
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
        $this->authorize('index');

        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $this->userRepository->pushCriteria(new LimitOffsetCriteria($request));
        $users = $this->userRepository->all();

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * @param CreateUserAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/users",
     *      summary="Store a newly created User in storage",
     *      tags={"User"},
     *      description="Store User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="App/User")
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
     *                  ref="App/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateUserAPIRequest $request)
    {
        $this->authorize('store');

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = $this->userRepository->create($input);

        return $this->sendResponse($user->toArray(), 'User saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/users/{id}",
     *      summary="Display the specified User",
     *      tags={"User"},
     *      description="Get User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of User",
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
     *                  ref="App/User"
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
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $this->authorize('show', $user);

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateUserAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/{id}",
     *      summary="Update the specified User in storage",
     *      tags={"User"},
     *      description="Update User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of User",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="App/User")
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
     *                  ref="App/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $this->authorize('update', $user);

        $input['password'] = Hash::make($input['password']);

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/users/{id}",
     *      summary="Remove the specified User from storage",
     *      tags={"User"},
     *      description="Delete User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of User",
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
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $this->authorize('destroy', $user);

        $user->delete();

        return $this->sendResponse($id, 'User deleted successfully');
    }


    /**
     *******************************************************************************************************************
     *******************************************************************************************************************
     *************************************************** CUSTOMIZATION *************************************************
     *******************************************************************************************************************
     *******************************************************************************************************************
     */


    public function update_scu_id(Request $request)
    {
        $this->authorize('update_scu_id');

        $request->validate([
            'scu_id' => 'required|regex:/[0-9]{6,7}/|max:7',
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->scu_id_to_update = $input['scu_id_to_update'];

        $user->save();

        return $this->sendResponse($user->scu_id_to_update, 'Scu Id Change Request is submitted successfully');
    }


    public function update_national_id(Request $request)
    {
        $this->authorize('update_national_id');

        $request->validate([
            'national_id' => 'required|regex:/[0-9]{10}/|max:10',
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->national_id_to_update = $input['national_id_to_update'];

        $user->save();

        return $this->sendResponse($user->national_id_to_update, 'Scu Id Change Request is submitted successfully');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'scu_id' => 'required|regex:/[0-9]{6,7}/|max:7',
            'national_id' => 'required|regex:/[0-9]{10}/|max:10',
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        $student = Student::withTrashed()->findOrFail($user->id);

        if ($student->trashed()) { // user verified, but has soft deleted before
            $student->restore();
            $user->assignRole('verified');
            $user->is_verified = true;

            $user['student'] = $user->student;

            return response()->json([
                'message' => 'اطلاعات دانشگاهی کاربر با موفقیت بازیابی شد.',
                'result' => $user,
            ]);
        }
        elseif (isset($student)) { // verified user
            return response()->json([
                'message' => 'کاربر اطلاعات دانشگاهی خود را قبلا احراز کرده است.'
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
                            'username' => str_random(8) . $student_fetch->StudentNumber,
                            'scu_id' => $student_fetch->StudentNumber,
                            'national_id' => $student_fetch->Person->NationalCode,
                            'gender_unique_code' => strtolower(array_last(explode("\\", Gender::class))) . $student_fetch->Person->Gender->GenderId,
                            'updated_at' => Carbon::now(), // set update time
                            'is_verified' => true,
                        );
                        $user = $this->userRepository->update($user_information, auth('api')->user()->id);

                        $user->assignRole('verified');

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
                        return $this->sendError('mismatch national id');
                    }
                } else {
                    return $this->sendError('Scu Id not found');
                }
            } catch (\Exception $e) {
                /** ATTENTION!
                 * uncomment this just for debug because this line below may pass critical information of Server Logic.
                 */
//                return response()->json($e->getMessage());
                return response()->json([
                    'message' => 'An internal error has occurred. Please contact your administrator.',
                    'e' => $e
                ], 500);
            }
        }
    }



    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/users/userInfo",
     *      summary="Retrieve User",
     *      tags={"User"},
     *      description="Retrieve information of authenticated user",
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
    public function userInfo(Request $request)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

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

        return response()->json([
            'message' => 'درخواست موفقیت آمیز بود.',
            'user' => $user,
        ]);
    }



    /** ************************************************** Notification **************************************************/

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="users/notifications",
     *      summary="Get User Notifictions",
     *      tags={"User Notification"},
     *      description="Get list of authenticated User Notifications",
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
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->notifications;
        }

        $retrieves = Notification::staticRetrieves($notifications->merge($user->notifications));

        if (sizeof($retrieves) == 0)
            return response()->json([
                'success' => false,
                'message' => 'هیچ نوتیفیکیشنی پیدا نشد'
            ], 404);

        return $this->sendResponse($retrieves, 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="users/notificationsWithTrashed",
     *      summary="Get User Notifictions With Trashed",
     *      tags={"User Notification"},
     *      description="Get list of authenticated User Notifications, including soft deleted ones",
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
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->notifications;
        }

        $retrieves = Notification::staticRetrievesWithTrashed($notifications->merge($user->notifications));

        if (sizeof($retrieves) == 0)
            return response()->json([
                'success' => false,
                'message' => 'هیچ نوتیفیکیشنی پیدا نشد'
            ], 404);

        return $this->sendResponse($retrieves, 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="users/trashedNtifications",
     *      summary="Get User Trashed Notifictions",
     *      tags={"User Notification"},
     *      description="Get list of authenticated User soft deleted Notifications",
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
    public function trashedNotifications()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->notifications;
        }

        $retrieves = Notification::staticRetrievesTrashed($notifications->merge($user->notifications));

        if (sizeof($retrieves) == 0)
            return response()->json([
                'success' => false,
                'message' => 'هیچ نوتیفیکیشن حذف شده‌ای پیدا نشد'
            ], 404);

        return $this->sendResponse($retrieves, 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="users/unreadNotifications",
     *      summary="Get User Unread Notifictions",
     *      tags={"User Notification"},
     *      description="Get list of authenticated User Unread Notifications",
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
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->unreadNotifications;
        }

        $retrieves = Notification::staticRetrieves($notifications->merge($user->unreadNotifications));

        if (sizeof($retrieves) == 0)
            return response()->json([
                'success' => false,
                'message' => 'نوتیفیکیشن خوانده نشده‌ای پیدا نشد'
            ], 404);

        return $this->sendResponse($retrieves, 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="users/readNotifications",
     *      summary="Get User Read Notifictions",
     *      tags={"User Notification"},
     *      description="Get list of authenticated User Read Notifications",
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
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->readNotifications;
        }

        $retrieves = Notification::staticRetrieves($notifications->merge($user->readNotifications));


        if (sizeof($retrieves) == 0)
            return response()->json([
                'success' => false,
                'message' => 'نوتیفیکیشن خوانده شده‌ای پیدا نشد'
            ], 404);

        return $this->sendResponse($retrieves, 'عملیات موفقیت آمیز بود.');
    }

    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/notifications/markAsRead",
     *      summary="Mark as Read Notifications",
     *      tags={"User Notification"},
     *      description="Update the notifications shold be mark as read by authenticated User",
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
        $input = $request->all();

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'notifications_id' => 'required|array',
            'notifications_id.*' => 'required|regex:/^([0-9a-z]{8})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{12})$/|distinct',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'notifications_id' => [
                        'فرمت شناسه نوتیفیکیشن‌ها صحیح نیست'
                    ]
                ],
            ], 422);
        }

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->unreadNotifications;
        }

        $notifications = Notification::staticRemoveTrashedAndExpired($notifications->merge($user->unreadNotifications)); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'success' => false,
                'message' => 'نوتیفیکیشن خوانده نشده‌ای پیدا نشد'
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
                'success' => true,
                'message' => 'بعضی از نوتیفیکیشن ها در لیست خوانده نشده‌ها وجود ندارند',
                'data' => $notFoundNotificationsId,
            ]);
        return response()->json([
            'success' => true,
            'message' => 'عملیات موفقیت آمیز بود'
        ]);
    }


    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/notifications/markAsUnread",
     *      summary="Mark as Unread Notifications",
     *      tags={"User Notification"},
     *      description="Update the notifications shold be mark as unread by authenticated User",
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
        $input = $request->all();

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'notifications_id' => 'required|array',
            'notifications_id.*' => 'required|regex:/^([0-9a-z]{8})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{12})$/|distinct',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'notifications_id' => [
                        'فرمت شناسه نوتیفیکیشن‌ها صحیح نیست'
                    ]
                ],
            ], 422);
        }

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->readNotifications;
        }

        $notifications = Notification::staticRemoveTrashedAndExpired($notifications->merge($user->readNotifications)); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'success' => false,
                'message' => 'نوتیفیکیشن خوانده شده‌ای پیدا نشد'
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
                'success' => true,
                'message' => 'بعضی از نوتیفیکیشن ها در لیست خوانده شده‌ها وجود ندارند',
                'data' => $notFoundNotificationsId,
            ]);
        return response()->json([
            'success' => true,
            'message' => 'عملیات موفقیت آمیز بود'
        ]);
    }


    /**
     * @return Response
     *
     * @SWG\Delete(
     *      path="/users/notifications/delete",
     *      summary="Soft Delete Notifications",
     *      tags={"User Notification"},
     *      description="soft delete the notifications should be deleted by authenticated User",
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
        $input = $request->all();

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'notifications_id' => 'required|array',
            'notifications_id.*' => 'required|regex:/^([0-9a-z]{8})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{12})$/|distinct',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'notifications_id' => [
                        'فرمت شناسه نوتیفیکیشن‌ها صحیح نیست'
                    ]
                ],
            ], 422);
        }

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->notifications;
        }

        $notifications = Notification::staticRemoveTrashedAndExpired($notifications->merge($user->notifications)); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'success' => false,
                'message' => 'هیچ نوتیفیکیشنی پیدا نشد'
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
                'success' => true,
                'message' => 'بعضی از نوتیفیکیشن ها وجود ندارند',
                'data' => $notFoundNotificationsId,
            ]);
        return response()->json([
            'success' => true,
            'message' => 'عملیات موفقیت آمیز بود'
        ]);
    }


    /**
     * @return Response
     *
     * @SWG\Delete(
     *      path="/users/notifications/deleteAll",
     *      summary="Soft Delete All Notifications",
     *      tags={"User Notification"},
     *      description="soft delete all the notifications should be deleted by authenticated User",
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
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->notifications;
        }

        $notifications = Notification::staticRemoveTrashedAndExpired($notifications->merge($user->notifications)); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'success' => false,
                'message' => 'هیچ نوتیفیکیشنی پیدا نشد'
            ], 404);

        foreach ($notifications as $notification){
            $notification->deleted_at = Carbon::now();
            $notification->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'عملیات موفقیت آمیز بود'
        ]);
    }


    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/notifications/restore",
     *      summary="Restore soft deleted Notifications",
     *      tags={"User Notification"},
     *      description="restore notifications has been deleted by authenticated User",
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
        $input = $request->all();

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'notifications_id' => 'required|array',
            'notifications_id.*' => 'required|regex:/^([0-9a-z]{8})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{12})$/|distinct',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'notifications_id' => [
                        'فرمت شناسه نوتیفیکیشن‌ها صحیح نیست'
                    ]
                ],
            ], 422);
        }

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->notifications;
        }

        $notifications = Notification::staticRemoveUnTrashedAndExpired($notifications->merge($user->notifications)); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'success' => false,
                'message' => 'هیچ نوتیفیکیشن حذف شده‌ای پیدا نشد'
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
                'success' => true,
                'message' => 'بعضی از نوتیفیکیشن‌ها در لیست حذف‌شده‌ها وجود ندارند',
                'data' => $notFoundNotificationsId,
            ]);
        return response()->json([
            'success' => true,
            'message' => 'عملیات موفقیت آمیز بود'
        ]);
    }


    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/notifications/restoreAll",
     *      summary="Restore All soft deleted Notifications",
     *      tags={"User Notification"},
     *      description="restore all notifications has been deleted by authenticated User",
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
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->notifications;
        }

        $notifications = Notification::staticRemoveUnTrashedAndExpired($notifications->merge($user->notifications)); /** check for soft deleted notifications */

        if (sizeof($notifications) == 0)
            return response()->json([
                'success' => false,
                'message' => 'هیچ نوتیفیکیشن حذف شده ای پیدا نشد'
            ], 404);

        $notFoundNotificationsId = array();
        foreach ($notifications as $notification){
            $notification->deleted_at = null;
            $notification->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'عملیات موفقیت آمیز بود'
        ]);
    }

    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/notification/markAsRead",
     *      summary="Mark as Read Notification",
     *      tags={"User Notification"},
     *      description="Update the notification shold be mark as read by authenticated User",
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
        $input = $request->all();

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'notification_id' => 'required|regex:/^([0-9a-z]{8})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{12})$/',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'notification_id' => [
                        'فرمت شناسه نوتیفیکیشن صحیح نیست'
                    ]
                ],
            ], 422);
        }

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->unreadNotifications;
        }

        $notifications = $notifications->merge($user->unreadNotifications);
        $notification = Notification::staticRemoveTrashedAndExpired($notifications)->find($input['notification_id']);
        if(isset($notification) && empty($notification->deleted_at)) /** check for soft deleted notifications */
        {
            $notification->markAsRead();
            return response()->json([
                'success' => true,
                'message' => 'عملیات موفقیت آمیز بود'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'نوتیفیکیشن خوانده نشده‌ای با این مشخصات پیدا نشد'
        ], 404);
    }

    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/notification/markAsUnread",
     *      summary="Mark as Unread Notification",
     *      tags={"User Notification"},
     *      description="Update the notification shold be mark as unread by authenticated User",
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
        $input = $request->all();

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'notification_id' => 'required|regex:/^([0-9a-z]{8})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{12})$/',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'notification_id' => [
                        'فرمت شناسه نوتیفیکیشن صحیح نیست'
                    ]
                ],
            ], 422);
        }

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->readNotifications;
        }

        $notifications = $notifications->merge($user->readNotifications);
        $notification = Notification::staticRemoveTrashedAndExpired($notifications)->find($input['notification_id']);
        if(isset($notification) && empty($notification->deleted_at)) /** check for soft deleted notifications */
        {
            $notification->markAsUnread();
            return response()->json([
                'success' => true,
                'message' => 'عملیات موفقیت آمیز بود'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'نوتیفیکیشن خوانده شده‌ای با این مشخصات پیدا نشد'
        ], 404);
    }

    /**
     * @return Response
     *
     * @SWG\Delete(
     *      path="/users/notification/delete",
     *      summary="Soft Delete Notification",
     *      tags={"User Notification"},
     *      description="soft delete the notification should be deleted by authenticated User",
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
        $input = $request->all();

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'notification_id' => 'required|regex:/^([0-9a-z]{8})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{12})$/',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'notification_id' => [
                        'فرمت شناسه نوتیفیکیشن صحیح نیست'
                    ]
                ],
            ], 422);
        }

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->notifications;
        }

        $notifications = $notifications->merge($user->notifications);
        $notification = Notification::staticRemoveTrashedAndExpired($notifications)->find($input['notification_id']);
        if(isset($notification) && empty($notification->deleted_at)) /** check for notifications has been deleted  */
        {
            $notification->deleted_at = Carbon::now();
            $notification->save();
            return response()->json([
                'success' => true,
                'message' => 'عملیات موفقیت آمیز بود'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'نوتیفیکیشنی با این مشخصات پیدا نشد'
        ], 404);
    }

    /**
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/notification/restore",
     *      summary="Restore soft deleted Notification",
     *      tags={"User Notification"},
     *      description="restore the notification has been deleted by authenticated User",
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
        $input = $request->all();

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'notification_id' => 'required|regex:/^([0-9a-z]{8})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{4})(-)([0-9a-z]{12})$/',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'notification_id' => [
                        'فرمت شناسه نوتیفیکیشن صحیح نیست'
                    ]
                ],
            ], 422);
        }


        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا وارد سامانه شوید');
        }

        if (empty($user->student)){
            $notifications = collect();
        } else {
            /** @var Student $student */
            $student = Student::find($user->student->id);
            $notifications = $student->notifications;
        }

        $notifications = $notifications->merge($user->notifications);
        $notification = Notification::staticRemoveUnTrashedAndExpired($notifications)->find($input['notification_id']);
        if(isset($notification) && isset($notification->deleted_at)) /** check for notifications has been deleted  */
        {
            $notification->deleted_at = null;
            $notification->save();
            return response()->json([
                'success' => true,
                'message' => 'عملیات موفقیت آمیز بود'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'نوتیفیکیشن حذف‌شده‌ای با این مشخصات پیدا نشد'
        ], 404);
    }
}
