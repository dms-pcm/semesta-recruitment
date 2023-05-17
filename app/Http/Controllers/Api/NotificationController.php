<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('id');
    }

    public function index()
    {
        $notifications = Auth::user()->Notifications;
        $countNotifications = Auth::user()->unreadNotifications()->count();

        return response()->json([
            'data' => [
                'notifications' => $notifications,
                'count_notifikasi' => $countNotifications,
            ],
            'status' => [
                'message' => 'Data notifikasi berhasil ditampilkan.',
                'code' => 200
            ]
        ],200);
    }

    public function markAsRead(Request $request)
    {
        $notification = Auth::user()->unreadNotifications->find($request->id);

        if (!empty($notification)) {
            $notification->markAsRead();
        }

        return response()->json([
            'data' => [],
            'status' => [
                'message' => 'READ',
                'code' => 200
            ]
        ],200);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json([
            'data' => [],
            'status' => [
                'message' => 'MARK_ALL_AS_SREAD',
                'code' => 200
            ]
        ],200);
    }

    public function store(Request $request)
    {
        Auth::user()->unreadNotifications->when($request->id, function ($query, $id) {
            return $query->where('id', $id);
        })->markAsRead();

        return response()->json([
            'data' => [],
            'status' => [
                'message' => 'Mark as read.',
                'code' => 200
            ]
        ],200);
    }
}
