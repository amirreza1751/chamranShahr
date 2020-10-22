<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Repositories\NotificationRepository;
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

    public function __construct(NotificationRepository $notificationRepo, UserRepository $userRepo)
    {
        $this->notificationRepository = $notificationRepo;
        $this->userRepository = $userRepo;
    }

    public function profile()
    {
        if(Auth::user()->hasRole('manager')){

            $notifications = collect();
            $all = $this->notificationRepository->all();
            $manage_histories = Auth::user()->under_managment();
            foreach ($all as $notification) {
                foreach ($manage_histories as $manage_history) {
                    if (isset($notification->notifier) && isset($notification->notifier->owner)) {
                        if (get_class($manage_history->managed) == get_class($notification->notifier->owner) && $manage_history->managed->id == $notification->notifier->owner->id) {
                            $notifications->push($notification);
                        }
                    }
                }
            }

            return view('profiles.manager_profile')
                ->with('notifications', $notifications);
        }
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

        if(Auth::user()->hasRole('manager')){

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

        Flash::success('صفحه‌ی شخصی با موفقیت به روز شد');

        return redirect(route('profile'));
    }
}
