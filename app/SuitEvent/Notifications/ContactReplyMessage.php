<?php

namespace App\SuitEvent\Notifications;

class ContactReplyMessage extends BaseNotification
{
    protected $view = 'emails.contacts.replymessage';
    protected $contact;

    public function __construct($contact, $link = null)
    {
        parent::__construct($link);
        $this->contact = $contact;
        $this->subject = 'Balasan Pesan ' . $contact->emailCategory->name . ' Anda';
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
