<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use App\SuitEvent\Models\User;
use App\SuitEvent\Repositories\PerformerReviewRepository;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| performer_reviews Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * parent_id INT(10)
| * performer_id INT(10) NOT NULL
| * user_id INT(10)
| * rate INT(11)
| * note TEXT
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class PerformerReview extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'performer_reviews';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'parent_id',
        'performer_id',
        'user_id',
        'rate',
        'note'
    ];

    public $rules = [
        'parent_id' => 'nullable|integer|exists:performer_reviews,id',
        'performer_id' => 'required|integer|exists:performers,id',
        'user_id' => 'nullable|integer|exists:users,id',
        'rate' => 'required|integer|min:1|max:5',
        'note' => 'nullable|string'
    ];

    public function parent()
    {
        return $this->belongsTo(PerformerReview::class, 'parent_id');
    }

    public function performer()
    {
        return $this->belongsTo(Performer::class, 'performer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getLabel()
    {
        return "Performer Review";
    }

    public function getFormattedValue()
    {
        return '#' . $this->id;
    }

    public function getFormattedValueColumn()
    {
        return ['id'];
    }

    public function getDefaultOrderColumn()
    {
        return 'id';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
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
            "parent_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => false,
                "required" => false,
                "relation" => 'parent',
                "label" => "Parent",
                "options" => []
            ],
            "performer_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'performer',
                "label" => "Performer",
                "readonly" => true,
                "options" => []
            ],
            "user_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => 'user',
                "label" => "User",
                "options" => []
            ],
            "rate" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Rate"
            ],
            "note" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Note"
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

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $performer = Performer::find($model->performer_id);
            if ($performer) {
                $performerReviews = app(PerformerReviewRepository::class)->getByParameter([
                    'performer_id' => $performer->id,
                    'perPage' => -1
                ]);
                if ($performerReviews->count() != 0) {
                    $performer->average_rate = $performerReviews->sum('rate') / $performerReviews->count();
                } else {
                    $performer->average_rate = 0;
                }
                $performer->save();
            }
        });

        static::deleted(function ($model) {
            $performer = Performer::find($model->performer_id);
            if ($performer) {
                $performerReviews = app(PerformerReviewRepository::class)->getByParameter([
                    'performer_id' => $performer->id,
                    'perPage' => -1
                ]);
                if ($performerReviews->count() != 0) {
                    $performer->average_rate = $performerReviews->sum('rate') / $performerReviews->count();
                } else {
                    $performer->average_rate = 0;
                }
                $performer->save();
            }
        });
    }
}
