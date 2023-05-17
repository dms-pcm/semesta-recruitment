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
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        try {
            $query = User::where('role_id', '=', '2')->orderBy('id', 'DESC')->get();
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
                        'message' => 'Data user belum tersedia.',
                        'code' => 422
                    ]
                ],422);
            }

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '
                    <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="view('.$row->id.')"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="hapus('.$row->id.')"><i class="bi bi-trash-fill text-danger"></i> Hapus</a></li>
                    </ul>
                    ';
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

    public function detail($id)
    {
        try {
            $query = User::find($id);
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data gagal ditampilkan',
                        'code' => 500
                    ]
                ],500);
            }

            return response()->json([
                'data' => $query,
                'status' => [
                    'message' => 'Data berhasil ditampilkan',
                    'code' => 200
                ]
            ],200);
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

    public function destroy($id)
    {
        try {
            $cek_data = User::find($id);
            if (!$cek_data) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            $query = User::destroy($id);
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data gagal dihapus',
                        'code' => 500
                    ]
                ],500);
            }

            $cek_data->delete();
            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Data user berhasil dihapus',
                    'code' => 200
                ]
            ],200);
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
