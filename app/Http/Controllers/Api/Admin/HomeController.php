<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Task;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct(private User $user, private City $city,
    private Task $task){}

    public function view(Request $request){
        $users = $this->user
        ->where('role', 'user')
        ->where('account_status', 'active')
        ->get();
        $users_volunters = $this->user
        ->where('role', 'user')
        ->where('account_status', 'active')
        ->whereNotNull('orgnization_id')
        ->get();
        $users_count = $users->count();
        $current_tasks_count = $this->task
        ->where('date', '>=', date('Y-m-d'))
        ->count();
        $ended_tasks_count = $this->task
        ->where('date', '<', date('Y-m-d'))
        ->count();
        $user_year = [
            'Jan' => $users->where('year', date('Y'))->where('month', 1),
            'Feb' => $users->where('year', date('Y'))->where('month', 2),
            'Mar' => $users->where('year', date('Y'))->where('month', 3),
            'Apr' => $users->where('year', date('Y'))->where('month', 4),
            'May' => $users->where('year', date('Y'))->where('month', 5),
            'June' => $users->where('year', date('Y'))->where('month', 6),
            'July' => $users->where('year', date('Y'))->where('month', 7),
            'Aug' => $users->where('year', date('Y'))->where('month', 8),
            'Sep' => $users->where('year', date('Y'))->where('month', 9),
            'Oct' => $users->where('year', date('Y'))->where('month', 10),
            'Nov' => $users->where('year', date('Y'))->where('month', 11),
            'Dec' => $users->where('year', date('Y'))->where('month', 12),
        ];
        $cities = $this->city
        ->withCount('users')
        ->get();

        return response()->json([
            'users_count' => $users_count,
            'users_volunters' => $users_volunters,
            'current_tasks_count' => $current_tasks_count,
            'ended_tasks_count' => $ended_tasks_count,
            'user_year' => $user_year,
            'cities' => $cities,
        ]);
    }
}
