<?php

namespace App\SuitEvent\Notifications;

use App\SuitEvent\Notifications\Channels\DatabaseChannel;
use App\SuitEvent\Notifications\Contracts\EmailSettingInterface as EmailSettingContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $view;
    protected $dataView = [];
    protected $subject;
    protected $actionButtonText;
    protected $beforeActionButton;
    protected $afterActionButton;
    protected $message;
    protected $link;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($link = null)
    {
        $template = $this->getClassName();
        $emailSetting = app(EmailSettingContract::class)->getSetting($template);

        if (!$emailSetting) {
            $emailSetting = config('suitevent.emailsettings.templates.' . $template);
        }

        if ($emailSetting) {
            $this->subject = $emailSetting['subject'];
            $this->actionButtonText = $emailSetting['action_button_text'];
            $this->beforeActionButton = $emailSetting['before_action_button'];
            $this->afterActionButton = $emailSetting['after_action_button'];
        }

        $this->view = $this->view ?: $this->getDefaultMailLayout();
        $this->link = $link ?: $this->link;
    }

    protected function getClassName()
    {
        return class_basename(static::class);
    }

    public function getDefaultMailLayout()
    {
        return config('suitevent.emailsettings.layout');
    }

    public function setMessage($notifiable)
    {
        //
    }

    public function setDataView($notifiable)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $className = $this->getClassName();

        $via = [];

        if (settings($className . '_email')) {
            $via[] = 'mail';
        }

        if (settings($className . '_database')) {
            $via[] = DatabaseChannel::class;
        }

        if ($via == []) {
            $via = ['mail', DatabaseChannel::class];
        }
        
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->setDataView($notifiable);
        //$this->setMessage($notifiable);

        return (new MailMessage)
                    ->view($this->view, $this->dataView)
                    ->subject($this->subject)
                    //->line($this->message)
                    ->line($this->beforeActionButton)
                    ->action($this->actionButtonText, $this->link ?: url('/'))
                    ->line($this->afterActionButton);
    }

    public function toDatabase($notifiable)
    {
        $this->setMessage($notifiable);

        return [
            $notifiable->id,
            $this->message,
            $this->link,
        ];
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
