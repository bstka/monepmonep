<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ValidationReportTargetNotification extends Notification
{
    use Queueable;

    public $user;
    public $target;
    public $actionType;
    public $message;

    /**
     * Create a new notification instance.
     *
     *  ACTION TYPE MUST BE: "VALIDATE" / "UNVALIDATE"
     *
     * @return void
     */
    public function __construct($user, $target, $actionType)
    {
        $this->user = $user;
        $this->target = $target;
        $this->actionType = $actionType;

        if ($actionType === 'VALIDATE') {
            $this->message = "{$user->name} dari {$user->instance->name} telah melakukan verifikasi pada laporan anda";
        } else {
            $this->message = "{$user->name} dari {$user->instance->name} telah membatalkan verifikasi pada laporan anda";
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'validator' => $this->user->name,
            'validator_instance' => $this->user->instance->name,
            'message' => $this->message,
            'target_id' => $this->target->id,
        ];
    }
}
