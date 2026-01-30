<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewVisitorNotification extends Notification
{
    use Queueable;

    public $website;
    public $visitor;

    public function __construct($website, $visitor)
    {
        $this->website = $website;
        $this->visitor = $visitor;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Visitor',
            'message' => 'New visitor on ' . $this->website->domain,
            'website_id' => $this->website->id,
            'session_id' => $this->visitor->session_id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'website' => [
                'id' => $this->website->id,
                'domain' => $this->website->domain,
            ],
            'visitor' => [
                'session_id' => $this->visitor->session_id,
            ],
        ]);
    }
}
