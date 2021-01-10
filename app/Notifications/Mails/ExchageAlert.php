<?php

namespace App\Notifications\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExchageAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $baseCurrency;
    public $targetCurrency;
    public $condition;
    public $thresholdNumber;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($baseCurrency, $targetCurrency, $condition, $thresholdNumber)
    {
        $this->baseCurrency = $baseCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->condition = $condition;
        $this->thresholdNumber = $thresholdNumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $sub = "Exchange Alert";

        $message = "<p>This is to inform you that your base currency <span class='bold'>$this->baseCurrency</span> is now 
        <span class='bold'>$this->condition</span> target currency <span class='bold'>$this->targetCurrency</span> by 
        <span class='bold'>$this->thresholdNumber</span> amount.</p>";
        $message .= "<p></p>";
        $endMessage = "<span>If you didn't choose this notification, you can login and unsubscribe.</span>";

        //Store the notiifcation in database
        (new \App\Services\CustomNotification())->createNotification(['user_id' => $notifiable->id, 'title' => $sub, 'message' => $message]);

        return (new MailMessage())
        ->markdown(
            'emails.exchange',
            [
            'button_text' => 'LOG IN HERE',
            'url' =>  config('app.url') . '/login',
            'message' =>  $message,
            'end_message' => $endMessage,
            'user' => $notifiable,
            ]
        )
        ->subject($sub);
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
            //
        ];
    }
}
