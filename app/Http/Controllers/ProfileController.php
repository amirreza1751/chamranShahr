<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Repositories\NotificationRepository;
use App\Repositories\NotificationSampleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;

class ProfileController extends Controller
{
    /** @var  NotificationRepository */
    private $notificationRepository;
    private $userRepository;
    /** @var  NotificationSampleRepository */
    private $notificationSampleRepository;

    public function __construct(NotificationRepository $notificationRepo, UserRepository $userRepo, NotificationSampleRepository $notificationSampleRepo)
    {
        $this->notificationRepository = $notificationRepo;
        $this->userRepository = $userRepo;
        $this->notificationSampleRepository = $notificationSampleRepo;
    }

    public function profile()
    {
        if (Auth::user()->hasRole('developer')){
            return $this->developer();
        }
        elseif (Auth::user()->hasRole('client_developer')){
            return $this->client_developer();
        }
        elseif(Auth::user()->hasRole('manager')){
            return $this->manager();
        }
    }

    public function developer()
    {
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
        return view('profiles.developer_profile')
            ->with('departments', $departments);
    }

    public function client_developer()
    {
        return view('profiles.client_developer_profile');
    }

    public function manager()
    {
        $notificationSamples = collect();
        $all = $this->notificationSampleRepository->all();
        $manage_histories = Auth::user()->under_managment();
        foreach ($all as $notificationSample) {
            foreach ($manage_histories as $manage_history) {
                if (isset($notificationSample->notifier) && isset($notificationSample->notifier->owner)) {
                    if (get_class($manage_history->managed) == get_class($notificationSample->notifier->owner) && $manage_history->managed->id == $notificationSample->notifier->owner->id) {
                        $notificationSamples->push($notificationSample);
                    }
                }
            }
        }

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

        return view('profiles.manager_profile')
            ->with('notificationSamples', $notificationSamples->sortByDesc('updated_at'))
            ->with('departments', $departments);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function updateProfile(UpdateUserRequest $request)
    {

        if(Auth::user()->hasRole('developer')){
            $this->developer_update($request);
        }
        elseif(Auth::user()->hasRole('client_developer')){
            $this->client_developer_update($request);
        }
        elseif(Auth::user()->hasRole('manager')){
            $this->manager_update($request);
        }

        Flash::success('صفحه‌ی شخصی با موفقیت به روز شد');

        return redirect(route('profile'));
    }


    public function developer_update($request)
    {
        /** drop invalid fields */
        $input = collect(request()->only(['first_name', 'last_name', 'password', 'confirm_password', 'avatar_path', 'username', 'email']))->filter(function($value) {
            return null !== $value;
        })->toArray();

        $user = $this->userRepository->findWithoutFail(Auth::user()->id);

        if (empty($user)) {
            Flash::error('حساب کاربری وجود ندارد');

            return redirect(route('home'));
        }

//            $this->authorize('updateProfile', $user);

        if($request->hasFile('avatar_path')){
            $path = $request->file('avatar_path')->store('/public/profile');
            $path = str_replace('public', 'storage', $path);
            $input['avatar_path'] = '/' . $path;

            /**
             * delete old avatar image,
             * to prevent Accumulation of dead files
             */
            $file_name = 'storage\\profile\\'.last(explode('/', $user->avatar_path));
            if (is_file($file_name)){
                unlink($file_name); //delete old avatar image
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln('حذف: ' . $file_name);
            } else {
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln('تصویر پیدا نشد.');
            }
        }

        if(isset($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }

        $user = $this->userRepository->update($input, $user->id);
    }

    public function client_developer_update($request)
    {
        /** drop invalid fields */
        $input = collect(request()->only(['first_name', 'last_name', 'password', 'confirm_password', 'avatar_path', 'username']))->filter(function($value) {
            return null !== $value;
        })->toArray();

        $user = $this->userRepository->findWithoutFail(Auth::user()->id);

        if (empty($user)) {
            Flash::error('حساب کاربری وجود ندارد');

            return redirect(route('home'));
        }

//            $this->authorize('updateProfile', $user);

        if($request->hasFile('avatar_path')){
            $path = $request->file('avatar_path')->store('/public/profile');
            $path = str_replace('public', 'storage', $path);
            $input['avatar_path'] = '/' . $path;

            /**
             * delete old avatar image,
             * to prevent Accumulation of dead files
             */
            $file_name = 'storage\\profile\\'.last(explode('/', $user->avatar_path));
            if (is_file($file_name)){
                unlink($file_name); //delete old avatar image
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln('حذف: ' . $file_name);
            } else {
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln('تصویر پیدا نشد.');
            }
        }

        if(isset($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }

        $user = $this->userRepository->update($input, $user->id);
    }

    public function manager_update($request)
    {
        $input = collect(request()->only(['first_name', 'last_name', 'password', 'confirm_password', 'avatar_path']))->filter(function($value) {
            return null !== $value;
        })->toArray();
        $user = $this->userRepository->findWithoutFail(Auth::user()->id);

        if (empty($user)) {
            Flash::error('حساب کاربری وجود ندارد');

            return redirect(route('home'));
        }

//            $this->authorize('updateProfile', $user);

        if($request->hasFile('avatar_path')){
            $path = $request->file('avatar_path')->store('/public/profile');
            $path = str_replace('public', 'storage', $path);
            $input['avatar_path'] = '/' . $path;

            /**
             * delete old avatar image,
             * to prevent Accumulation of dead files
             */
            $file_name = 'storage\\profile\\'.last(explode('/', $user->avatar_path));
            if (is_file($file_name)){
                unlink($file_name); //delete old avatar image
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln('حذف: ' . $file_name);
            } else {
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln('تصویر پیدا نشد.');
            }
        }

        if(isset($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }

        $user = $this->userRepository->update($input, $user->id);
    }
}
