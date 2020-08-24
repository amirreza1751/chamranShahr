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
}
