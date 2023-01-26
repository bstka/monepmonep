<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportedTargetNotification extends Notification
{
    use Queueable;

    public $user;
    public $programId;
    public $targetId;
    public $actionType;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     *
     * ACTION TYPE MUST BE : "UPDATE" / "INSERT"
     */
    public function __construct($user, $programId, $targetId, $actionType)
    {
        $this->user = $user;
        $this->programId = $programId;
        $this->targetId = $targetId;
        $this->actionType = $actionType;

        if ($actionType === 'UPDATE') {
            $this->message = "{$user->name} dari {$user->instance->name} melakukan perubahan pada laporan";
        } else {
            $this->message = "{$user->name} dari {$user->instance->name} melaporkan laporan";
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
            'program_id' => $this->programId,
            'target_id' => $this->targetId,
            'reporter_instance' => $this->user->instance->name,
            'reporter' => $this->user->name,
            'action_type' => $this->actionType,
            'message' => $this->message,
        ];
    }
}
