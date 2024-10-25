<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends BaseController
{
    public function login(Request $request) {
        if(Auth::attempt(['id' => $request->id, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; // global
            $success['nama'] = $user->data_pribadi->nama; // kebutuhan kelompok ridho
            $success['role'] = $user->role; // kebutuhan kelompok iqbal

            return $this->sendResponse($success, 'Berhasil Login');
        }
        else{
            return $this->sendError('ID / Password yang anda masukkan salah!.', ['error'=>'Error']);
        }
    }
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create([
            'id' => $request->id,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if ($request->role == 'Mahasiswa') {
            Mahasiswa::create([
                'nim' => $request->id,
                'nama' => $request->nama,
                'kode_prodi' => $request->kode_prodi,
                'semester' => $request->semester,
                'id_kelas' => $request->id_kelas,
                'nip' => $request->nip,
                'no_hp' => $request->no_hp
            ]);
        }
        if ($request->role == 'Dosen') {
            Dosen::create([
                'nip' => $request->id,
                'nama' => $request->nama,
                'no_hp' => $request->no_hp
            ]);
        }
        // if ($request->role == 'Admin') {
        //     Staff::create([
        //         'id' => $request->id,
        //         'nama' => $request->nama,
        //         'no_hp' => $request->no_hp
        //     ]);
        // }

        return $this->sendResponse($user, 'User register successfully.');
    }
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse("Success", 'User Logout successfully');
    }
}
