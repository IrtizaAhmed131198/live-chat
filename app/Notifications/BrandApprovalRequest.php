<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Brand;


class BrandApprovalRequest extends Notification
{
    use Queueable;

    public $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Brand Approval Request',
            'message' => "'{$this->brand->domain}' added the widget script and is waiting for approval",
            'url' => route('admin.brand'), // link to brand
        ];
    }
}
