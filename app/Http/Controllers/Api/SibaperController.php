<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\BeritaAcara;
use App\Models\jadwal;
use App\Models\ruang;
use App\Models\Dosen;
use App\Models\Rps;
use Illuminate\Support\Facades\Auth;


class SibaperController extends BaseController
{
    public function Homepage()
    {
        $nip = Auth::user()->id;
        // Ambil data BeritaAcara berdasarkan NIP pengguna yang terautentikasi
        $data =BeritaAcara ::where('nip', $nip)
            ->select(['nip', 'id_jadwal'])
            ->with([
                'jadwal' => function ($q) {
                    $q->select(['id_jadwal', 'semester', 'start', 'finish', 'id_kelas'])
                      ->with(['kelas' => function ($que) {
                          $que->select(['id_kelas', 'abjad_kelas']);
                      }]);
                },
                'dosen' => function ($q) {
                    $q->select(['nip', 'nama']);
                }
            ])
            ->get();
    
        // Cek apakah data kosong
        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    
        // Sembunyikan kolom yang tidak perlu
        $data->each(function ($item) {
            $item->makeHidden(['id_jadwal']);
            if ($item->jadwal) {
                $item->jadwal->makeHidden(['id_jadwal', 'id_kelas']);
                if ($item->jadwal->kelas) {
                    $item->jadwal->kelas->makeHidden(['id_kelas']);
                }
            }
            $item->dosen->makeHidden(['nip']);
        });
    
        // Kembalikan respons sukses
        return $this->sendResponse($data, 'Sukses mengambil data');
    }
        public function Historypage(){
            $nip = Auth::user()->id;
            
                $data = BeritaAcara::where('nip',$nip)
                ->select([
                    'minggu_ke',
                    'nip',
                    'id_jadwal',
                    'tanggal',
                    'nama_matkul',
                    'bahan_kajian',
                    'sub_bahan_kajian',
                    'status',
                ])->get();
                foreach($data as $d) {
                    $d->rps->pokok_bahasan;
                    $d->rps->sub_pokok_bahasan;
                }
                
                    if ($data->isEmpty()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'data tidak ditemukan',
                        ], 404);

                        // $data->each(function($item) {
                        //     $item -> makehidden(['nip','id_jadwal']);
                        // });
                    }
                return $this->sendResponse($data, 'sukses mengambil data history');
            }


    public function berita_acara_create(Request $request)
    {
        // Get the logged-in user's ID (nip)
        $nip = Auth::user()->id;

        // Validate the incoming request data, without needing to validate nip
        $data = $request->validate([
            'id_jadwal' => 'required',
            'id_rps' => 'required',
            'tanggal' => 'required|date', // Ensure tanggal is a valid date
            'media' => 'required',
            'jam_ajar' => 'required',
            'minggu_ke' => 'required',
            'status' => 'required' // Ensure status is one of the allowed values
        ]);

      
        // Create a new BeritaAcara entry
        $beritaacara = BeritaAcara::create([
            'nip' => $nip, // Automatically use the logged-in user's NIP
            'id_jadwal' => $data['id_jadwal'], // Use validated data
            'id_rps' => $data['id_rps'],
            'tanggal' => $data['tanggal'],
            'media' => $data['media'],
            'jam_ajar' => $data['jam_ajar'],
            'minggu_ke' => $data['minggu_ke'],
            'status' => $data['status']
            
        ]);
        $beritaacara->makeHidden(['id','updated_at','created_at'],);

        // Return a success response
        return $this->sendResponse($beritaacara, 'Sukses membuat Data!');
    }
 }
