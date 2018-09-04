<?php

namespace App\SuitEvent\Notifications;

use App\SuitEvent\Models\Participant;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class ParticipantNew extends BaseNotification
{
    use BlameableTrait;

    protected $view = 'emails.participants.new';
    protected $participant;

    public function __construct($participant, $link = null)
    {
        parent::__construct($link);
        $this->participant = $participant;
    }

    public function setDataView($notifiable)
    {
        $this->dataView = [
            'participant' => $this->participant
        ];
    }

    public function toMail($notifiable)
    {
        $participant = $this->participant;

        return parent::toMail($notifiable);
    }
}
