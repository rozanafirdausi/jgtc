<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use App\SuitEvent\Models\City;
use App\SuitEvent\Models\User;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;
use Suitcore\Notification\Notifiable;

/*
|--------------------------------------------------------------------------
| participants Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * type VARCHAR(64) NOT NULL
| * name VARCHAR(100) NOT NULL
| * email VARCHAR(64) UNIQUE
| * phone VARCHAR(64)
| * avatar VARCHAR(255)
| * user_id INT(10) UNSIGNED
| * city_id INT(10) UNSIGNED
| * position_order INT(11)
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Participant extends SuitModel
{
    use BlameableTrait;
    use Notifiable;

    // MODEL DEFINITION
    public $table = 'participants';
    protected static $bufferAttributeSettings = null;

    // type options
    const TYPE_VOLUNTEER = 'volunteer';
    const TYPE_ATTENDEE = 'attendee';
    const TYPE_COMMITTEE = 'committee';

    public $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'avatar',
        'user_id',
        'city_id',
        'position_order'
    ];

    public $files = ['avatar' => 'participant_avatars'];
    public $imageAttributes = ['avatar' => 'participant_avatars'];

    public $rules = [
        'type' => 'required|string|max:64',
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:64',
        'phone' => 'nullable|string|max:64',
        'avatar' => 'nullable|string|max:255',
        'user_id' => 'nullable|exists:users,id',
        'city_id' => 'nullable|exists:kabkotas,id',
        'position_order' => 'required|integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function participantAnswer()
    {
        return $this->hasMany(ParticipantAnswer::class, 'participant_id');
    }

    public function getLabel()
    {
        return "Participant";
    }

    public function getFormattedValue()
    {
        return $this->name . " (" . $this->type . ")";
    }

    public function getFormattedValueColumn()
    {
        return ['name', 'type'];
    }

    public function getDefaultOrderColumn()
    {
        return 'created_at';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'desc';
    }

    public function getTypeOptions()
    {
        $default = isset(DefaultConfig::getConfig()['participant_type']) ?
        DefaultConfig::getConfig()['participant_type'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_VOLUNTEER => "Volunteer",
            self::TYPE_ATTENDEE => "Attendee",
            self::TYPE_COMMITTEE => "Committee"
        ];
    }

    public function getAttributeSettings()
    {
        return [
            "id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "ID"
            ],
            "type" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Type",
                "options" => $this->getTypeOptions(),
                "filterable" => true
            ],
            "name" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Name"
            ],
            "email" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Email"
            ],
            "phone" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Phone"
            ],
            "avatar" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Avatar"
            ],
            "position_order" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Position Order"
            ],
            "user_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => 'user',
                "label" => "Related User",
                "options" => []
            ],
            "city_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => 'city',
                "label" => "City",
                "options" => [],
                "filterable" => true
            ],
            "created_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => false,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Created At"
            ],
            "updated_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Updated At"
            ]
        ];
    }
}
