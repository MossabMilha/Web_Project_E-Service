<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LowWorkloadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $currentWorkload;
    protected $minimumRequired;

    public function __construct($currentWorkload, $minimumRequired)
    {
        $this->currentWorkload = $currentWorkload;
        $this->minimumRequired = $minimumRequired;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Low Teaching Workload Warning')
            ->greeting("Hello Professor {$notifiable->name},")
            ->line("Your current teaching workload is **{$this->currentWorkload} hours**.")
            ->line("The minimum required workload is **{$this->minimumRequired} hours**.")
            ->action('Review Assignments', url('/dashboard'))
            ->line('Thank you for your work.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Low Teaching Workload Warning',
            'current_workload' => $this->currentWorkload,
            'minimum_required' => $this->minimumRequired,
            'message' => "Your workload is below the minimum.",
        ];
    }
}
