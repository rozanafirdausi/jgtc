<?php

namespace App\SuitEvent\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class MessageNewInbox extends BaseNotification
{
    protected $view = 'emails.messages.newinbox';
    protected $messageObj;

    public function __construct($messageObj, $link = null)
    {
        parent::__construct($link);
        $this->messageObj = $messageObj;
    }

    public function toMail($notifiable)
    {
        $this->beforeActionButton = '<i style="text-align: center;">' . $this->messageObj->message . '</i>';
        return parent::toMail($notifiable);
    }

    public function setMessage($notifiable)
    {
        $this->message = trans('notification.messages.messages.newinbox', ['sender' =>
        $this->messageObj->fromUser->name]);
    }
}
