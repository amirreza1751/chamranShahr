<?php

namespace App\Http\Controllers\API;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolePermissionAPIController extends Controller
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }



    /**
     * @return Response
     *
     * @SWG\Post(
     *      path="/users/hasRole",
     *      summary="User Has Role",
     *      tags={"User"},
     *      description="specify the authenticated has requested role or not",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="role",
     *          description="role to check",
     *          required=false,
     *          type="string",
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
     *                  property="result",
     *                  property="true",
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function hasRole(Request $request)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا به سامانه وارد شوید');
        }

        $request->validate([
            'role' => 'required|string|max:30'
        ]);

        $input = $request->all();

        return response()->json([
            'status' => 'درخواست موفقیت آمیز بود.',
            'result' => $user->hasRole($input['role']),
        ]);
    }


    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/users/roles",
     *      summary="Retrieve User Roles",
     *      tags={"Student"},
     *      description="retrieve the authenticated user roles",
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
    public function roles()
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail(auth('api')->user()->id);

        if (empty($user)) {
            return $this->sendError('ابتدا به سامانه وارد شوید');
        }

        return response()->json([
            'status' => 'درخواست موفقیت آمیز بود.',
            'result' => $user->roles,
        ]);

    }
}
