<?php

namespace App\Http\Controllers\Api\Orgnization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\City;
use App\Models\Task;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct(private User $user, private City $city,
    private Task $task, private Country $country){}

    public function view(Request $request){
        $users = $this->user
        ->where('role', 'user')
        ->where('account_status', 'active')
        ->where('orgnization_id', $request->user()->orgnization_id)
        ->get();
        $users_volunters = $this->user
        ->where('role', 'user')
        ->where('account_status', 'active')
        ->where('orgnization_id', $request->user()->orgnization_id)
        ->count();
        $users_count = $users->count();
        $current_tasks_count = $this->task
        ->where('date', '>=', date('Y-m-d'))
        ->where('orgnization_id', $request->user()->orgnization_id)
        ->count();
        $ended_tasks_count = $this->task
        ->where('date', '<', date('Y-m-d'))
        ->where('orgnization_id', $request->user()->orgnization_id)
        ->count();
        $user_year = [
            'Jan' => $users->where('year', date('Y'))->where('month', 1)->count(),
            'Feb' => $users->where('year', date('Y'))->where('month', 2)->count(),
            'Mar' => $users->where('year', date('Y'))->where('month', 3)->count(),
            'Apr' => $users->where('year', date('Y'))->where('month', 4)->count(),
            'May' => $users->where('year', date('Y'))->where('month', 5)->count(),
            'June' => $users->where('year', date('Y'))->where('month', 6)->count(),
            'July' => $users->where('year', date('Y'))->where('month', 7)->count(),
            'Aug' => $users->where('year', date('Y'))->where('month', 8)->count(),
            'Sep' => $users->where('year', date('Y'))->where('month', 9)->count(),
            'Oct' => $users->where('year', date('Y'))->where('month', 10)->count(),
            'Nov' => $users->where('year', date('Y'))->where('month', 11)->count(),
            'Dec' => $users->where('year', date('Y'))->where('month', 12)->count(),
        ];
        $cities = $this->city
        ->withCount(['users' => function($query) use($request){
            $query->where('orgnization_id', $request->user()->orgnization_id)
            ->where('role', 'user')
            ->where('account_status', 'active');
        }])
        ->get();
        $country = $this->country
        ->withCount(['users' => function($query) use($request){
            $query->where('orgnization_id', $request->user()->orgnization_id)
            ->where('role', 'user')
            ->where('account_status', 'active');
        }])
        ->get();

        return response()->json([
            'users_count' => $users_count,
            'users_volunters' => $users_volunters,
            'current_tasks_count' => $current_tasks_count,
            'ended_tasks_count' => $ended_tasks_count,
            'user_year' => $user_year,
            'cities' => $cities->sortByDesc('users_count')->values(),
            'countries' => $country->sortByDesc('users_count')->values(),
        ]);
    }
}
