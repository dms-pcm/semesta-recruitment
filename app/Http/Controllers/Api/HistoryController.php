<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Participants;

class HistoryController extends Controller
{
    public function historyParticipant()
    {
        try {
            $query = Participants::where('user_id','=', Auth::id())->with('berkas','rekrut','berkasDiri')->get();
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data gagal ditampilkan',
                        'code' => 500
                    ]
                ],500);
            }

            if ($query->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Anda belum melakukan pendaftaran rekrutmen.',
                        'code' => 422
                    ]
                ],422);
            }
            // return response()->json([
            //     'data' => $query,
            //     'status' => [
            //         'message' => 'Data berhasil ditampilkan',
            //         'code' => 200
            //     ]
            // ],200);
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if ($row->status_berkas == 1) {
                        $actionBtn = '
                        <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="view('.$row->id.')"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                        </ul>
                        ';
                    } elseif ($row->status_berkas == 2) {
                        $actionBtn = '
                        <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="view('.$row->id.')"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                        </ul>
                        ';
                    } elseif ($row->status_berkas == 3) {
                        $actionBtn = '
                        <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="view('.$row->id.')"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                            <li id="aksi-edit"><a class="dropdown-item" href="javascript:void(0)" onclick="edit('.$row->id.')"><i class="bi bi-pencil-fill text-warning"></i> Edit</a></li>
                        </ul>
                        ';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $ex) {
            return response()->json([
                'data' => [],
                'status' => [
                    'message' => $ex->getMessage(),
                    'code' => 500
                ]
            ],500);
        }
    }
}
