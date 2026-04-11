<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;

    class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalEmployees' => Employee::count(),
            'totalUsers' => User::count(),
            'adminCount' => User::where('role', 'admin')->count(),
            'hrCount' => User::where('role', 'hr')->count(),
        ]);
    }
}




