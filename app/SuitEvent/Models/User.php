<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;
use Suitcore\Notification\Notifiable;
use Validator;

/*
|--------------------------------------------------------------------------
| users Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * username VARCHAR(45) NOT NULL
| * password VARCHAR(80) NOT NULL
| * picture VARCHAR(45)
| * name VARCHAR(255) NOT NULL
| * birthdate DATE NOT NULL
| * gender VARCHAR(8) NULL
| * identity_number VARCHAR(64) NULL
| * tax_id_number VARCHAR(64) NULL
| * address_id_default INT NULL
| * billing_address_id INT NULL
| * address_street VARCHAR(255)
| * address_city VARCHAR(255)
| * address_country VARCHAR(45)
| * address_zipcode VARCHAR(10)
| * role VARCHAR(50) NOT NULL
| * newsletter TINYINT(1)
| * message TINYINT(1)
| * email VARCHAR(255) NOT NULL
| * phone_number VARCHAR(15)
| * registration_date DATETIME NOT NULL
| * last_visit DATETIME NOT NULL
| * is_premium TINYINT(1)
| * premium_expired_date DATETIME
| * status VARCHAR(45)
| * remember_token VARCHAR(100)
| * escrow_amount DOUBLE(15,2)
| * fb_id VARCHAR(255)
| * shop_name VARCHAR(45)
| * shop_description TEXT
| * referral_code VARCHAR(64)
| * optional_user_code VARCHAR(128)
| * supplier_id INT(10)
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class User extends SuitModel implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable;
    use BlameableTrait;
    use CanResetPassword;
    use Notifiable;

    // MODEL DEFINITION
    // User Gender
    const MALE = 'male';
    const FEMALE = 'female';
    // User Role
    const ADMIN = 'admin';
    const USER = 'user';

    // User Status
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_UNREGISTERED = 'unregistered';

    public $table = 'users';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'username',
        'password',
        'picture',
        'name',
        'birthdate',
        'gender',
        'identity_number',
        'tax_id_number',
        'address_id_default',
        'billing_address_id',
        'address_street',
        'address_city',
        'address_country',
        'address_zipcode',
        'newsletter',
        'phone_number',
        'email',
        'last_visit',
        'role',
        'status',
        'is_premium',
        'premium_expired_date',
        'registration_date',
        'escrow_amount',
        'location_id',
        'fb_id',
        'shop_name',
        'shop_description',
        'referral_code',
        'optional_user_code',
        'user_referral_id',
        'supplier_id'
    ];

    public $rules = [
        //'username' => 'required|unique:users,username|alpha_num',
        'password' => 'required',
        'name' => 'required',
        'role' => 'required',
        //'birthdate'=> 'required|date|before:17 years ago',
        'email' => 'required|email|unique:users,email'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $imageAttributes = [
        'picture' => 'profile_pictures'
    ];

    protected $files = [
        'picture' => 'profile_pictures'
    ];

    protected $dates = ['birthdate', 'registration_date'];

    // rules
    public function rules()
    {
        return [
            //'username' => 'required|unique:users,username'.($this->id ? ','.$this->id : '').'|alpha_num',
            //'password' => 'required|confirmed',
            'name' => 'required',
            'role' => 'required',
            //'birthdate'=> 'required|date',
            //'email' => 'required|email|unique:users,email'.($this->id ? ','.$this->id : '')
        ];
    }

    // RELATIONSHIP
    /**
     * Get the oauth for the user.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function oauths()
    {
        return $this->hasMany(OauthUser::class);
    }

    /**
     * Get addresses of a user.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'user_id');
    }

    /**
     * Get messages send by the user.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get notifications of the user.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    /**
     * Get the referral user (upline) of the user.
     * @return \App\SuitEvent\Models\User|null
     */
    public function referralUser()
    {
        return $this->belongsTo(User::class, 'user_referral_id');
    }

    /**
     * Get the default address of the user.
     * @return \App\SuitEvent\Models\Address|null
     */
    public function defaultAddress()
    {
        return $this->belongsTo(Address::class, 'address_id_default');
    }

    /**
     * Get the default address of the user.
     * @return \App\SuitEvent\Models\Address|null
     */
    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    // SERVICES
    /**
     * Form Validation for create user.
     * @param  array $data User data from create user form.
     * @return  bool
     */
    public function userDataIsValid($data)
    {
        $validator = Validator::make($data, $this->rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->messages();
        return false;
    }

    /**
     * Get the available couriers for the user.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function availableCouriers()
    {
        return $this->hasMany(AvailableCourier::class, 'user_id');
    }

    public function isGuest()
    {
        // return !($this->role == 'buyer');
        return $this->status == static::STATUS_UNREGISTERED;
    }

    public function isSellable()
    {
        // return !($this->role == 'buyer');
        return ($this->isActive() && $this->role != 'cs officer');
    }

    public function generateReffCode()
    {
        do {
            $code = generateRandomString(8);
        } while ($this->referral_code == $code);

        $this->update(['referral_code' => $code]);

        return $code;
    }

    public function getFixedReferralCodeAttribute()
    {
        if (!$this->referral_code) {
            $this->generateReffCode();
        }
        return $this->referral_code;
    }

    public function generateActivationCode()
    {
        if ($this->status != static::STATUS_INACTIVE) {
            return false;
        }

        $code = $this->generateReffCode();
        return md5($code . $this->updated_at);
    }

    public function matchActivationCode($code)
    {
        return md5($this->referral_code . $this->updated_at) == $code;
    }

    public function activate()
    {
        if ($this->status != static::STATUS_INACTIVE) {
            return false;
        }

        return $this->update(['status' => static::STATUS_ACTIVE]);
    }

    public function getInitial()
    {
        $name = strtoupper($this->name);

        $words = count($names = explode(' ', $name));

        $inits = array_map(function ($value) {
            return substr($value, 0, 1);
        }, $names);

        $initials = $inits[0] . ($words > 1 ? last($inits) : '');

        return $initials;
    }

    public function scopeUsers($query)
    {
        return $query->where('role', '=', "user");
    }

    public function scopeCses($query)
    {
        return $query->where('role', '=', "cs officer");
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', '=', "admin");
    }

    public function getPremiumExpiredDate()
    {
        return ($this->premium_expired_date ? date("d m Y", strtotime($this->premium_expired_date)) : "N/A");
    }

    public function isActive()
    {
        return $this->status == static::STATUS_ACTIVE;
    }

    public function deactivate()
    {
        $this->status = static::STATUS_INACTIVE;
        $this->save();
    }

    public function getEscrowAmount()
    {
        return ($this->escrow_amount ? $this->escrow_amount : "0");
    }

    public function getLastVisit()
    {
        $lastVisit = date("d F Y H:m:s", strtotime($this->last_visit));
        return $lastVisit;
    }

    public function getRegistrationDate()
    {
        $regDate = date("d F Y", strtotime($this->registration_date));
        return $regDate;
    }

    public function getLocation()
    {
        $location = Location::find($this->location_id);
        if ($location) {
            return City::find($location->city_id)->name . ", " . Province::find($location->province_id)->name;
        } else {
            return "N/A";
        }
    }

    public static function getName($id)
    {
        $user = User::find($id);
        if ($user) {
            return $user->name;
        } else {
            return "Tidak ditemukan";
        }
    }

    public function getFullName()
    {
        return $this->name . " " . $this->last_name;
    }

    public function getPremium()
    {
        return (($this->is_premium != null) ? ($this->is_premium == 1 ? "Yes" : "No") : "No");
    }

    public static function getFormalRoleName($roleCode)
    {
        $roles = [ ['admin', 'Administrator'], ['csofficer', 'Customer Service'], ['user', 'Member'] ];
        foreach ($roles as $role) {
            if ($roleCode == $role[0]) {
                return $role[1];
            }
        }
        return "Role not found";
    }

    public function getValidOrders($range)
    {
        $count = 0;

        $orders = Order::where('user_id', '=', $this->id)->get();
        foreach ($orders as $order) {
            if ($order->isOnRange($range)) {
                $count++;
            }
        }
        return $count;
    }

    public function getMoneySpent($range)
    {
        $orders = Order::where('user_id', '=', $this->id)->get();
        $moneyspent = 0;
        foreach ($orders as $order) {
            if ($order->isOnRange($range)) {
                $moneyspent += $order->totalprice;
            }
        }

        return $moneyspent;
    }

    public static $range = null;

    public static function setRange($val)
    {
        //echo "Range set with: " . $val;
        self::$range = $val;
    }

    public static function getRange()
    {
        return self::$range;
    }

    public function updateLastvisit()
    {
        $date = new Carbon('Asia/Jakarta');
        $this->last_visit = $date;
        $this->save();
        return true;
    }

    public static function getSeller()
    {
        $sellers = User::whereIn('id', DB::table('products')->distinct()->pluck('seller_id'))->get();
        return $sellers;
    }

    public static function getBuyer()
    {
        $buyers = User::whereIn('id', DB::table('orders')->distinct()->pluck('user_id'))->get();
        return $buyers;
    }

    public static function getSellerList()
    {
        $sellers = User::users()->pluck('name', 'id');
        return $sellers;
    }

    public function checkTheProduct($productId)
    {
        $myproducts = Order::select('orders.*')
            ->rightJoin('ordered_items', function ($j) {
                $j->on('ordered_items.order_id', '=', 'orders.id');
            })->where('ordered_items.product_id', $productId)
            ->where('orders.user_id', $this->id)->count();
        return $myproducts;
    }

    public function shoppingCarts()
    {
        return $this->hasMany(ShoppingCart::class);
    }

    /**
     * Get file upload path for user picture.
     * @return string
     */
    public function getUserPictureUploadPath()
    {
        return public_path() . '/uploads/profilepicture';
    }

    /**
     * Send the password reset notification.
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $defaultConfig = defaultConfig();
        $orderDetailRoute = isset($defaultConfig['routes']) && isset($defaultConfig['routes']['password_reset']) ?
        $defaultConfig['routes']['password_reset'] : '';
        $this->notify(
            'PasswordReset',
            str_replace('{token}', $token, $orderDetailRoute),
            new ResetPasswordNotification($token)
        );
    }

    public function getFullNameAttribute()
    {
        return $this->name . " / " . $this->email . (!empty($this->role) ? " / " . $this->role : "");
    }

    /**
     * Get options of gender
     *
     */
    public function getGenderOptions()
    {
        return [self::MALE => ucfirst(strtolower(self::MALE)),
                self::FEMALE => ucfirst(strtolower(self::FEMALE))
        ];
    }

    /**
     * Get options of role
     *
     */
    public function getRoleOptions()
    {
        return [self::ADMIN => "Admin",
                //self::CSOFFICER => "CS Officer",
                self::USER => "User"
        ];
    }

    /**
     * Get options of status
     *
     */
    public function getStatusOptions()
    {
        return [self::STATUS_ACTIVE => ucfirst(strtolower(self::STATUS_ACTIVE)),
                self::STATUS_INACTIVE => ucfirst(strtolower(self::STATUS_INACTIVE))
        ];
    }

    public function getPremiumOptions()
    {
        return [
            0 => 'No',
            1 => 'Yes'
        ];
    }

    public function getLabel()
    {
        return "User";
    }

    public function getFormattedValue()
    {
        return $this->name . ' / ' . $this->email;
    }

    public function getFormattedValueColumn()
    {
        return ['name', 'email'];
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
            "username" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Username"
            ],
            "email" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Email Address"
            ],
            "password" => [
                "type" => self::TYPE_PASSWORD,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Password"
            ],
            "role" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Role",
                "options" => $this->getRoleOptions(),
                "filterable" => true
            ],
            "name" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Full Name"
            ],
            "birthdate" => [
                "type" => self::TYPE_DATE,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Birthdate"
            ],
            "picture" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Profile Picture"
            ],
            "gender" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Gender",
                "options" => $this->getGenderOptions()
            ],
            "identity_number" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Identity Number"
            ],
            "tax_id_number" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Tax ID Number"
            ],
            "address_street" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Address Street"
            ],
            "address_city" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Address City"
            ],
            "address_country" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Address Country"
            ],
            "address_zipcode" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Address Zipcode"
            ],
            "phone_number" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Phone Number"
            ],
            "is_premium" => [
                "type" => self::TYPE_BOOLEAN,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Is Premium User?",
                "options" => $this->getPremiumOptions(),
                "filterable" => true
            ],
            "premium_expired_date" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Premium Expire Date"
            ],
            "status" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Status",
                "options" => $this->getStatusOptions(),
                "filterable" => true
            ],
            "newsletter" => [
                "type" => self::TYPE_BOOLEAN,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Receive Newsletter?"
            ],
            "message" => [
                "type" => self::TYPE_BOOLEAN,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Receive Message?"
            ],
            "escrow_amount" => [
                "type" => self::TYPE_FLOAT,
                "visible" => true,
                "formdisplay" => false,
                "required" => false,
                "relation" => null,
                "label" => "Deposit Amount"
            ],
            "shop_name" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Shop Name"
            ],
            "shop_description" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Shop Description"
            ],
            "referral_code" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Referral Code (for reseller)"
            ],
            "optional_user_code" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Optional User Code"
            ],
            "registration_date" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => false,
                "required" => false,
                "relation" => null,
                "label" => "Registration Date"
            ],
            "last_visit" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => false,
                "required" => false,
                "relation" => null,
                "label" => "Last Visit"
            ],
            "user_referral_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => false,
                "required" => false,
                "relation" => "referralUser",
                "label" => "Referral User",
                "options" => []
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
