<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

class Attraction extends SuitModel
{
    use BlameableTrait;

    // MODEL DEFINITION
    public $table = 'attractions';
    protected static $bufferAttributeSettings = null;

    // type options
    const TYPE_TENANT = 'tenant';

    // is_visible options
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 0;

    public $fillable = [
        'type',
        'name',
        'description',
        'image',
        'latitude',
        'longitude',
        'pin_point_code',
        'position_order',
        'is_visible'
    ];

    public $files = ['image' => 'attraction_images'];
    public $imageAttributes = ['image' => 'attraction_images'];

    public $rules = [
        'type' => 'null|string|max:50',
        'name' => 'required|string|max:100',
        'description' => 'nullable',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'position_order' => 'integer'
    ];

    public function getLabel()
    {
        return "Location";
    }

    public function getFormattedValue()
    {
        return $this->name;
    }

    public function getFormattedValueColumn()
    {
        return ['name'];
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
        $default = isset(DefaultConfig::getConfig()['attraction_type']) ? DefaultConfig::
        getConfig()['attraction_type'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_TENANT => "Tenant"
        ];
    }

    public function getStatusOptions()
    {
        return [
            self::STATUS_VISIBLE => "Visible",
            self::STATUS_HIDDEN => "Hidden"
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
                "visible" => false,
                "formdisplay" => false,
                "required" => false,
                "relation" => null,
                "label" => "Type",
                "options" => $this->getTypeOptions()
            ],
            "name" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Name"
            ],
            "description" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Description"
            ],
            "image" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Image"
            ],
            "latitude" => [
                "type" => self::TYPE_FLOAT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Latitude"
            ],
            "longitude" => [
                "type" => self::TYPE_FLOAT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Longitude"
            ],
            "pin_point_code" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Pin Point Code"
            ],
            "position_order" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Position Order"
            ],
            "is_visible" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Status",
                "options" => $this->getStatusOptions(),
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
