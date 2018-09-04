<?php

namespace App\SuitEvent\Notifications;

class ContactNewMessage extends BaseNotification
{
    protected $view = 'emails.contacts.newmessage';
    protected $contact;

    public function __construct($contact, $link = null)
    {
        parent::__construct($link);
        $this->contact = $contact;
        $this->subject = 'Ada pesan baru dari form Contact-Us';
    }

    public function setDataView($notifiable)
    {
        $this->dataView = ['contact' => $this->contact];
    }

    // only notif by email
    public function via($notifiable)
    {
        return ['mail'];
    }
}
