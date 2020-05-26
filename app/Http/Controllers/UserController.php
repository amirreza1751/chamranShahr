<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Gender;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Morilog\Jalali\Jalalian;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->all();

        foreach ($users as $user){
            $user['birthday'] = Jalalian::fromCarbon(new Carbon($user['birthday']))->format('d / m / Y');
        }

        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        $genders = Gender::all();

        return view('users.create')
            ->with('genders', $genders);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = $this->userRepository->create($input);

        Flash::success('News saved successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        if (isset($user->avatar_path)){
            $user->avatar_path = URL::to('/') . '/' . $user->avatar_path;
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);
        $genders = Gender::all();

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')
            ->with('user', $user)
            ->with('genders', $genders);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $input = $request->all();

        if(!is_null($input['password'])){
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = $user->password;
        }

        $input['id'] = $id;
        $user = $this->userRepository->update($input, $id);

        Flash::success('User updated successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('users.index'));
    }

    /**
     *******************************************************************************************************************
     *******************************************************************************************************************
     *************************************************** CUSTOMIZATION *************************************************
     *******************************************************************************************************************
     *******************************************************************************************************************
     */

    public function showProfile()
    {
        $this->authorize('showProfile', User::class);

        $user = $this->userRepository->findWithoutFail(Auth::user()->id);
//        $genders = Gender::all();

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $user->avatar_path = URL::to('/') . '/' . $user->avatar_path;

        $user->birthday = Jalalian::fromCarbon(Carbon::parse($user->birthday))->format('d - m - Y');

        return view('users.show_profile')
            ->with('user', $user);
//            ->with('genders', $genders);
    }

    public function editProfile()
    {
        $user = $this->userRepository->findWithoutFail(Auth::user()->id);
//        $genders = Gender::all();

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('home'));
        }

        $this->authorize('updateProfile', $user);

        return view('users.edit_profile')
            ->with('user', $user);
//            ->with('genders', $genders);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function updateProfile($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);
        $input = $request->all();

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('home'));
        }

        $this->authorize('updateProfile', $user);

        if($request->hasFile('avatar_path')){
            $avatar_path = $request->file('avatar_path')->store('/public/profile');
            $avatar_path = str_replace('public', 'storage', $avatar_path);
            $input['avatar_path'] = $avatar_path;
        }

        if(isset($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }

        unset($input['password']);

        $user = $this->userRepository->update($input, $id);

        Flash::success('صفحه‌ی شخصی با موفقیت به روز شد');

        return redirect(route('users.showProfile'));
    }
}
