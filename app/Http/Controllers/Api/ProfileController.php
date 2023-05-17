<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ProfileController extends Controller
{
    protected $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('public');
    }

    public function sosmed()
    {
        try {
            $query = User::select('facebook','instagram','twitter')->where('id','=',1)->get();
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
                        'message' => 'Data profile user tidak ada.',
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
            ]);
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

    public function profile()
    {
        try {
            $query = User::where('id',Auth::id())->get();
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
                        'message' => 'Data profile user tidak ada.',
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
            ]);
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
        $attachment = null;
        try {
            $errMessages = [
                'attachment.mimetypes' => 'Gambar yang diperbolehkan berupa file .jpeg, .jpg, .png',
                'full_name.required' => 'Nama lengkap wajib diisi!',
                'company.required' => 'Perusahaan wajib diisi!',
                'country.required' => 'Negara wajib diisi!',
                'address.required' => 'Alamat lengkap wajib diisi!',
                'phone.required' => 'No.Handphone wajib diisi!',
                'phone.regex' => ' Format no.handphone tidak valid dan',
                'phone.min' => ' No.Handphone minimal harus 10 angka.',
                'email.required' => 'Email wajib diisi!',
                'email.email' => 'Email yang anda masukan tidak valid!',
                // 'twitter.required' => 'Kuota Peserta wajib diisi!',
                // 'facebook.required' => 'Kuota Peserta wajib diisi!',
                // 'instagram.required' => 'Kuota Peserta wajib diisi!',
            ];

            $validator = Validator::make($request->all(),[
                'attachment' => 'mimetypes:image/jpeg,image/jpg,image/png',
                'full_name' => 'required',
                'company' => 'required',
                'country' => 'required',
                'address' => 'required',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'email' => 'required|email',
                // 'twitter' => 'required',
                // 'facebook' => 'required',
                // 'instagram' => 'required',
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

            $update = User::find($id);
            $temp = $update->attachment;
            if ($update) {
                $data = [
                    'full_name' => $request->full_name,
                    'company' => $request->company,
                    'country' => $request->country,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'twitter' => $request->twitter,
                    'facebook' => $request->facebook,
                    'instagram' => $request->instagram
                ];

                if (!empty($request->attachment)) {
                    $data['attachment'] = $attachment;
                    $this->storage->delete($temp);
                }
                $update->update($data);

                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Profile berhasil di ubah.',
                        'code' => 200
                    ]
                ]);
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

    public function editProfile(Request $request, $id)
    {
        $attachment = null;
        try {
            $errMessages = [
                'attachment.mimetypes' => 'Gambar yang diperbolehkan berupa file .jpeg, .jpg, .png',
                'full_name.required' => 'Nama lengkap wajib diisi!',
                'country.required' => 'Negara wajib diisi!',
                'address.required' => 'Alamat lengkap wajib diisi!',
                'phone.required' => 'No.Handphone wajib diisi!',
                'phone.regex' => ' Format no.handphone tidak valid dan',
                'phone.min' => ' No.Handphone minimal harus 10 angka.',
                'email.required' => 'Email wajib diisi!',
                'email.email' => 'Email yang anda masukan tidak valid!',
                // 'twitter.required' => 'Kuota Peserta wajib diisi!',
                // 'facebook.required' => 'Kuota Peserta wajib diisi!',
                // 'instagram.required' => 'Kuota Peserta wajib diisi!',
            ];

            $validator = Validator::make($request->all(),[
                'attachment' => 'mimetypes:image/jpeg,image/jpg,image/png',
                'full_name' => 'required',
                'country' => 'required',
                'address' => 'required',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'email' => 'required|email',
                // 'twitter' => 'required',
                // 'facebook' => 'required',
                // 'instagram' => 'required',
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

            $update = User::find($id);
            $temp = $update->attachment;
            if ($update) {
                $data = [
                    'full_name' => $request->full_name,
                    'country' => $request->country,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'twitter' => $request->twitter,
                    'facebook' => $request->facebook,
                    'instagram' => $request->instagram
                ];

                if (!empty($request->attachment)) {
                    $data['attachment'] = $attachment;
                    $this->storage->delete($temp);
                }
                $update->update($data);

                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Profile berhasil di ubah.',
                        'code' => 200
                    ]
                ]);
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

    public function deleteFoto($id)
    {
        try {
            $query = User::find($id);
            if (!$query) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Data tidak ditemukan',
                        'code' => 404
                    ]
                ],404);
            }

            $temp = $query->attachment;
            $query->update([
                'attachment' => null
            ]);
            $this->storage->delete($temp);
            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Foto profile berhasil dihapus',
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

    public function changePassword(Request $request)
    {
        try {
            $errMessages = [
                'current_password.required' => 'Password lama wajib diisi!',
                'new_password.required' => 'Password baru wajib diisi!',
                'new_password.min' => 'Password baru minimal harus 8 karakter',
                'new_confirm_password.same' => 'Konfirmasi password tidak cocok.',
            ];

            $validator = Validator::make($request->all(),[
                'current_password' => 'required',
                'new_password' => 'required|min:8',
                'new_confirm_password' => 'same:new_password'
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

            if (!Hash::check($request->get('current_password'), Auth::user()->password)) {
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Password Saat Ini Tidak Valid',
                        'code' => 422,
                    ]
                ],422);
            } else if(strcmp($request->get('current_password'), $request->new_password) == 0){
                return response()->json([
                    'data' => [],
                    'status' => [
                        'message' => 'Password Baru tidak boleh sama dengan password Anda saat ini.',
                        'code' => 422,
                    ]
                ],422);
            }

            $user =  User::find(Auth::user()->id);
            $user->password =  Hash::make($request->new_password);
            $user->update();

            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Password berhasil diubah',
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

    public function uploadCV(Request $request)
    {
        $cv = null;
        try {
            $errMessages = [
                'cv.required' => 'CV wajib diisi!',
                'cv.mimes' => 'Format yang diperbolehkan berupa file .pdf',
            ];

            $validator = Validator::make($request->all(),[
                'cv' => 'required|mimes:pdf',
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

            if (!empty($request->cv)) {
                if (!$request->cv->isValid()) {
                    return response()->json([
                        'data' => [],
                        'status' => [
                            'message' => 'Tidak dapat mengunggah gambar.',
                            'code' => 422,
                        ]
                    ],422);
                }
                
                $path = $this->uploadPath($request->cv->getMimeType());

                if (!$this->storage->exists($path)) {
                    $this->storage->makeDirectory($path);
                }

                $cv = $request->cv->store($path, 'public');
            }

            $updateCV = User::find(Auth::id());
            if ($updateCV) {
                $temp = $updateCV->cv;
                $data = [
                    'originalName' => $request->cv->getClientOriginalName(),
                ];

                if (!empty($request->cv)) {
                    $data['cv'] = $cv;
                    $this->storage->delete($temp);
                }
                $updateCV->update($data);
            }

            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'CV berhasil di upload.',
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

    public function getCV($id)
    {
        try {
            $file = User::find($id);
            return response()->file(Storage::path('public/'.$file->cv));
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

    private function uploadPath($blob, $path = 'profile')
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
