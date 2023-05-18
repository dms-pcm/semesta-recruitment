<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifData;
use App\Mail\EmailNotification;
use App\Models\Recruitment;
use App\Models\Syarat;
use App\Models\User;
use App\Models\PersyaratanRecruitment;

class RecruitmentController extends Controller
{
    protected $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('public');
    }

    public function index()
    {
        try {
            $query = Recruitment::with('persyaratan')->orderBy('id', 'DESC')->get();
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
                        'message' => 'Data rekrutmen belum tersedia.',
                        'code' => 422
                    ]
                ],422);
            }
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if ($row->status_recruitment == 0) {
                        $actionBtn = '
                        <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewDetail('.$row->id.')"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="editRekrutmen('.$row->id.')"><i class="bi bi-pencil-fill text-warning"></i> Edit</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteRekrutmen('.$row->id.')"><i class="bi bi-trash-fill text-danger"></i> Hapus</a></li>
                        </ul>
                        ';
                    } else {
                        $actionBtn = '
                        <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewDetail('.$row->id.')"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="editRekrutmen('.$row->id.')"><i class="bi bi-pencil-fill text-warning"></i> Edit</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="selesai('.$row->id.')"><i class="bi bi-check-circle-fill text-success"></i> Selesai</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteRekrutmen('.$row->id.')"><i class="bi bi-trash-fill text-danger"></i> Hapus</a></li>
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

    public function showRekt()
    {
        try {
            $query = Recruitment::with('persyaratan')->where('status_recruitment','=','1')->orderBy('id', 'DESC')->get();
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
                        'message' => 'Data rekrutmen belum tersedia.',
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

    public function getSyarat()
    {
        try {
            $query = Syarat::select('id','syarat')->get();
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
                        'message' => 'Data syarat belum tersedia.',
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
        $attachment = null;
        try {
            $errMessages = [
                'title.required' => 'Judul wajib diisi!',
                'clock.required' => 'Pukul wajib diisi!',
                'location.required' => 'Lokasi wajib diisi!',
                'attachment.required' => 'Upload gambar wajib diisi!',
                'attachment.mimetypes' => 'Gambar yang diperbolehkan berupa file .jpeg, .jpg, .png',
                'persyaratan.required' => 'Persyaratan wajib diisi!',
                'description.required' => 'Deskripsi wajib diisi!',
                'quantity.required' => 'Kuota Peserta wajib diisi!',
                'quantity.numeric' => 'Kuota Peserta harus berupa angka',
            ];

            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'clock' => 'required',
                'location' => 'required',
                'attachment' => 'required|mimetypes:image/jpeg,image/jpg,image/png',
                'persyaratan' => 'required',
                'description' => 'required',
                'quantity' => 'required|numeric',
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

            if(Auth()->user()->role_id != 1){
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Anda tidak memiliki akses',
                        'code' => 403
                    ]
                ],403);
            }

            if (!empty($request->attachment)) {
                if (!$request->attachment->isValid()) {
                    return response()->json([
                        'data' => [],
                        'status' => [
                            'message' => 'Tidak dapat mengunggah gambar.',
                            'code' => 422,
                        ]
                    ],422);
                }
                
                $path = $this->uploadPath($request->attachment->getMimeType());

                if (!$this->storage->exists($path)) {
                    $this->storage->makeDirectory($path);
                }

                $attachment = $request->attachment->store($path, 'public');
            }
            
            $role = auth()->user()->role_id;
            $users = User::when($role == 1, function ($query) {
                $query->where('role_id', 2);
            })->get();

            $data_recruitment = Recruitment::create([
                'title' => $request->title,
                'clock' => $request->clock,
                'location' => $request->location,
                'attachment' => $attachment,
                // 'persyaratan' => $request->persyaratan,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'status_recruitment' => '1',
            ]);

            Notification::send($users, new NotifData('Rekrutmen '.$request->title.' baru ditambahkan oleh admin.', route('informasi.rekrutmen')));

            $data_syarat = $request->persyaratan;
            foreach (explode(",", $data_syarat) as $id) {
                PersyaratanRecruitment::create([
                    'recruitment_id' => $data_recruitment->id,
                    'persyaratan_id' => $id,
                ]);
            }

            if ($data_recruitment) {
                // Mengambil email dari tabel users
                $emails = DB::table('users')->pluck('email')->toArray();
                
                // Looping email dan mengirim notifikasi
                $data = [
                    'foto' => asset('storage/'.$data_recruitment->attachment),
                    'idRect' => 'http://semesta-recruitment.test/detail-information?='.$data_recruitment->id,
                    'title' => $data_recruitment->title,
                    'kuota' => $data_recruitment->quantity
                ];
                $content = view('emails.notification', $data)->render();
                // dd($data);
                // $content = view('emails.notification')->render();
                foreach ($emails as $email) {
                    //Start Tanpa tampilan html
                    // Mail::raw('isi content', function($message) use ($email) {
                    //     $message->to($email)->subject('Pemberitahuan rekrutmen baru dari Semesta Recruitment');
                    // });
                    //End Tanpa tampilan html

                    if ($email != "admin@gmail.com") {
                        Mail::to($email)->send(new EmailNotification($content));
                    }
                }
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Jadwal rekrutmen berhasil dibuat.',
                        'code' => 200
                    ]
                ],200);
            }
        } catch (\Exception $ex) {
            $this->storage->delete($attachment);
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
        $attachment = null;
        try {
            $errMessages = [
                'title.required' => 'Judul wajib diisi!',
                'clock.required' => 'Pukul wajib diisi!',
                'location.required' => 'Lokasi wajib diisi!',
                // 'attachment.required' => 'Upload gambar wajib diisi!',
                'attachment.mimetypes' => 'Gambar yang diperbolehkan berupa file .jpeg, .jpg, .png',
                'persyaratan.required' => 'Persyaratan wajib diisi!',
                'description.required' => 'Deskripsi wajib diisi!',
                'quantity.required' => 'Kuota Peserta wajib diisi!',
                'quantity.numeric' => 'Kuota Peserta harus berupa angka',
            ];

            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'clock' => 'required',
                'location' => 'required',
                'attachment' => 'nullable|mimetypes:image/jpeg,image/jpg,image/png',
                'persyaratan' => 'required',
                'description' => 'required',
                'quantity' => 'required|numeric',
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

            if(Auth()->user()->role_id != 1){
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Access denied',
                        'code' => 403
                    ]
                ],403);
            }

            if (!empty($request->attachment)) {
                if (!$request->attachment->isValid()) {
                    return response()->json([
                        'data' => [],
                        'status' => [
                            'message' => 'Tidak dapat mengunggah gambar.',
                            'code' => 422,
                        ]
                    ],422);
                }

                $path = $this->uploadPath($request->attachment->getMimeType());

                if (!$this->storage->exists($path)) {
                    $this->storage->makeDirectory($path);
                }

                $attachment = $request->attachment->store($path, 'public');
            }

            $update = Recruitment::find($id);
            if ($update) {
                $temp = $update->attachment;
                $data = [
                    'title' => $request->title,
                    'clock' => $request->clock,
                    'location' => $request->location,
                    // 'persyaratan' => $request->persyaratan,
                    'description' => $request->description,
                    'quantity' => $request->quantity
                ];

                if (!empty($request->attachment)) {
                    $data['attachment'] = $attachment;
                    $this->storage->delete($temp);
                }

                $update->update($data);
                // $update_syarat = $request->persyaratan;
                // foreach (explode(",", $update_syarat) as $syarat_id) {
                //     $update2 = PersyaratanRecruitment::find($request->id_syarat);
                //     $data2 = [
                //         'persyaratan_id' => $syarat_id,
                //     ];
                //     $update2->update($data2);
                // }

                // $update_syarat = $request->persyaratan;
                // $update_syarat_arr = explode(",", $update_syarat);

                // $update2 = PersyaratanRecruitment::where('recruitment_id', $request->id_recruitment);

                // if (count($update_syarat_arr) == 1 && in_array($update_syarat, $update2->pluck('persyaratan_id')->toArray())) {
                //     // Jika $request->persyaratan hanya berisi satu nilai dan nilai tersebut sudah ada di database, maka hapus data tersebut
                //     $update2->where('persyaratan_id', $update_syarat)->delete();
                // } else {
                //     // Jika $request->persyaratan berisi lebih dari satu nilai atau nilai tersebut belum ada di database, maka update atau tambahkan data sesuai dengan nilai yang dikirimkan
                //     $update2->delete();
                //     foreach ($update_syarat_arr as $syarat_id) {
                //         $data2 = [
                //             'recruitment_id' => $request->id_recruitment,
                //             'persyaratan_id' => $syarat_id,
                //         ];
                //         PersyaratanRecruitment::create($data2);
                //     }
                // }

                $update_syarat = $request->persyaratan;

                // Mengecek apakah data persyaratan kosong atau tidak
                // if(empty($update_syarat)){
                //     // Jika kosong, maka data persyaratan di database akan dihapus semua
                //     PersyaratanRecruitment::where('id', $request->id_syarat)->delete();
                // } else {
                    $persyaratan_ids = explode(",", $update_syarat);

                    // Mengambil data persyaratan recruitment yang sedang di-update
                    $update2 = PersyaratanRecruitment::where('recruitment_id', $request->id_recruitment);

                    // Mengambil data persyaratan recruitment yang telah tersimpan di database
                    $saved_syarat_ids = $update2->pluck('persyaratan_id')->toArray();

                    // Menambah data persyaratan baru yang belum tersimpan di database
                    $new_syarat_ids = array_diff($persyaratan_ids, $saved_syarat_ids);
                    foreach ($new_syarat_ids as $syarat_id) {
                        $data2 = [
                            'recruitment_id' => $request->id_recruitment,
                            'persyaratan_id' => $syarat_id,
                        ];
                        $update2->create($data2);
                    }

                    // Menghapus data persyaratan yang telah disimpan di database tetapi tidak ada di data persyaratan yang baru
                    $removed_syarat_ids = array_diff($saved_syarat_ids, $persyaratan_ids);
                    if (!empty($removed_syarat_ids)) {
                        $update2->whereIn('persyaratan_id', $removed_syarat_ids)->delete();
                    }
                // }

            }

            if ($update) {
                return response()->json([
                    'data' => $update,
                    'status' => [
                        'message' => 'Jadwal rekrutmen berhasil diubah.',
                        'code' => 200
                    ]
                ],200);
            }
        } catch (\Exception $ex) {
            $this->storage->delete($attachment);
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
            $query = Recruitment::with('persyaratan')->find($id);
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
            $cek_data = Recruitment::find($id);
            if (!$cek_data) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            $query = Recruitment::destroy($id);
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
                    'message' => 'Data rekrutmen berhasil dihapus',
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

    public function done($id)
    {
        try {
            $query = Recruitment::find($id);
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            if ($query->status_recruitment == '0') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Rekrutmen sudah dinyatakan selesai terlaksana.',
                        'code' => 422
                    ]
                ],422);
            }

            $query->update([
                'status_recruitment' => '0'
            ]);

            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Rekrutmen sudah selesai terlaksana.',
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

    private function uploadPath($blob, $path = 'flayer-rekrutmen')
    {
        $data = [];

        if (!is_null($path)) {
            $data[] = $path;
        }

        switch ($blob) {
            case 'image/jpeg':
                $data[] = 'images';
                break;
            case 'image/jpg':
                $data[] = 'images';
                break;
            case 'image/png':
                $data[] = 'images';
                break;
            default:
                $data[] = 'others';
                break;
        }

        return implode('/',$data);
    }
}
