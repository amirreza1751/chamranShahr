<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Sama\SamaRequestController;
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\Gender;
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
use Illuminate\Support\Facades\Hash;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Morilog\Jalali\Jalalian;
use mysql_xdevapi\Exception;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

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
     *                  @SWG\Items(ref="#/definitions/User")
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
     *          @SWG\Schema(ref="#/definitions/User")
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
     *                  ref="#/definitions/User"
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
     *                  ref="#/definitions/User"
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
     *          @SWG\Schema(ref="#/definitions/User")
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
     *                  ref="#/definitions/User"
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
     *          @SWG\Schema(ref="#/definitions/User")
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function updateScuId($id, Request $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->scu_id_to_update = $input['scu_id_to_update'];

        $user->save();

        return $this->sendResponse($user->scu_id_to_update, 'Scu Id Change Request is submitted successfully');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * @SWG\Put(
     *      path="/users/{id}/verify",
     *      summary="Verify the specified User in storage",
     *      tags={"User"},
     *      description="Verify User",
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
     *          @SWG\Schema(ref="#/definitions/User")
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function verify($id, Request $request)
    {
        $request->validate([
            'scu_id' => 'required|regex:/[0-9]{6,7}/|max:7',
            'national_id' => 'required|regex:/[0-9]{10}/|max:10',
        ]);

        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        if (is_null($user->student)) { // not verified user
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
                        $user = $this->userRepository->update($user_information, $id);


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
                    'status' => 'An internal error has occurred. Please contact your administrator.',
                    'e' => $e
                ], 500);
            }
        } else { // verified user
            return response()->json([
                'status' => 'This user has been verified before.'
            ], 400);
        }
    }
}
