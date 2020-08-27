<?php

namespace Lara\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Lara\Http\Middleware\RejectGuests;

use Lara\Shift;

class UserPersonalPageController extends Controller
{
    public function __construct()
    {
         $this->middleware(RejectGuests::class);
    }

    public function showPersonalPage()
    {
        $user = \Auth::user();

        $shifts = Shift::query()->where('person_id', '=', $user->person->id)
            ->with("schedule", "schedule.event.section", "schedule.event", "type")
            ->whereHas("schedule.event", function ($query) {
                $query->where('evnt_date_start', '>=', new \DateTime());
            })
            ->get()->sortBy('schedule.event.evnt_date_start');

        return View::make('userpersonalpage.index', compact('user', 'shifts'));
    }

    public function updatePerson()
    {
        $user = \Auth::user();
        $isNamePrivate = Input::get("is_name_private") == 'null' ? null : Input::get("is_name_private") == 'true';
        $generalNotifications = Input::get("generalNotifications") == 'null' ? null : Input::get("generalNotifications") == 'true';
        $eventNotifications = Input::get("eventNotifications") == 'null' ? null : Input::get("eventNotifications") == 'true';
        $shiftNotifications = Input::get("shiftNotifications") == 'null' ? null : Input::get("shiftNotifications") == 'true';
        $user->is_name_private = $isNamePrivate;
        $user->person->generalNotifications = $generalNotifications;
        $user->person->eventNotifications = $eventNotifications;
        $user->person->shiftNotifications = $shiftNotifications;
        $user->person->save();
        $user->save();
        // Return to the the section management page
        Session::put('message', trans('mainLang.changesSaved'));
        Session::put('msgType', 'success');

        return \Redirect::back();
    }
}
