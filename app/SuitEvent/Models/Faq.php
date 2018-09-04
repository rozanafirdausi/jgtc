<?php

namespace App\SuitEvent\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| faqs Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * question VARCHAR(1024) NOT NULL
| * answer TEXT NOT NULL
| * position_order INTEGER(10) NOT NULL
| * icon VARCHAR(45)
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Faq extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'faqs';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'question',
        'answer',
        'position_order',
        // 'icon'
    ];

    public $files = ['icon' => 'faq_icons'];
    public $imageAttributes = ['icon' => 'faq_icons'];

    public $rules = [
        'question' => 'required',
        'answer' => 'required'
    ];

    public function getLabel()
    {
        return "F.A.Q";
    }

    public function getFormattedValue()
    {
        return "#" . $this->id;
    }

    public function getFormattedValueColumn()
    {
        return ['id'];
    }

    public function getOptions()
    {
        return self::all();
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
            "question" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Question"
            ],
            "answer" => [
                "type" => self::TYPE_RICHTEXTAREA,
                "visible" => false,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Answer"
            ],
            "position_order" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Order"
            ],
            "icon" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Icon"
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
