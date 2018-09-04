<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\EmailSetting;
use Illuminate\Notifications\Messages\MailMessage;
use Suitcore\Repositories\SuitRepository;

class EmailSettingRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new EmailSetting;
    }
}
