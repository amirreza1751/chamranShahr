<?php

namespace App\Http\Controllers;

use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
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
}
