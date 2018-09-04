<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use Cache;
use DB;
use File;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| banner_images Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * title VARCHAR(255)
| * filename VARCHAR(45)
| * text TEXT
| * status VARCHAR (40)
| * active_start_date datetime NOT NULL
| * active_end_date datetime NOT NULL
| * url VARCHAR(255)
| * url_android VARCHAR(255)
| * url_ios VARCHAR(255)
| * type VARCHAR(45)
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class BannerImage extends SuitModel
{
    use BlameableTrait;

    // Standard / Default Type
    const TYPE_MAIN = "main-banner";
    const TYPE_SIDE = "side-banner";
    const TYPE_TICKET = "ticket";
    const TYPE_MERCH = "merch";
    // Status
    const STATUS_ACTIVE = "active";
    const STATUS_TIMED = "timed";
    const STATUS_INACTIVE = "inactive";

    // MODEL DEFINITION
    public $table = 'banner_images';
    protected static $bufferAttributeSettings = null;

    /**
     * The Atributes that need thumbnail
     * @var array
     */
    protected $imageAttributes = ['filename' => 'bannerimages'];
    protected $imageDirectory = 'bannerimage';
    protected $imageWithUploader = true;
    protected $ImagesUploaderTraitProperties = [
        'imageDoReplace' => true,
        'imageRequests' => ['filename' => 'bannerimages']
    ];

    public $fillable = [
        'title',
        'filename',
        'text',
        'position_order',
        'type',
        'status',
        'active_start_date',
        'active_end_date',
        'url',
        'url_android',
        'url_ios'
    ];

    protected $dates = [
        'active_start_date',
        'active_end_date'
    ];

    public $rules = [
        //'filename'=>'required|mimes:jpg,jpeg,png,gif,bmp',
        'active_start_date' => 'date|required_if:status,timed',
        'active_end_date' => 'date|required_if:status,timed',
        'text' => 'nullable'
    ];

    protected $appends = ['type_attribute_label', 'status_attribute_label'];

    // Extended Attributes
    public function getTypeAttributeLabelAttribute()
    {
        return $this->getTypeOptions()[$this->type];
    }

    public function getStatusAttributeLabelAttribute()
    {
        return $this->getStatusOptions()[$this->status];
    }

    // LOCAL SCOPE
    /**
     * Filter banner with given type.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleForType($query, $type)
    {
        return $query->whereNotNull('filename')
                     ->where(function ($q) {
                        $q->where('status', '=', self::STATUS_ACTIVE)
                          ->orWhere(function ($sq) {
                            $sq->where('status', '=', self::STATUS_TIMED)
                               ->where('active_start_date', '<=', DB::raw('date_format(NOW(),"%Y-%m-%d %H:%i:%S")'))
                               ->where('active_end_date', '>=', DB::raw('date_format(NOW(),"%Y-%m-%d %H:%i:%S")'));
                          });
                     })
                     ->where('type', $type);
    }

    // SERVICES
    /**
     * Get list of specified active banners.
     * @param string $type
     * @return array
     */
    public static function getBanners($type)
    {
        $banners = BannerImage::visibleForType($type)
                              ->orderBy('position_order', 'asc')
                              ->get();
        return $banners;
    }

    /**
     * Get valid path for banner image.
     * @return string|bool
     */
    public function getValidImagePath()
    {
        if ($this->filename != null && !empty($this->filename)) {
            $targetPath = AppConfig::upload_path() . '/banners/' . $this->filename;
            if (File::exists($targetPath)) {
                return asset('uploads/banners/' . $this->filename);
            }
        }
        return false;
    }

    /**
     * Get options of type
     *
     */
    public function getTypeOptions()
    {
        $default = isset(DefaultConfig::getConfig()['banner_position']) ?
        DefaultConfig::getConfig()['banner_position'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_MAIN => "Main Banner",
            self::TYPE_SIDE => "Side Banner"
        ];
    }

    /**
     * Get options of status
     *
     */
    public function getStatusOptions()
    {
        return [self::STATUS_ACTIVE => "Active",
                self::STATUS_TIMED => "Timed",
                self::STATUS_INACTIVE => "Non Active"
        ];
    }

    public function getLabel()
    {
        return "Banner";
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
            "type" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Banner Type",
                "options" => $this->getTypeOptions()
            ],
            "position_order" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Position Order"
            ],
            "title" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Title"
            ],
            "text" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Text"
            ],
            "filename" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Image File (minimum width 1280 pixels)"
            ],
            "status" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Status",
                "options" => $this->getStatusOptions()
            ],
            "active_start_date" => [
                "type" => self::TYPE_DATE,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Active Start Date"
            ],
            "active_end_date" => [
                "type" => self::TYPE_DATE,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Active End Date"
            ],
            "url" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "URL"
            ],
            "url_android" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "URL For Android"
            ],
            "url_ios" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "URL For iOs"
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
                "visible" => false,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Updated At"
            ]
        ];
    }

    public static function boot()
    {
        parent::boot();
    }
}
