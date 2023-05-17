<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Syarat;

class PersyaratanController extends Controller
{
    public function index()
    {
        try {
            $query = Syarat::orderBy('id', 'DESC')->get();
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
                        'message' => 'Data persyaratan belum tersedia.',
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
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="editSyarat('.$row->id.')"><i class="bi bi-pencil-fill text-warning"></i> Edit</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteSyarat('.$row->id.')"><i class="bi bi-trash-fill text-danger"></i> Hapus</a></li>
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

    public function showSyaratFe()
    {
        try {
            $query = Syarat::select('id','syarat','type','format')->orderBy('id', 'DESC')->get();
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
                        'message' => 'Data persyaratan belum tersedia.',
                        'code' => 422
                    ]
                ],422);
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

    public function store(Request $request)
    {
        try {
            if(Auth()->user()->role_id != 1){
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Anda tidak memiliki akses',
                        'code' => 403
                    ]
                ],403);
            }

            $errMessages = [
                'persyaratan.required' => 'Persyaratan wajib diisi!',
                'type.required' => 'Tipe wajib diisi!',
            ];

            $validator = Validator::make($request->all(),[
                'persyaratan' => 'required',
                'type' => 'required',
            ],$errMessages);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => [
                        'message' => 'Form tidak valid',
                        'code' => 422,
                    ]
                ],422);
            }

            $data = Syarat::create([
                'syarat' => $request->persyaratan,
                'type' => $request->type,
                'format' => $request->format,
            ]);

            if ($data) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Persyaratan rekrutmen berhasil ditambah.',
                        'code' => 200
                    ]
                ],200);
            }
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
            $query = Syarat::find($id);
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

    public function edit(Request $request, $id)
    {
        try {
            if(Auth()->user()->role_id != 1){
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Anda tidak memiliki akses',
                        'code' => 403
                    ]
                ],403);
            }

            $errMessages = [
                'persyaratan.required' => 'Persyaratan wajib diisi!',
                'type.required' => 'Tipe wajib diisi!',
            ];

            $validator = Validator::make($request->all(),[
                'persyaratan' => 'required',
                'type' => 'required',
            ],$errMessages);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => [
                        'message' => 'Form tidak valid',
                        'code' => 422,
                    ]
                ],422);
            }

            $update = Syarat::find($id);

            if ($update) {
                $data = [
                    'syarat' => $request->persyaratan,
                    'type' => $request->type,
                    'format' => $request->format,
                ];

                $update->update($data);

                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Persyaratan rekrutmen berhasil diubah.',
                        'code' => 200
                    ]
                ],200);
            }
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
            $cek_data = Syarat::find($id);
            if (!$cek_data) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            $query = Syarat::destroy($id);
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
                    'message' => 'Persyaratan berhasil dihapus',
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