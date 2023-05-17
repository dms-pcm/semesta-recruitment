<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportParticipants;
use App\Exports\DaftarHadirExport;
use App\Models\Participants;

class ExportController extends Controller
{
    public function exportData(Request $request)
    {
        $data = Participants::select('recruitment_name','name_user','phone','address','email','status_berkas','status_peserta')
                            ->where('recruitment_id', $request->input('id_rekt'))
                            ->get();
        // $data->transform(function ($item) {
        //     if ($item->tb == null) {
        //         $item->tb = $item->tb ?? '-';
        //     } else {
        //         $item->tb = $item->tb . ' cm';
        //     }

        //     if ($item->bb == null) {
        //         $item->bb = $item->bb ?? '-';
        //     } else {
        //         $item->bb = $item->bb . ' kg';
        //     }
        //     return $item;
        // });

        $data->map(function ($item) {
            // Mengubah nilai kolom
            if ($item->status_berkas == 1) {
                $item->status_berkas = 'Perlu Pemeriksaan';
            }
            if($item->status_berkas == 2){
                $item->status_berkas = 'Sudah Lengkap';
            }
            if($item->status_berkas == 3){
                $item->status_berkas = 'Belum Lengkap';
            }
        
            return $item;
        });

        $data->map(function ($item) {
            // Mengubah nilai kolom
            if ($item->status_peserta == null) {
                $item->status_peserta = '-';
            }
            if ($item->status_peserta == 1) {
                $item->status_peserta = 'Tidak Lolos Seleksi';
            }
            if($item->status_peserta == 2){
                $item->status_peserta = 'Lolos Seleksi';
            }
        
            return $item;
        });

        $data = $data->map(function ($item, $index) {
            $new_item = new \stdClass;
            $new_item->no_increment = $index + 1;
            foreach ($item->toArray() as $key => $value) {
                $new_item->$key = $value;
            }
            return $new_item;
        });
        
        $data = $data->map(function ($item) {
            $new_item = [];
            $new_item['no_increment'] = $item->no_increment;
            unset($item->no_increment);
            foreach ($item as $key => $value) {
                $new_item[$key] = $value;
            }
            return $new_item;
        });

        //Menambahkan string pada kolom tertentu
        // $data->map(function ($item) {
        //     $item->tb = $item->tb . ' cm';
        //     return $item;
        // });

        // dd($data);

        return Excel::download(new ExportParticipants($data), 'Data Peserta-'.$request->input('nama_rekt').'.xlsx'); // ekspor data menggunakan plugin export Excel
    }

    public function dataHadir(Request $request)
    {
        $data = Participants::select('name_user','phone','email')
                            ->where('recruitment_id', $request->input('rekt_id'))
                            ->get();

        $data = $data->map(function ($item, $index) {
            $new_item = new \stdClass;
            $new_item->no_increment = $index + 1;
            foreach ($item->toArray() as $key => $value) {
                $new_item->$key = $value;
            }
            return $new_item;
        });
        
        $data = $data->map(function ($item) {
            $new_item = [];
            $new_item['no_increment'] = $item->no_increment;
            unset($item->no_increment);
            foreach ($item as $key => $value) {
                $new_item[$key] = $value;
            }
            return $new_item;
        });

        return Excel::download(new DaftarHadirExport($data), 'Daftar Hadir Peserta-'.$request->input('nama_rekt').'.xlsx');
    }
}
