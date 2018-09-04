<?php

namespace App\SuitEvent\Models;

use Illuminate\Database\Eloquent\Model;
use Suitcore\Thumbnailer\Contracts\Model\ImageThumbnailerInterface;
use Suitcore\Thumbnailer\Model\ThumbnailerTrait;
use Suitcore\Uploader\Contracts\ModelUploaderInterface;
use Suitcore\Uploader\ModelUploaderTrait;
use Validator;

class GenericModel extends Model implements ImageThumbnailerInterface, ModelUploaderInterface
{
    use ModelUploaderTrait;
    use ThumbnailerTrait;

    protected $event;

    protected $defWidth = 480;// landscape
    
    protected $defHeight = 360; // portrait
    
    protected $thumbnailStyle = [
        'small_square' => '128x128', 'medium_square' => '256x256', 'large_square' => '512x512',
        'small_cover' => '240x_', 'medium_cover' => '480x_', 'large_cover' => '1024x_'
    ];

    protected $imageAttributes = [];

    protected $defThumbnailName = '_thumbnail';

    protected $baseFolder = 'public/uploads';
    
    public $fillable = [];

    public $rules = [];

    public $errors;

    public function getError()
    {
        return $this->errors;
    }

    public function isValid($scenario = 'create', $customRules = null)
    {
        $rules = $this->rules;

        if ($customRules != null) {
            foreach ($customRules as $k => $v) {
                $rules[$k] = $v;
            }
        }

        if ($scenario == 'update') {
            $rules = [];
            foreach ($this->rules as $key => $value) {
                $split = explode('|', $value);
                $merged = [];
                foreach ($split as $item) {
                    if (strpos($item, 'unique') === false) {
                        $merged[] = $item;
                    }
                }
                $rules[$key] = implode('|', $merged);
            }
        }
        $v = Validator::make($this->attributes, $rules);
        if ($v->passes()) {
            return true;
        }
        $this->errors = $v->messages();
        return false;
    }

    public function freshInstance()
    {
        $fillable = $this->getFillable();
        $attributes = array_combine($fillable, array_fill(0, count($fillable), null));
        return new static($attributes);
    }
}
