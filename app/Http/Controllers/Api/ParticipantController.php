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
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifData;
use App\Models\Participants;
use App\Models\Recruitment;
use App\Models\Files;
use App\Models\BerkasDataDiri;
use App\Models\User;

class ParticipantController extends Controller
{
    protected $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('public');
    }

    public function index()
    {
        try {
            $query = Participants::get();
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
                        'message' => 'Data peserta belum tersedia.',
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

    public function getParticipant()
    {
        try {
            $query = Participants::select('user_id','recruitment_id')->get();
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
                        'message' => 'Data peserta belum tersedia.',
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

    public function filter(Request $request)
    {
        try {
            $query = Participants::where('recruitment_id', '=', $request->id_recruitment)->orderBy('id', 'DESC')->get();
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
                        'message' => 'Data peserta belum tersedia.',
                        'code' => 422
                    ]
                ],422);
            }

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if ($row->status_peserta == 1 || $row->status_peserta == 2) {
                        $actionBtn = '
                        <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="view('.$row->id.')"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="hapus('.$row->id.')"><i class="bi bi-trash-fill text-danger"></i> Hapus</a></li>
                        </ul>
                        ';
                    } else {
                        $actionBtn = '
                        <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="view('.$row->id.')"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="hapus('.$row->id.')"><i class="bi bi-trash-fill text-danger"></i> Hapus</a></li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="javascript:void(0)"><i class="bi bi-person-badge text-warning"></i> Status Peserta</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="accept('.$row->id.')">Lolos Seleksi</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="decline('.$row->id.')">Tidak Lolos Seleksi</a></li>
                                </ul>
                            </li>
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

    public function getTitle()
    {
        try {
            $query = Recruitment::select('id','title')->get();
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

    public function detail($id)
    {
        try {
            $query = Participants::with('berkas','berkasDiri')->find($id);
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
            $cek_data = Participants::find($id);
            if (!$cek_data) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            $query = Participants::destroy($id);
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data gagal dihapus',
                        'code' => 500
                    ]
                ],500);
            }

            $cek_data->berkas()->where('participant_id', '=', $id)->delete();

            //kuota pendaftaran
            $dataId = Recruitment::find($cek_data->recruitment_id);
            $math = $dataId->current_quantity + 1;
            $query = Recruitment::where('id', '=', $cek_data->recruitment_id)->update([
                'current_quantity' => $math
            ]);

            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Data berhasil dihapus',
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
            $errMessages = [
                // 'attachment.*.required' => 'Upload berkas wajib diisi!',
                'dataFile.*.attachment.mimes' => 'Berkas yang diperbolehkan berupa file .jpeg, .jpg, .png, .pdf',
                'name_user.required' => 'Nama wajib diisi!',
                'phone.required' => 'No.Handphone wajib diisi!',
                'phone.regex' => ' Format no.handphone tidak valid dan',
                'phone.min' => ' No.Handphone minimal harus 10 angka.',
                'address.required' => 'Alamat wajib diisi!',
                'email.required' => 'Email wajib diisi!',
                'email.email'=> 'Email harus alamat email yang valid!',
            ];

            $validator = Validator::make($request->all(),[
                'name_user' => 'required',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'address' => 'required',
                'email' => 'required|email',
                'dataFile.*.attachment' => 'mimes:jpg,jpeg,png,pdf',
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

            if ($request->dataFile == null) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Form tidak valid, Upload berkas wajib diisi!',
                        'code' => 422
                    ]
                ],422);
            }

            // dd(Recruitment::find($request->recruitment_id)->current_quantity == 0 && Recruitment::find($request->recruitment_id)->current_quantity != null);
            if (Recruitment::find($request->recruitment_id)->current_quantity == 0 && Recruitment::find($request->recruitment_id)->current_quantity != null) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Mohon maaf, anda tidak bisa melakukan pendaftaran. Dikarenakan kuota pendaftaran sudah habis',
                        'code' => 422
                    ]
                ],422);
            } else {
                // if (Participants::where('user_id','=',$request->user_id)->exists() && Participants::where('recruitment_id','=',$request->recruitment_id)->exists()) {
                if (Participants::where('user_id', $request->user_id)->where('recruitment_id', $request->recruitment_id)->exists()) {
                    // dd($request->user_id,$request->recruitment_id);
                    DB::rollBack();
                    return response()->json([
                        'data' => [],
                        'status' => [
                            'message' => 'Anda sudah melakukan daftar pada rekrutmen ini!',
                            'code' => 422
                        ]
                    ],422);
                }else{
                    //data peserta
                    // if (empty($request->tb) || empty($request->bb)) {
                    //     $data = [
                    //         'user_id' => $request->user_id,
                    //         'name_user' => $request->name_user,
                    //         'recruitment_id' => $request->recruitment_id,
                    //         'recruitment_name' => $request->recruitment_name,
                    //         'phone' => $request->phone,
                    //         'address' => $request->address,
                    //         'email' => $request->email,
                    //         // 'tb' => null,
                    //         // 'bb' => null,
                    //         'status_berkas' => '1'
                    //     ];
                    // } else {
                        $data = [
                            'user_id' => $request->user_id,
                            'name_user' => $request->name_user,
                            'recruitment_id' => $request->recruitment_id,
                            'recruitment_name' => $request->recruitment_name,
                            'phone' => $request->phone,
                            'address' => $request->address,
                            'email' => $request->email,
                            // 'tb' => $request->tb,
                            // 'bb' => $request->bb,
                            'status_berkas' => '1'
                        ];
                    // }
                    $new_participant = Participants::create($data);

                    //kuota pendaftaran
                    $dataId = Recruitment::find($new_participant->recruitment_id);
                    $math;
                    if ($dataId->current_quantity == null) {
                        $math = $dataId->quantity - 1;
                    } else {
                        $math = $dataId->current_quantity - 1;
                    }
                    $query = Recruitment::where('id', '=', $new_participant->recruitment_id)->update([
                        'current_quantity' => $math
                    ]);

                    //berkas peserta
                    foreach ($request->dataFile as $key => $value) {
                        $file = $request->dataFile[$key]['attachment'];
                        $path = $this->uploadPath($file->getMimeType());
                        if (!$this->storage->exists($path)) {
                            $this->storage->makeDirectory($path);
                        }
                        $attachment = $file->store($path, 'public');
                        
                        Files::create([
                            'syarat_id' => $request->dataFile[$key]['syarat_id'],
                            'recruitment_id' => $new_participant->recruitment_id,
                            'participant_id' => $new_participant->id,
                            'attachment' => $attachment,
                            'originalName' => $file->getClientOriginalName(),
                        ]);
                    }

                    if ($request->dataDiri == null) {
                        
                    } else {
                        foreach ($request->dataDiri as $key => $value) {
                            BerkasDataDiri::create([
                                'syarat_id' => $request->dataDiri[$key]['syarat_id'],
                                'recruitment_id' => $new_participant->recruitment_id,
                                'participant_id' => $new_participant->id,
                                'value' => $request->dataDiri[$key]['value'],
                            ]);
                        }
                    }

                    $role = auth()->user()->role_id;
                    $users = User::when($role == 2, function ($query) {
                        $query->where('role_id', 1);
                    })->get();

                    Notification::send($users, new NotifData($request->name_user.' telah melakukan pendaftaran pada rekrutmen '.$request->recruitment_name.'.', route('data.peserta',$request->recruitment_id)));

                    return response()->json([
                        'data' => [],
                        'status' => [
                            'message' => 'Daftar rekrutmen telah berhasil',
                            'code' => 200
                        ]
                    ],200);
                }
    
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

    public function edit(Request $request, $id)
    {
        try {
            $errMessages = [
                // 'dataFile.*.required' => 'Upload berkas wajib diisi!',
                'dataFile.*.attachment.mimes' => 'Berkas yang diperbolehkan berupa file .jpeg, .jpg, .png, .pdf',
                'name_user.required' => 'Nama wajib diisi!',
                'phone.required' => 'No.Handphone wajib diisi!',
                'phone.regex' => ' Format no.handphone tidak valid dan',
                'phone.min' => ' No.Handphone minimal harus 10 angka.',
                'address.required' => 'Alamat wajib diisi!',
                'email.required' => 'Email wajib diisi!',
                'email.email'=> 'Email harus alamat email yang valid!',
            ];

            $validator = Validator::make($request->all(),[
                'name_user' => 'required',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'address' => 'required',
                'email' => 'required|email',
                'dataFile.*.attachment' => 'mimes:jpg,jpeg,png,pdf',
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
            
            if ($request->dataFile == null) {
                $update = Participants::find($id);
                if ($update) {
                    if (empty($request->tb) || empty($request->bb)) {
                        $data = [
                            'user_id' => $request->user_id,
                            'name_user' => $request->name_user,
                            'recruitment_id' => $request->recruitment_id,
                            'recruitment_name' => $request->recruitment_name,
                            'phone' => $request->phone,
                            'address' => $request->address,
                            'email' => $request->email,
                            'tb' => null,
                            'bb' => null,
                            'status_berkas' => '1'
                        ];
                    } else {
                        $data = [
                            'user_id' => $request->user_id,
                            'name_user' => $request->name_user,
                            'recruitment_id' => $request->recruitment_id,
                            'recruitment_name' => $request->recruitment_name,
                            'phone' => $request->phone,
                            'address' => $request->address,
                            'email' => $request->email,
                            'tb' => $request->tb,
                            'bb' => $request->bb,
                            'status_berkas' => '1'
                        ];
                    }
                    $update->update($data);
                }

                if ($request->dataDiri == null) {
                        
                } else {
                    foreach ($request->dataDiri as $key => $value) {
                        $update3 = BerkasDataDiri::find($request->dataDiri[$key]['idValue']);
                        if ($update3) {
                            $dataBerkasDiri = [
                                'syarat_id' => $request->dataDiri[$key]['syarat_id'],
                                'recruitment_id' => $update->recruitment_id,
                                'participant_id' => $update->id,
                                'value' => $request->dataDiri[$key]['value'],
                            ];
                            $update3->update($dataBerkasDiri);
                        }
                    }
                }

                $role = auth()->user()->role_id;
                $users = User::when($role == 2, function ($query) {
                    $query->where('role_id', 1);
                })->get();

                Notification::send($users, new NotifData($request->name_user.' telah memperbaiki berkas pada rekrutmen '.$request->recruitment_name.'.', route('data.peserta',$request->recruitment_id)));
                
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data Pendaftaran Rekrutmen berhasil diubah',
                        'code' => 200
                    ]
                ],200);
                
            } else {
                $update = Participants::find($id);
                if ($update) {
                    if (empty($request->tb) || empty($request->bb)) {
                        $data = [
                            'user_id' => $request->user_id,
                            'name_user' => $request->name_user,
                            'recruitment_id' => $request->recruitment_id,
                            'recruitment_name' => $request->recruitment_name,
                            'phone' => $request->phone,
                            'address' => $request->address,
                            'email' => $request->email,
                            'tb' => null,
                            'bb' => null,
                            'status_berkas' => '1'
                        ];
                    } else {
                        $data = [
                            'user_id' => $request->user_id,
                            'name_user' => $request->name_user,
                            'recruitment_id' => $request->recruitment_id,
                            'recruitment_name' => $request->recruitment_name,
                            'phone' => $request->phone,
                            'address' => $request->address,
                            'email' => $request->email,
                            'tb' => $request->tb,
                            'bb' => $request->bb,
                            'status_berkas' => '1'
                        ];
                    }
                    $update->update($data);
                }

                foreach ($request->dataFile as $key => $value) {
                    $update2 = Files::find($request->dataFile[$key]['idFile']);
                    $temp = $update2->attachment;
                    if ($update2) {
                        $file = $request->dataFile[$key]['attachment'];
                        $path = $this->uploadPath($file->getMimeType());
                        $dataBerkas = [
                            'syarat_id' => $request->dataFile[$key]['syarat_id'],
                            'recruitment_id' => $update->recruitment_id,
                            'participant_id' => $update->id,
                            'originalName' => $file->getClientOriginalName()
                        ];
                        
                        $attachment = $file->store($path, 'public');
                        if (!empty($file)) {
                            $dataBerkas['attachment'] = $attachment;
                            $this->storage->delete($temp);
                        }

                        if (!$this->storage->exists($path)) {
                            $this->storage->makeDirectory($path);
                        }

                        $update2->update($dataBerkas);
                    }
                }
                
                if ($request->dataDiri == null) {
                        
                } else {
                    foreach ($request->dataDiri as $key => $value) {
                        $update3 = BerkasDataDiri::find($request->dataDiri[$key]['idValue']);
                        if ($update3) {
                            $dataBerkasDiri = [
                                'syarat_id' => $request->dataDiri[$key]['syarat_id'],
                                'recruitment_id' => $update->recruitment_id,
                                'participant_id' => $update->id,
                                'value' => $request->dataDiri[$key]['value'],
                            ];
                            $update3->update($dataBerkasDiri);
                        }
                    }
                }

                $role = auth()->user()->role_id;
                $users = User::when($role == 2, function ($query) {
                    $query->where('role_id', 1);
                })->get();

                Notification::send($users, new NotifData($request->name_user.' telah memperbaiki berkas pada rekrutmen '.$request->recruitment_name.'.', route('data.peserta',$request->recruitment_id)));

                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data Pendaftaran Rekrutmen berhasil diubah',
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

    // public function updateQuantity(Request $request, $id)
    // {
    //     try {
    //         $dataId = Recruitment::find($id);
    //         $query = Recruitment::where('id', '=', $id)->update([
    //             'quantity' => $request->quantity
    //         ]);
    //         return response()->json([
    //             'data' => [],
    //             'status' => [
    //                 'message' => 'Berhasil di update',
    //                 'code' => 200
    //             ]
    //         ],200);
    //     } catch (\Exception $ex) {
    //         return response()->json([
    //             'data' => [],
    //             'status' => [
    //                 'message' => $ex->getMessage(),
    //                 'code' => 500
    //             ]
    //         ],500);
    //     }
    // }

    // public function store(Request $request)
    // {
    //     try {
    //         $errMessages = [
    //             'attachment.*.required' => 'Upload berkas wajib diisi!',
    //             'attachment.*.mimes' => 'Berkas yang diperbolehkan berupa file .jpeg, .jpg, .png, .pdf',
    //             'name_user.required' => 'Nama wajib diisi!',
    //             'phone.required' => 'No.Handphone wajib diisi!',
    //             'address.required' => 'Alamat wajib diisi!',
    //             'email.required' => 'Email wajib diisi!',
    //         ];

    //         $validator = Validator::make($request->all(),[
    //             'name_user' => 'required',
    //             'phone' => 'required',
    //             'address' => 'required',
    //             'email' => 'required',
    //             'attachment.*' => 'required|mimes:jpg,jpeg,png,pdf',
    //         ],$errMessages);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'data' => $validator->errors(),
    //                 'status' => [
    //                     'message' => 'Form tidak valid',
    //                     'code' => 422,
    //                 ]
    //             ],422);
    //         }

    //         if (empty($request->attachment)) {
    //             return response()->json([
    //                 'data' => [],
    //                 'status' => [
    //                     'message' => 'Form tidak valid, Upload berkas wajib diisi!',
    //                     'code' => 422
    //                 ]
    //             ],422);
    //         } else {
    //             if (Participants::where('user_id','=',$request->user_id)->exists() && Participants::where('recruitment_id','=',$request->recruitment_id)->exists()) {
    //                 DB::rollBack();
    //                 return response()->json([
    //                     'data' => [],
    //                     'status' => [
    //                         'message' => 'Anda sudah melakukan daftar pada rekrutmen ini!',
    //                         'code' => 422
    //                     ]
    //                 ],422);
    //             }else{
    //                 if (empty($request->tb) || empty($request->bb)) {
    //                     $data = [
    //                         'user_id' => $request->user_id,
    //                         'name_user' => $request->name_user,
    //                         'recruitment_id' => $request->recruitment_id,
    //                         'recruitment_name' => $request->recruitment_name,
    //                         'phone' => $request->phone,
    //                         'address' => $request->address,
    //                         'email' => $request->email,
    //                         'tb' => null,
    //                         'bb' => null,
    //                         'status_berkas' => '1'
    //                     ];
    //                 } else {
    //                     $data = [
    //                         'user_id' => $request->user_id,
    //                         'name_user' => $request->name_user,
    //                         'recruitment_id' => $request->recruitment_id,
    //                         'recruitment_name' => $request->recruitment_name,
    //                         'phone' => $request->phone,
    //                         'address' => $request->address,
    //                         'email' => $request->email,
    //                         'tb' => $request->tb,
    //                         'bb' => $request->bb,
    //                         'status_berkas' => '1'
    //                     ];
    //                 }
    //                 $new_participant = Participants::create($data);

    //                 if ($request->has('attachment')) {
    //                     $files = $request->file('attachment');
            
    //                     if (!empty($files)) {
    //                         foreach ($files as $file) {
    //                             // $fileName = $data['name_user'].'-file-'.time().rand(1,1000).'.'.$file->extension();
    //                             // $file->move(public_path('berkas-peserta'),$fileName);
    //                             $path = $this->uploadPath($file->getMimeType());
    //                             if (!$this->storage->exists($path)) {
    //                                 $this->storage->makeDirectory($path);
    //                             }
    //                             $attachment = $file->store($path, 'public');
    //                             // Storage::put($file->getClientOriginalName(), file_get_contents($file));
    //                             Files::create([
    //                                 'syarat_id' => $request->syarat_id,
    //                                 'recruitment_id' => $new_participant->recruitment_id,
    //                                 'participant_id' => $new_participant->id,
    //                                 'attachment' => $attachment
    //                             ]);
    //                         }
    //                     }
    //                     return response()->json([
    //                         'data' => $new_participant,
    //                         'status' => [
    //                             'message' => 'Daftar rekrutmen telah berhasil',
    //                             'code' => 200
    //                         ]
    //                     ],200);
    //                 }
    //             }
    
    //         }

    //     } catch (\Exception $ex) {
    //         return response()->json([
    //             'data' => [],
    //             'status' => [
    //                 'message' => $ex->getMessage(),
    //                 'code' => 500
    //             ]
    //         ],500);
    //     }
    // }

    public function completeFile($id)
    {
        try {
            $query = Participants::find($id);
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            if ($query->status_berkas == '2') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Berkas peserta sudah disetujui.',
                        'code' => 422
                    ]
                ],422);
            } elseif ($query->status_berkas == '3') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Berkas peserta sudah ditolak.',
                        'code' => 422
                    ]
                ],422);
            }

            $query->update([
                'status_berkas' => '2'
            ]);

            $role = auth()->user()->role_id;
            $user_id = auth()->user()->id;
            $id_user = $query->user_id;
            $nama_user = $query->name_user;
            $users = User::when($role == 1 && $user_id, function ($query) use ($id_user) {
                    $query->where('role_id', 2)->where('id', $id_user);
            })->get();
            Notification::send($users, new NotifData('Berkas kamu sudah di cek oleh admin dan sudah lengkap.', route('riwayat.rekrutmen')));

            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Berkas peserta sudah komplit dan disetujui.',
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

    public function incompleteFile(Request $request, $id)
    {
        try {
            $query = Participants::find($id);
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            if ($query->status_berkas == '2') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Berkas peserta sudah disetujui.',
                        'code' => 422
                    ]
                ],422);
            } elseif ($query->status_berkas == '3') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Berkas peserta sudah ditolak.',
                        'code' => 422
                    ]
                ],422);
            }

            $query->update([
                'status_berkas' => '3',
                'alasan_berkasTidakLengkap' => $request->alasan,
            ]);

            $role = auth()->user()->role_id;
            $user_id = auth()->user()->id;
            $id_user = $query->user_id;
            $nama_user = $query->name_user;
            $users = User::when($role == 1 && $user_id, function ($query) use ($id_user) {
                    $query->where('role_id', 2)->where('id', $id_user);
            })->get();
            Notification::send($users, new NotifData('Mohon di periksa kembali, berkas kamu sudah di cek oleh admin dan ada beberapa berkas yang belum sesuai.', route('riwayat.rekrutmen')));

            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Berkas peserta belum komplit dan ditolak.',
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

    public function lolos($id)
    {
        try {
            $query = Participants::find($id);
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            if ($query->status_peserta == '2') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Peserta sudah dinyatakan lolos seleksi.',
                        'code' => 422
                    ]
                ],422);
            } elseif ($query->status_peserta == '1') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Peserta sudah dinyatakan tidak lolos seleksi',
                        'code' => 422
                    ]
                ],422);
            }

            if ($query->status_berkas == '1') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Periksa terlebih dahulu untuk berkas peserta',
                        'code' => 422
                    ]
                ],422);
            } elseif ($query->status_berkas == '3') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Berkas peserta belum lengkap',
                        'code' => 422
                    ]
                ],422);
            }

            $query->update([
                'status_peserta' => '2',
            ]);

            $role = auth()->user()->role_id;
            $user_id = auth()->user()->id;
            $id_user = $query->user_id;
            $nama_user = $query->name_user;
            $rekrutmen = $query->recruitment_name;
            $users = User::when($role == 1 && $user_id, function ($query) use ($id_user) {
                    $query->where('role_id', 2)->where('id', $id_user);
            })->get();
            Notification::send($users, new NotifData('Selamat untuk peserta atas nama '.$nama_user.' telah lolos seleksi rekrutmen '.$rekrutmen.'.', route('riwayat.rekrutmen')));

            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Peserta dinyatakan lolos seleksi.',
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

    public function tdkLolos($id)
    {
        try {
            $query = Participants::find($id);
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            if ($query->status_peserta == '2') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Peserta sudah dinyatakan lolos seleksi.',
                        'code' => 422
                    ]
                ],422);
            } elseif ($query->status_peserta == '1') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Peserta sudah dinyatakan tidak lolos seleksi',
                        'code' => 422
                    ]
                ],422);
            }

            if ($query->status_berkas == '1') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Periksa terlebih dahulu untuk berkas peserta',
                        'code' => 422
                    ]
                ],422);
            } elseif ($query->status_berkas == '3') {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Berkas peserta belum lengkap',
                        'code' => 422
                    ]
                ],422);
            }

            $query->update([
                'status_peserta' => '1',
            ]);

            $role = auth()->user()->role_id;
            $user_id = auth()->user()->id;
            $id_user = $query->user_id;
            $nama_user = $query->name_user;
            $rekrutmen = $query->recruitment_name;
            $users = User::when($role == 1 && $user_id, function ($query) use ($id_user) {
                    $query->where('role_id', 2)->where('id', $id_user);
            })->get();
            Notification::send($users, new NotifData('Mohon maaf peserta atas nama '.$nama_user.' belum lolos seleksi rekrutmen '.$rekrutmen.'.', route('riwayat.rekrutmen')));

            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Peserta dinyatakan tidak lolos seleksi.',
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

    public function download($id, Request $request)
    {
        try {
            $data = Files::where('id','=', $id)->first();
            $user = Participants::select('name_user')->where('id','=', $data->participant_id)->first();
            $fileNama = $data->attachment;
            $delimiter =  ".";
            $result = explode($delimiter,$fileNama);
            $file = Storage::disk('public')->path($data->attachment);
            $newName = $request->input('namefile').'-'.$user->name_user.'.'.$result[1];
            return response()->download($file,$newName);
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

    public function previewPdf($id)
    {
        try {
            $file = Files::find($id);
            return response()->file(Storage::path('public/'.$file->attachment));
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

    private function uploadPath($blob, $path = 'berkas-peserta')
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
