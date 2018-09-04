<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Models\User;
use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| notifications Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * user_id INT(10) UNSIGNED
| * message VARCHAR(128) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Notification extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'notifications';

    public $fillable = [
        'user_id',
        'message',
        'url',
        'is_read',
    ];

    protected $casts = ['is_read' => 'boolean'];

    public $rules = [
        'user_id' => 'required',
        'message' => 'required',
    ];

    // RELATIONSHIP
    /**
     * Get the user that owns the notification.
     * @return \App\SuitEvent\Models\User|null
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDefaultOrderColumn()
    {
        return 'created_at';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'desc';
    }

    public function getAttributeSettings()
    {
        return [
            "id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "ID"
            ],
            "message" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Message"
            ],
            "url" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Url"
            ],
            "is_read" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "is Read"
            ],
            "created_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Created At"
            ],
            "updated_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => false,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Updated At"
            ]
        ];
    }
    
    // EVENT HANDLER
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget('notification_counter_' . $model->user_id);
        });

        static::deleted(function ($model) {
            Cache::forget('notification_counter_' . $model->user_id);
        });
    }
}
