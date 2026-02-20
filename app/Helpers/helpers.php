<?php

function emit_pusher_notification($channel, $event, $data)
{
    try {
        $pusher = new \Pusher\Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        $pusher->trigger($channel, $event, $data);
        // \Log::info('Pusher Works.');

        return true;
    } catch (\Exception $e) {
        // optional: log error
        \Log::error('Pusher Notification Error: ' . $e->getMessage());
        return false;
    }
}
