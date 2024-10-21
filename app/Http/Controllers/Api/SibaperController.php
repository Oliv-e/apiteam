<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\BeritaAcara;
use App\Models\jadwal;
use App\Models\ruang;

class SibaperController extends BaseController
{
    public function kelas(Request $request)
    {

        $data = Kelas::select('id_kelas', 'abjad_kelas')
            ->with([
                'matkul','dosen'
            ])
            ->get();


        return $this->SendResponse($data,'Sukses Mengambil Data');
    }

    public function BeritaAcara(Request $request)
    {

    //$data = BeritaAcara::select('nip', 'id_jadwal', 'tanggal', 'id_rps', 'media', 'jam_ajar')
    $data = BeritaAcara::select('nip', 'id_jadwal', 'tanggal', 'id_rps', 'media', 'jam_ajar')
        ->with([
            'matkul',
            'dosen',
            'rps',
            'jadwal'
        ])
        ->get();


    return $this->SendResponse($data, 'Sukses Mengambil Data');
    }

    public function jadwal(Request $request)
    {

    $data = jadwal::select('id_jadwal','id_kelas','kode_matkul','id_ruang','hari','start','finish', 'semester',  )
        ->with([
            'matkul',
            'kelas',
            'ruang'
        ])
        ->get();
    return $this->SendResponse($data, 'Sukses Mengambil Data');
    }

    public function ruang(Request $request)
    {

    $data = ruang::select('id_ruang','nama_ruang' )
        ->with([

        ])
        ->get();


    return $this->SendResponse($data, 'Sukses Mengambil Data');
    }

    public function kelas_by_dosen_today(Request $request) {
        $user = $request->user();

        $kelas = Jadwal::where('nip', $user->id)->get();

        $data = $kelas->where('hari' , $this->getNamaHari());

        return $this->sendResponse($data, 'yhaha');
    }
}
