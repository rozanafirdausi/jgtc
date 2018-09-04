<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use File;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| emails Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * email_sender_name VARCHAR(100)
| * email_subject VARCHAR(100)
| * banner_top_image VARCHAR(45)
| * banner_top_url VARCHAR(255)
| * banner_top_title VARCHAR(100)
| * email_body text
| * banner_bottom_image VARCHAR(45)
| * banner_bottom_url VARCHAR(255)
| * banner_bottom_title VARCHAR(100)
| * recipient VARCHAR(45)
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Email extends SuitModel
{
    use BlameableTrait;
    
    const ALL = "all";
    const ADMIN = 'admin';
    const USER = 'user';
    const SELLER = 'seller';
    const RESELLER = 'reseller';
    const GUEST_SUBSCRIBER = 'guestsubscriber';

    // status const
    const CREATED = "created";
    const READYTOEXECUTE = 'readytoexecute';
    const EXECUTED = 'executed';

    // MODEL DEFINITION
    public $table = 'emails';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'email_sender_name',
        'email_subject',
        'banner_top_image',
        'banner_top_url',
        'banner_top_title',
        'email_body',
        'banner_bottom_image',
        'banner_bottom_url',
        'banner_bottom_title',
        'recipient',
        'status'
    ];

    public $rules = [
        'email_sender_name' => 'required',
        'email_subject' => 'required',
        'banner_top_url' => 'required',
        'banner_top_title' => 'required',
        'email_body' => 'required',
        'banner_bottom_url' => 'required',
        'banner_bottom_title' => 'required',
    ];

    protected $imageAttributes = [
        'banner_top_image' => 'newsletter',
        'banner_bottom_image' => 'newsletter',
    ];

    protected $files = [
        'banner_top_image' => 'newsletter',
        'banner_bottom_image' => 'newsletter',
    ];

    // SERVICES
    /**
     * Get valid path for banner top image.
     * @return string|bool
     */
    public function getValidBannerTopPath()
    {
        if ($this->banner_top_image != null && !empty($this->banner_top_image)) {
            $targetPath = AppConfig::upload_path() . '/newsletter/' . $this->banner_top_image;
            if (File::exists($targetPath)) {
                return asset('uploads/newsletter/' . $this->banner_top_image);
            }
        }
        return false;
    }

    /**
     * Get valid path for banner banner image.
     * @return string|bool
     */
    public function getValidBannerBottomPath()
    {
        if ($this->banner_bottom_image != null && !empty($this->banner_bottom_image)) {
            $targetPath = AppConfig::upload_path() . '/newsletter/' . $this->banner_bottom_image;
            if (File::exists($targetPath)) {
                return asset('uploads/newsletter/' . $this->banner_bottom_image);
            }
        }
        return false;
    }

    public function getLabel()
    {
        return 'Newsletter';
    }

    public function getFormattedValue()
    {
        return $this->email_subject;
    }

    public function getFormattedValueColumn()
    {
        return ['email_subject'];
    }

    public function getOptions()
    {
        return self::all();
    }

    public function getRecipientsOptions()
    {
        $config = DefaultConfig::getConfig();
        $options = [];
        if (isset($config['newsletter_recipients'])) {
            if (isset($config['newsletter_recipients'][self::ALL]) && $config['newsletter_recipients'][self::ALL]) {
                $options[self::ALL] = "All";
            }
            if (isset($config['newsletter_recipients'][self::ADMIN]) && $config['newsletter_recipients'][self::ADMIN]) {
                $options[self::ADMIN] = "Admin";
            }
            if (isset($config['newsletter_recipients'][self::USER]) && $config['newsletter_recipients'][self::USER]) {
                $options[self::USER] = "User";
            }
            if (isset($config['newsletter_recipients'][self::SELLER]) &&
            $config['newsletter_recipients'][self::SELLER]) {
                $options[self::SELLER] = "Seller";
            }
            if (isset($config['newsletter_recipients'][self::RESELLER]) &&
            $config['newsletter_recipients'][self::RESELLER]) {
                $options[self::RESELLER] = "Reseller";
            }
            if (isset($config['newsletter_recipients'][self::GUEST_SUBSCRIBER]) &&
            $config['newsletter_recipients'][self::GUEST_SUBSCRIBER]) {
                $options[self::GUEST_SUBSCRIBER] = "Guest Subscriber";
            }
        }
        return $options;
    }

    public function getStatusOptions()
    {
        return [
            static::CREATED => "Created",
            static::READYTOEXECUTE => 'Ready to Execute',
            static::EXECUTED => 'Executed',
        ];
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
            'email_sender_name' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Sender Name'
            ],
            'recipient' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Recipient',
                'options' => $this->getRecipientsOptions()
            ],
            'status' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Status',
                'options' => $this->getStatusOptions(),
                'filterable' => true
            ],
            'email_subject' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Subject'
            ],
            'banner_top_image' => [
                'type' => self::TYPE_FILE,
                'visible' => true,
                'formdisplay' => true,
                'required' => false,
                'relation' => null,
                'label' => 'Top Banner'
            ],
            'banner_top_url' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Top Banner URL'
            ],
            'banner_top_title' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Top Banner Title'
            ],
            'email_body' => [
                'type' => self::TYPE_RICHTEXTAREA,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Email Body'
            ],
            'banner_bottom_image' => [
                'type' => self::TYPE_FILE,
                'visible' => true,
                'formdisplay' => true,
                'required' => false,
                'relation' => null,
                'label' => 'Bottom Banner'
            ],
            'banner_bottom_url' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Bottom Banner URL'
            ],
            'banner_bottom_title' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Bottom Banner Title'
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
