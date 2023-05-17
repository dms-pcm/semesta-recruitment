<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $errMessages = [
                'full_name.required' => 'Nama lengkap wajib diisi!',
                'email.required' => 'Email wajib diisi!',
                'email.unique' => 'Email sudah digunakan!',
                'email.email' => 'Email yang anda masukan tidak valid!',
                'username.required' => 'Username wajib diisi!',
                'password.required' => 'Password wajib diisi!',
                'password.min' => 'Password minimal 8 karakter!',
            ];

            $validator = Validator::make($request->all(),[
                'full_name' => 'required',
                'email' => 'required|unique:users,email|email',
                'username' => 'required',
                'password' => 'required|min:8'
            ],$errMessages);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => [
                        'message' => 'Silahkan isi form dengan benar terlebih dahulu',
                        'code' => 422,
                    ]
                ],422);
            }

            $register = User::create([
                'role_id' => '2',
                'full_name' => $request->full_name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'email_verification_token' => Str::random(60),
            ]);

            if ($register) {
                //  if (!$register->hasVerifiedEmail()) {
                    $register->sendEmailVerificationNotification();
                    return response()->json([
                        'data' => [],
                        'status' => [
                            'message' => 'Selamat akun anda berhasil dibuat. Silahkan cek email anda untuk verifikasi email',
                            'code' => 200
                        ]
                    ],200);
                // }
                // else {
                //     return response()->json([
                //         'data' => [],
                //         'status' => [
                //             'message' => 'Email anda sudah terverifikasi.',
                //             'code' => 400
                //         ]
                //     ],400);
                // }
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

    public function login()
    {
        try {
            $rules = [
                'username' => 'required',
                'password' => 'required|min:8'
            ];

            $messages = [
                'required' => ':attribute wajib diisi',
                'password.min' => ':attribute minimal 8 karakter'
            ];

            $attributes = [
                'username' => 'Username',
                'password' => 'Password'
            ];

            $validator = Validator::make(request(['username','password']), $rules, $messages, $attributes);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => [
                        'message' => 'Silahkan isi form dengan benar terlebih dahulu',
                        'code' => 422,
                    ]
                ],422);
            } else {
                $credentials = request(['username','password']);
                $token = auth('api')->attempt($credentials);

                if (!empty($token)) {
                    if (auth('api')->user() && auth('api')->user()->hasVerifiedEmail()) {
                        $userAuth = User::with('role')->find(auth('api')->user()->id);
                        return response()->json([
                            'data' => [
                                'user' => $userAuth,
                                'token' => $this->respondWithToken($token),
                            ],
                            'status' => [
                                'message' => 'Anda berhasil login',
                                'code' => 200,
                            ]
                        ],200);
                    } else {
                        return response()->json([
                            'data' => [],
                            'status' => [
                                'message' => 'Anda belum melakukan verifikasi email. Silahkan verifikasi email terlebih dahulu!',
                                'code' => 401,
                            ]
                        ],401);
                    }
                } elseif (!Auth::attempt($credentials)) {
                    return response()->json([
                        'data' => [],
                        'status' => [
                            'message' => 'Username atau Password anda salah',
                            'code' => 401,
                        ]
                    ],401);
                }
            }

        } catch (\Exception $ex) {
            return response()->json()([
                'data' => [],
                'status' => [
                    'messages' => $ex->getMessage(),
                    'code' => 500,
                ]
            ],500);
        }
    }

    public function logout()
    {
        try {
            $this->guard()->logout();
            return response()->json([
                'data' => [],
                'status' => [
                    'message' => 'Anda berhasil logout',
                    'code' => 200,
                ]
            ],200);
        } catch (\Exception $ex) {
            return response()->json()([
                'data' => [],
                'status' => [
                    'messages' => $ex->getMessage(),
                    'code' => 500,
                ]
            ],500);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 600000
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function me()
    {
        try{
            return response()->json($this->guard()->user());
        }
        catch(\Exception $e){
            return response()->json([
                'data' => [],
                'status' => [
                    'message' => $e->getMessage(),
                    'code' => 500
                ]
            ],500);
        }
    }
}
