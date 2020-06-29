<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStudentAPIRequest;
use App\Http\Requests\API\UpdateStudentAPIRequest;
use App\Models\Student;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
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
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/students/byScuId/{scu_id}",
     *      summary="Display the specified User by scu_id",
     *      tags={"User"},
     *      description="Get User by scu_id",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="scu_id",
     *          description="scu_id of User",
     *          type="string",
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
    public function showByScuId(Request $request)
    {
        /** @var User $user */
        $user = User::where('scu_id', $request['scu_id'])->first();

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $student = Student::where('user_id', $user->id)->first();

        if (empty($student)) {
            return $this->sendError('Student not found');
        }

        $this->authorize('show', $user);

        $user->student = $student;

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }


    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/students/updateProfile",
     *      summary="Update Profile Information",
     *      tags={"Student"},
     *      description="Update Profile Information",
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
}
