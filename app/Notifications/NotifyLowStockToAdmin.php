<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyLowStockToAdmin extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public $event) {}


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        dd('@@@@');
        $body = (new MailMessage)
            ->subject('Low stock detection')
            ->line("Warning! your warehouse " . $this->event->stock?->warehouse?->name . "with id: " . $this->event->stock?->warehouse?->id . " is in low quantity")
            ->line("last inventory item: ". $this->event->item?->name)
            ->line("Last quantity detected: " . $this->event->stock?->quantity);
        
        if($body instanceof MailMessage) {
            $this->event->stock->is_notified_low_stock = 1;
            $this->event->stock->save();
            dump($this->event->stock->is_notified_low_stock);
        }
        return $body;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
