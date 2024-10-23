<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Hash;


class DashboardController extends Controller
{
    public function index() {
        $data['mhs'] = Mahasiswa::all()->count();
        $data['dsn'] = Dosen::all()->count();
        return view('admin.dashboard.index', compact('data'));
    }
}
