<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Notifications\Contracts\EmailSettingInterface as EmailSettingContract;
use App\SuitEvent\Notifications\EmailSetting\EmailSettingTrait;
use Illuminate\Support\Str;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| email_settings Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * name VARCHAR(255)
| * template VARCHAR(255)
| * subject VARCHAR(255)
| * action_button_text VARCHAR(255)
| * before_action_button VARCHAR(255)
| * after_action_button VARCHAR(255)
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class EmailSetting extends SuitModel implements EmailSettingContract
{
    use BlameableTrait;
    use EmailSettingTrait;

    // MODEL DEFINITION
    public $table = 'email_settings';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'name',
        'template',
        'subject',
        'action_button_text',
        'before_action_button',
        'after_action_button',
    ];

    // SERVICES
    public function rules()
    {
        $this->template = $this->template ?: Str::studly($this->name);

        return [
            'name' => 'required|max:255',
            'template' => 'required|max:255',
        ];
    }

    public function getSetting($name)
    {
        $instance = new static;
        $setting = $instance->where('template', $name)->first();
        if ($setting == null) {
            return null;
        }
        return $setting->toArray();
    }

    public function getLabel()
    {
        return 'Email Setting';
    }

    public function getFormattedValue()
    {
        return $this->template;
    }

    public function getFormattedValueColumn()
    {
        return ['template'];
    }

    public function getOptions()
    {
        return self::all();
    }

    public function getTemplateOptions()
    {
        $getAppliedTemplates = static::where('template', '<>', $this->template)->pluck('template')->toArray();
        $templates = collect(array_keys(config('suitevent.emailsettings.templates')))
        ->filter(function ($template, $key) use ($getAppliedTemplates) {
            return !in_array($template, $getAppliedTemplates);
        })->toArray();
        $templateNames = array_map(function ($item) {
            return Str::title(Str::snake($item, ' '));
        }, $templates);

        return array_combine($templates, $templateNames);
    }

    public function getDefaultOrderColumn()
    {
        return 'name';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
    }

    public function getAttributeSettings()
    {
        // default attribute settings of generic model, override for furher use
        return [
            'id' => [
                'type' => self::TYPE_NUMERIC,
                'visible' => true,
                'formdisplay' => false,
                'required' => true,
                'relation' => null,
                'label' => 'ID'
            ],
            'name' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Name'
            ],
            'template' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'readonly' => false,
                'relation' => null,
                'label' => 'Template',
                'options' => $this->getTemplateOptions()
            ],
            'subject' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => false,
                'relation' => null,
                'label' => 'Subject'
            ],
            'action_button_text' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => false,
                'relation' => null,
                'label' => 'Action Text'
            ],
            'before_action_button' => [
                'type' => self::TYPE_RICHTEXTAREA,
                'visible' => true,
                'formdisplay' => true,
                'required' => false,
                'relation' => null,
                'label' => 'Before Action Text'
            ],
            'after_action_button' => [
                'type' => self::TYPE_RICHTEXTAREA,
                'visible' => true,
                'formdisplay' => true,
                'required' => false,
                'relation' => null,
                'label' => 'After Action Text'
            ],
            'created_at' => [
                'type' => self::TYPE_DATETIME,
                'visible' => true,
                'formdisplay' => false,
                'required' => false,
                'relation' => null,
                'label' => 'Created At'
            ],
            'updated_at' => [
                'type' => self::TYPE_DATETIME,
                'visible' => true,
                'formdisplay' => false,
                'required' => false,
                'relation' => null,
                'label' => 'Updated At'
            ]
        ];
    }
}
