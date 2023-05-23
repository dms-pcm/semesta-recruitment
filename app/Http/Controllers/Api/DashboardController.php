<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Models\Participants;
use App\Models\Recruitment;
use App\Models\User;

class DashboardController extends Controller
{
    public function countRecruitment()
    {
        try {
            $query = Recruitment::count();
            if (!$query) {
                return response()->json([
                    'data' => $query,
                    'status' => [
                        'message' => 'Data gagal ditampilkan',
                        'code' => 200
                    ]
                ],200);
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

    public function countUser()
    {
        try {
            $query = User::where('role_id','=','2')->count();
            if (!$query) {
                return response()->json([
                    'data' => ['-'],
                    'status' => [
                        'message' => 'Data gagal ditampilkan',
                        'code' => 200
                    ]
                ],200);
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

    public function chart()
    {
        try {
            $query1 = Participants::count();
            $query2 = Participants::where('status_peserta','=','1')->count();
            $query3 = Participants::where('status_peserta','=','2')->count();
            if (!$query1 || !$query2 || !$query3) {
                return response()->json([
                    'data' => [
                        'all' => $query1,
                        'no' => $query2,
                        'yes' => $query3
                    ],
                    'status' => [
                        'message' => 'Data gagal ditampilkan',
                        'code' => 200
                    ]
                ],200);
            }

            return response()->json([
                'data' => [
                    'all' => $query1,
                    'no' => $query2,
                    'yes' => $query3
                ],
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

    public function grafik(Request $request)
    {
        try {
            $query1 = Participants::where('recruitment_id','=',$request->input('rektID'))->count();
            $query2 = Participants::where('recruitment_id','=',$request->input('rektID'))->where('status_peserta','=','1')->count();
            $query3 = Participants::where('recruitment_id','=',$request->input('rektID'))->where('status_peserta','=','2')->count();
            if (!$query1 || !$query2 || !$query3) {
                return response()->json([
                    'data' => [
                        'all' => $query1,
                        'tidak' => $query2,
                        'lolos' => $query3
                    ],
                    'status' => [
                        'message' => 'Data gagal ditampilkan',
                        'code' => 200
                    ]
                ],200);
            }

            return response()->json([
                'data' => [
                    'all' => $query1,
                    'tidak' => $query2,
                    'lolos' => $query3
                ],
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

    public function newRekt()
    {
        try {
            $query = Recruitment::orderBy('id', 'DESC')->get();
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data gagal ditampilkan',
                        'code' => 200
                    ]
                ],200);
            }

            if ($query->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data gagal ditampilkan',
                        'code' => 200
                    ]
                ],200);
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
}
