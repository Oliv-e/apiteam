<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Hash;


class DashboardController extends Controller
{
    public function index() {
        return view('admin.dashboard.index');
    }
}
