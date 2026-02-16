<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function chat($chatId = null)
    {
        $userBrandIds = auth()->user()->auth_brands->pluck('id')->toArray();
        $user = User::with(['get_chat' => function($query) use ($userBrandIds) {
                $query->whereHas('visitor', function($q) use ($userBrandIds) {
                    $q->whereIn('brand_id', $userBrandIds);
                });
            }])
            ->where('role', 3)
            ->get();
        $chats = Chat::with('visitor')
            ->where('status', 'open')
            ->whereHas('visitor', function($query) use ($userBrandIds) {
                $query->whereIn('brand_id', $userBrandIds);
            })
            ->latest()
            ->get();

        $messages = collect();
        $chatId = null;

        return view('admin.chat', compact('user', 'messages', 'chatId', 'chats'));
    }
    public function notification()
    {
        return view('admin.notification');
    }

    public function getNotification()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest();

        return DataTables::of($notifications)

            ->addColumn('title', function ($row) {
                return $row->data['title'] ?? '-';
            })

            ->addColumn('message', function ($row) {
                return $row->data['message'] ?? '-';
            })

            ->addColumn('status', function ($row) {
                if (is_null($row->read_at)) {
                    return '<span class="badge bg-label-danger">Unread</span>';
                }
                return '<span class="badge bg-label-success">Read</span>';
            })

            ->addColumn('date', function ($row) {
                return $row->created_at->diffForHumans();
            })

            ->addColumn('action', function ($row) {
                return '
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown">
                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item mark-read" data-id="'.$row->id.'" href="javascript:void(0);">
                                <i class="icon-base bx bx-check me-1"></i> Mark as Read
                            </a>
                            <a class="dropdown-item text-danger delete-noti" data-id="'.$row->id.'" href="javascript:void(0);">
                                <i class="icon-base bx bx-trash me-1"></i> Delete
                            </a>
                        </div>
                    </div>
                ';
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function markAsRead(Request $request)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $request->id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function show($chatId)
    {
        $chat = Chat::with('visitor')->findOrFail($chatId);
        $visitorId = Chat::where('id', $chatId)->value('visitor_id');
        $user = User::with('get_chat')->where('visitor_id', $visitorId)->first();

        return view('admin.chat.messages', compact('chatId', 'user', 'chat'));
    }

    public function messages(Request $request, $chatId)
    {
        $limit = $request->get('limit', 20);
        $offset = $request->get('offset', 0);
        $prepend = $request->get('prepend', 0); // 1 if load more

        $chat = Chat::with('visitor')->find($chatId);

        // Fetch messages
        $messages = Message::with('user')
            ->where('chat_id', $chatId)
            ->orderBy('id', 'desc')  // newest first
            ->skip($offset)
            ->take($limit)
            ->get();

        // Conditionally reverse
        if (!$prepend) {
            // Initial load: reverse so front shows oldest → newest
            $messages = $messages->reverse()->values();
        }
        // If prepend=true, keep desc → top shows newest first in that batch

        $total = Message::where('chat_id', $chatId)->count();

        return response()->json([
            'data' => $messages,
            'has_more' => ($offset + $messages->count()) < $total,
            'count' => $messages->count(),
            'url' => $chat->visitor->last_url ?? null
        ]);
    }
}
