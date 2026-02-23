<?php

function emit_pusher_notification($channel, $event, $data)
{
    try {
        $pusher = new \Pusher\Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ]
        );

        $pusher->trigger($channel, $event, $data);
        \Log::info('Pusher Works.');

        return true;
    } catch (\Exception $e) {
        // optional: log error
        \Log::error('Pusher Notification Error: ' . $e->getMessage());
        return false;
    }
}
