<?php

namespace Suitcore\Models;

use Suitcore\Thumbnailer\Contracts\Model\ImageThumbnailerInterface;
use Suitcore\Thumbnailer\Model\ThumbnailerTrait;
use Suitcore\Uploader\Contracts\ModelUploaderInterface;
use Suitcore\Uploader\ModelUploaderTrait;
use Suitcore\Currency\ModelCurrencyTrait;
use Suitcore\Models\SuitTranslation;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Exception;
use View;
use Lang;
use DateTimeInterface;

class SuitModel extends Model implements ImageThumbnailerInterface, ModelUploaderInterface
{
    use TransformableToApi;

    /* STATIC */
    public static $thumbnailClass = 'thumbnail';
    public static $partialFormView = [
        self::TYPE_TEXT => 'backend.admin.partials.inputtext',
        self::TYPE_PASSWORD => 'backend.admin.partials.inputpassword',
        self::TYPE_NUMERIC => 'backend.admin.partials.inputnumeric',
        self::TYPE_FLOAT => 'backend.admin.partials.inputfloat',
        self::TYPE_BOOLEAN => 'backend.admin.partials.inputboolean',
        self::TYPE_DATETIME => 'backend.admin.partials.inputdatetime',
        self::TYPE_DATE => 'backend.admin.partials.inputdate',
        self::TYPE_TIME => 'backend.admin.partials.inputtime',
        self::TYPE_TEXTAREA => 'backend.admin.partials.inputtextarea',
        self::TYPE_RICHTEXTAREA => 'backend.admin.partials.inputrichtextarea',
        self::TYPE_FILE => 'backend.admin.partials.inputfile',
        self::TYPE_SELECT => 'backend.admin.partials.inputselect', // additional
        self::TYPE_REFERENCES_LABEL => 'backend.admin.partials.inputreferenceslabel' // additional
    ]; // default value

    /* CONSTANT */
    const TYPE_TEXT = "text";
    const TYPE_PASSWORD = "password";
    const TYPE_NUMERIC = "numeric";
    const TYPE_FLOAT = "float";
    const TYPE_BOOLEAN = "boolean";
    const TYPE_DATETIME = "datetime";
    const TYPE_DATE = "date";
    const TYPE_TIME = "time";
    const TYPE_TEXTAREA = "textarea";
    const TYPE_RICHTEXTAREA = "richtextarea";
    const TYPE_FILE = "file";
    // -- for rendering
    const TYPE_SELECT = "select";
    const TYPE_REFERENCES_LABEL = "referenceslabel";

    /* TRAIT */
    use ThumbnailerTrait {
        getAttribute as thumbnailGetAttribute;
    }
    use ModelUploaderTrait, ModelCurrencyTrait;

    /* ATTRIBUTES */
    protected $defWidth = 480;// landscape
    protected $defHeight = 360; // portrait
    protected $extendedThumbnailStyle = [];
    protected $thumbnailStyle = [
        'small_square' => '128x128',
        'medium_square' => '256x256',
        'large_square' => '512x512',
        'xlarge_square' => '2048x2048',
        'small_cover' => '240x_',
        'normal_cover' => '360x_',
        'medium_cover' => '480x_',
        'large_cover' => '1280x_',
        'small_banner' => '_x240',
        'normal_banner' => '_x360',
        'medium_banner' => '_x480',
        'large_banner' => '_x1280'
    ];
    protected $imageAttributes = [];
    protected $defThumbnailName = '_thumbnail';
    protected $baseFolder = 'public/files';
    public $fillable = [];
    public $rules = [];
    public $errors;
    protected $attributeSettingsCustomState = null;
    protected static $bufferAttributeSettings = null;
    public $nodeClassName = '';
    public $nodeFullClassName = '';
    public $showAllOptions = false;
    public $uploadError = null;

    /* METHODS */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // get node class name
        $this->nodeFullClassName = get_class($this);
        $this->nodeClassName = strtolower((new \ReflectionClass($this))->getShortName());
        // default thumbnail dimension from SuitEvent
        $this->thumbnailStyle = array_merge($this->thumbnailStyle, $this->extendedThumbnailStyle);
        // get custom image dimension config if any
        $defaultConfigClassName = 'App\SuitEvent\Config\DefaultConfig';
        if (class_exists($defaultConfigClassName)) {
            $defaultConfig = $defaultConfigClassName::getConfig();
            if (isset($defaultConfig['thumbnail_dimension']) &&
                isset($defaultConfig['thumbnail_dimension'][$this->nodeClassName])) {
                $this->thumbnailStyle = $defaultConfig['thumbnail_dimension'][$this->nodeClassName];
            }
        }
    }

    public function getTableName() {
        return $this->table;
    }

    public function getDefaultOrderColumn() {
        return $this->getKeyName();
    }

    public function getDefaultOrderColumnDirection() {
        return 'desc';
    }

    public function getAttributeSettings() {
        // default attribute settings of generic model, override for furher use
        return [
            "id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "ID",
                "readonly" => true,
                "initiated" => true,
                "translation" => false
            ],
            "created_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" =>"Created At",
                "readonly" => true,
                "initiated" => true,
                "translation" => false
            ],
            "updated_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Updated At",
                "readonly" => true,
                "initiated" => true,
                "translation" => false
            ]
        ];
    }

    // implements singleton pattern
    public function getBufferedAttributeSettings() {
        if (empty(static::$bufferAttributeSettings)) {
            // BASE :: static::$bufferAttributeSettings = $this->getAttributeSettings();
            $finalAttributeSettingState = $this->getAttributeSettings();
            if ($this->attributeSettingsCustomState &&
                is_array($this->attributeSettingsCustomState) &&
                !empty($this->attributeSettingsCustomState)) {
                $currentAttributeSetting = $finalAttributeSettingState;
                $finalAttributeSettingState = [];
                foreach ($this->attributeSettingsCustomState as $idx => $attrKey) {
                    $finalAttributeSettingState[$attrKey] = $currentAttributeSetting[$attrKey];
                }
            }
            static::$bufferAttributeSettings = $finalAttributeSettingState;
            foreach (static::$bufferAttributeSettings as $attrName => $value) {
                /* Check label translation */
                $targetTranslationPath = $this->nodeClassName . "." . strtolower($attrName);
                if (trans($targetTranslationPath) != $targetTranslationPath) {
                    static::$bufferAttributeSettings[$attrName]['label'] = trans($targetTranslationPath);
                }
            }
        }
        return static::$bufferAttributeSettings;
    }

    public function setBufferedAttributeSettings($name, $key, $value) {
        if (empty(static::$bufferAttributeSettings)) {
            $state = $this->getBufferedAttributeSettings();
        }
        if (isset(static::$bufferAttributeSettings[$name]) &&
            isset(static::$bufferAttributeSettings[$name][$key]))
            static::$bufferAttributeSettings[$name][$key] = $value;
    }

    public function setAttributeSettingsCustomState($attrSettingCustomState) {
        if (is_array($attrSettingCustomState)) {
            $this->attributeSettingsCustomState = $attrSettingCustomState;
        }
    }

    public function getRelatedObject($relationshipName) {
        try {
            $className = get_class($this->{$relationshipName}()->getRelated());
            return new $className();
        } catch (Exception $e) { }
        return new SuitModel();
    }

    /**
     * Extended model for custom field
     * Rules:
     * Class name : ModelExtended
     * Foreign key : model_id
     * @return App\Suitcore\Models\SuitModel|null
     */
    public function extended()
    {
        $extendedModelName = $this->getExtendedModelClassNamespace();
        if (class_exists($extendedModelName)) {
            return $this->hasOne($extendedModelName, $this->getExtendedForeignKey());
        }
        return null;
    }

    public function getExtendedModelClassNamespace()
    {
        $extendedModelNamespace = 'App\ModelExtension';
        $extendedModelName = $extendedModelNamespace . '\\' . (new \ReflectionClass($this))->getShortName() . 'Extension';
        return $extendedModelName;
    }

    function getExtendedForeignKey()
    {
        $className = (new \ReflectionClass($this))->getShortName();
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $className, $matches);
        $words = $matches[0];
        foreach ($words as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        $result = implode('_', $words) . '_id';
        return $result;
    }

    public function getAttribute($key)
    {
        if (ends_with($key, '__trans')) {
            $actualKey = str_replace('__trans', '', $key);
            $translation = SuitTranslation::trans(strtolower(app()->getLocale()), $this->nodeFullClassName, $this->id, $actualKey);
            // return translation or fallback to default value if not exist
            return (empty($translation) ? $this->getAttribute($actualKey) : $translation);
        }
        if ($key == 'attribute_settings') {
            return $this->getBufferedAttributeSettings();
        }
        if ($key == '_label') {
            return $this->getTranslationLabel();
        }
        if ($key == '_defaultOrder') {
            return $this->getDefaultOrderColumn();
        }
        if ($key == '_defaultOrderDir') {
            return $this->getDefaultOrderColumnDirection();
        }
        if (ends_with($key, '__object')) {
            return $this->getRelatedObject(str_replace('__object', '', $key));
        }
        return $this->thumbnailGetAttribute($key);
    }

    static public function getNew()
    {
        return new static;
    }

    public function getError()
    {
        return $this->errors;
    }

    public function isValid($scenario = 'create', $customRules = null, $params = null)
    {
        $rules = method_exists($this, 'rules') ? $this->rules() : $this->rules;
        $defaultConfigClassName = 'App\SuitEvent\Config\DefaultConfig';
        if (class_exists($defaultConfigClassName)) {
            $defaultConfig = $defaultConfigClassName::getConfig();
            if (isset($defaultConfig['rules']) &&
                isset($defaultConfig['rules'][$this->nodeClassName])) {
                $rules = $defaultConfig['rules'][$this->nodeClassName];
            }
        }

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

        // Exclude attributes which has null value for validation purpose.
        // Add 'sometimes' rule to run validation checks against a field
        // only if that field is present in the input array.
        $newAttributes = [];
        if (is_array($params)) {
            $newAttributes = $params;
        } else {
            foreach ($this->attributes as $key => $attribute) {
                if ($attribute != null ||
                    $attribute === floatval(0) ||
                    $attribute === intval(0)
                ) {
                    $newAttributes[$key] = $attribute;
                }
            }
        }
        $v = Validator::make($newAttributes, $rules);

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

    public function getLabel() {
        return "Object";
    }

    final public function getTranslationLabel() {
        /* Check label translation */
        $targetTranslationPath = $this->nodeClassName . ".classlabel";
        if (trans($targetTranslationPath) != $targetTranslationPath) {
            return trans($targetTranslationPath);
        }
        return $this->getLabel();
    }

    public function getUniqueValue() {
        return $this->id;
    }

    public function getUniqueValueColumn() {
        return 'id';
    }

    public function getFormattedValue() {
        return "-";
    }

    public function getFormattedValueColumn() {
        return [];
    }

    public function getDefaultNameAttribute() {
        return $this->getFormattedValue();
    }

    public function __toString()
    {
        return $this->getFormattedValue();
    }

    public function getOptions() {
        return self::all();
    }

    public function getImportExcelKeyBaseName() {
        return [ $this->primaryKey ];
    }

    public function getImportExcelKeyBase() {
        try {
            $keyBaseName = $this->getImportExcelKeyBaseName();
            if (is_array($keyBaseName)) {
                $result = [];
                foreach ($keyBaseName as $key => $value) {
                    $result[$value] = $this->getAttribute($value);
                }
                return $result;
            }
            return [ $keyBaseName => $this->getAttribute($keyBaseName) ];
        } catch (Exception $e) { }
        return [];
    }

    public function renderFormView($attrName, $uploadHandler = null, $errors = null, $customSetting = null, $optionsAjaxHandler = null, $extendedModel = false) {
        // initial setup
        $currentLocale = strtolower(config('app.fallback_locale', 'en'));
        $localeOptions = explode(',', env('APP_MULTI_LOCALE_OPTIONS', $currentLocale));
        $attrSettings = $this->getBufferedAttributeSettings();
        if ($customSetting && is_array($customSetting)) {
            $attrSettings[$attrName] = $customSetting;
        }
        $enableTranslationInput = (env('APP_MULTI_LOCALE', false) &&
                                   isset($attrSettings[$attrName]['translation']) &&
                                   $attrSettings[$attrName]['translation']);
        $formSetting = [
            'extended_model' => $extendedModel,
            'container_id' => false, //
            'id' => false, //
            'masked_id' => false, //
            'name' => false, //
            'label' => false, //
            'value' => false, //
            'masked_value' => false,
            'options' => false, //
            'required' => false, //
            'readonly' => false, //
            'image_file_url' => false,
            'file_url' => false,
            'action_handler_route' => false, //
            'errors' => false, //
            'data_url' => false, //// options autocomplete growing ajax
            'value_text' => false //// options autocomplete growing ajax
        ]; // default setting
        // construct
        $formSetting['id'] = "input".ucfirst(strtolower($attrName));
        $formSetting['masked_id'] = $formSetting['id']."_view";
        if (is_array($attrSettings) && $attrSettings[$attrName] != null) {
            $displayInForm = isset($attrSettings[$attrName]['formdisplay']) ? $attrSettings[$attrName]['formdisplay'] : false;
            if ($displayInForm) {
                $formSetting['container_id'] = $formSetting['id']."Container";
                $formSetting['name'] = $attrName;
                $formSetting['label'] = (isset($attrSettings[$attrName]['label']) ? $attrSettings[$attrName]['label'] : '');
                if ($this->getAttribute($attrName) == '' && isset($attrSettings[$attrName]['default_value'])) {
                    $formSetting['value'] = $attrSettings[$attrName]['default_value'];
                } else {
                    $formSetting['value'] = $this->getAttribute($attrName);
                }
                $formSetting['group'] = (isset($attrSettings[$attrName]['group']) ? $attrSettings[$attrName]['group'] : false);
                $formSetting['options'] = [];
                if (isset($attrSettings[$attrName]['options']) &&
                    ((is_array($attrSettings[$attrName]['options']) &&
                      count($attrSettings[$attrName]['options']) > 0) ||
                     (is_a($attrSettings[$attrName]['options'], 'Illuminate\Support\Collection') &&
                      count($attrSettings[$attrName]['options']) > 0)) ) {
                    if (is_a($attrSettings[$attrName]['options'], 'Illuminate\Support\Collection')) {
                        $formSetting['options'] = $attrSettings[$attrName]['options']->toArray();
                    } else {
                        $formSetting['options'] = $attrSettings[$attrName]['options'];
                    }
                }
                $formSetting['required'] = (isset($attrSettings[$attrName]['required']) ? $attrSettings[$attrName]['required'] : false);
                $formSetting['readonly'] = (isset($attrSettings[$attrName]['readonly']) ? $attrSettings[$attrName]['readonly'] : false);
                $formSetting['action_handler_route'] = $uploadHandler;
                $formSetting['errors'] = ($errors ? $errors->first($attrName) : "");
                // process by type
                if ($attrSettings[$attrName]['type'] == self::TYPE_NUMERIC) {
                    if (isset($attrSettings[$attrName]['options'])) {
                        if ((isset($attrSettings[$attrName]['readonly']) &&
                             $attrSettings[$attrName]['readonly']) ||
                            (isset($attrSettings[$attrName]['initiated']) &&
                             $attrSettings[$attrName]['initiated'])){
                            // As Readonly InputText References
                            $formSetting['masked_value'] = "N/A";
                            if (isset($attrSettings[$attrName]['relation']) &&
                                !empty($attrSettings[$attrName]['relation'])) {
                                $relatedObject = $this->getAttribute($attrSettings[$attrName]['relation']);
                                if ($relatedObject)
                                    $formSetting['masked_value'] = $relatedObject->getFormattedValue();
                                else
                                    $formSetting['masked_value'] = "-";
                                // render
                                return View::make(self::$partialFormView[self::TYPE_REFERENCES_LABEL], ['formSetting' => $formSetting])->render();
                            } else {
                                $relatedReferences = $attrSettings[$attrName]['options'];
                                if (isset($relatedReferences[$this->getAttribute($attrName)]))
                                    $formSetting['masked_value'] = $relatedReferences[$this->getAttribute($attrName)];
                                else
                                    $formSetting['masked_value'] = ucfirst(strtolower($this->getAttribute($attrName)));
                                // render
                                return View::make(self::$partialFormView[self::TYPE_REFERENCES_LABEL], ['formSetting' => $formSetting])->render();
                            }
                        } else {
                            // As Dropdown List Options
                            if ($optionsAjaxHandler &&
                                isset($optionsAjaxHandler[$attrName]) &&
                                !empty($optionsAjaxHandler[$attrName])) {
                                $formSetting['data_url'] = $optionsAjaxHandler[$attrName];
                                $relatedObject = $this->getAttribute($attrSettings[$attrName]['relation']);
                                if ($relatedObject) {
                                    $formSetting['value_text'] = $relatedObject->getFormattedValue();
                                }
                            }
                            // render
                            return View::make(self::$partialFormView[self::TYPE_SELECT], ['formSetting' => $formSetting])->render();
                        }
                    } else {
                        // render
                        return View::make(self::$partialFormView[self::TYPE_NUMERIC], ['formSetting' => $formSetting])->render();
                    }
                } else if ($attrSettings[$attrName]['type'] == self::TYPE_FLOAT) {
                    // render
                    return View::make(self::$partialFormView[self::TYPE_FLOAT], ['formSetting' => $formSetting])->render();
                } else if ($attrSettings[$attrName]['type'] == self::TYPE_BOOLEAN) {
                    // render
                    return View::make(self::$partialFormView[self::TYPE_BOOLEAN], ['formSetting' => $formSetting])->render();
                } else if ($attrSettings[$attrName]['type'] == self::TYPE_DATETIME) {
                    if ((isset($attrSettings[$attrName]['readonly']) &&
                         $attrSettings[$attrName]['readonly']) ||
                        (isset($attrSettings[$attrName]['initiated']) &&
                         $attrSettings[$attrName]['initiated'])){
                        // As Readonly InputText References
                        $formSetting['masked_value'] = "N/A";
                        if (!isEmptyDate($this->getAttribute($attrName))) {
                            try {
                                $formSetting['masked_value'] = date("Y-m-d H:i:s", strtotime($this->getAttribute($attrName)));
                            } catch (Exception $e) { }
                        }
                        // render
                        return View::make(self::$partialFormView[self::TYPE_REFERENCES_LABEL], ['formSetting' => $formSetting])->render();
                    } else {
                        // As Datetime Input Options
                        if (isEmptyDate($this->getAttribute($attrName))) {
                            $formSetting['value'] = date('Y-m-d H:i:s');
                        } else {
                            $formSetting['value'] = date("Y-m-d H:i:s", strtotime($this->getAttribute($attrName)));
                        }
                        // render
                        return View::make(self::$partialFormView[self::TYPE_DATETIME], ['formSetting' => $formSetting])->render();
                    }
                } else if ($attrSettings[$attrName]['type'] == self::TYPE_DATE) {
                    if ((isset($attrSettings[$attrName]['readonly']) &&
                         $attrSettings[$attrName]['readonly']) ||
                        (isset($attrSettings[$attrName]['initiated']) &&
                         $attrSettings[$attrName]['initiated'])){
                        // As Readonly InputText References
                        $formSetting['masked_value'] = "N/A";
                        if (!isEmptyDate($this->getAttribute($attrName))) {
                            try {
                                $formSetting['masked_value'] = date("d F Y", strtotime($this->getAttribute($attrName)));
                            } catch (Exception $e) { }
                        }
                        // render
                        return View::make(self::$partialFormView[self::TYPE_REFERENCES_LABEL], ['formSetting' => $formSetting])->render();
                    } else {
                        // As Date Input Options
                        if (isEmptyDate($this->getAttribute($attrName))) {
                            $formSetting['value'] = date('Y-m-d');
                        } else {
                            $formSetting['value'] = date("Y-m-d", strtotime($this->getAttribute($attrName)));
                        }
                        // render
                        return View::make(self::$partialFormView[self::TYPE_DATE], ['formSetting' => $formSetting])->render();
                    }
                } else if ($attrSettings[$attrName]['type'] == self::TYPE_TIME) {
                    if ((isset($attrSettings[$attrName]['readonly']) &&
                         $attrSettings[$attrName]['readonly']) ||
                        (isset($attrSettings[$attrName]['initiated']) &&
                         $attrSettings[$attrName]['initiated'])){
                        // As Readonly InputText References
                        $formSetting['masked_value'] = "N/A";
                        if (!isEmptyDate($this->getAttribute($attrName))) {
                            try {
                                $formSetting['masked_value'] = date("G:i", strtotime($this->getAttribute($attrName)));
                            } catch (Exception $e) { }
                        }
                        // render
                        return View::make(self::$partialFormView[self::TYPE_REFERENCES_LABEL], ['formSetting' => $formSetting])->render();
                    } else {
                        // As Time Input Options
                        if ($this->getAttribute($attrName) == '') {
                            $formSetting['value'] = date('H:i');
                        } else {
                            $formSetting['value'] = date("H:i", strtotime($this->getAttribute($attrName)));
                        }
                        // render
                        return View::make(self::$partialFormView[self::TYPE_TIME], ['formSetting' => $formSetting])->render();
                    }
                } else if ($attrSettings[$attrName]['type'] == self::TYPE_TEXTAREA) {
                    $formSetting['value'] = trim($this->getAttribute($attrName));
                    // render
                    $translationFormSetting = $formSetting;
                    $translationFormSetting['label'] .= ($enableTranslationInput ? ' (' . strtoupper($currentLocale) . ')' : '');
                    $mainView = View::make(self::$partialFormView[self::TYPE_TEXTAREA], ['formSetting' => $translationFormSetting])->render();
                    $translationView = "";
                    if ($enableTranslationInput) {
                        // foreach targeted translation
                        foreach ($localeOptions as $lang) {
                            if (strtolower($lang) != $currentLocale) {
                                $translationFormSetting = $formSetting;
                                $translationFormSetting['container_id'] .= '_trans_' . $lang;
                                $translationFormSetting['id'] .= '_trans_' . $lang;
                                $translationFormSetting['name'] .= '_trans_' . $lang;
                                $translationFormSetting['label'] .= ' (' . strtoupper($lang) . ')';
                                $translationFormSetting['value'] = SuitTranslation::trans(strtolower($lang), $this->nodeFullClassName, $this->id, $attrName);
                                $translationFormSetting['required'] = false;
                                $translationFormSetting['errors'] = ($errors ? $errors->first($attrName) : "");
                                // translation input form
                                $translationView .= "\n" . View::make(self::$partialFormView[self::TYPE_TEXTAREA], ['formSetting' => $translationFormSetting])->render();
                            }
                        }
                    }
                    return $mainView . "\n" .$translationView;
                } else if ($attrSettings[$attrName]['type'] == self::TYPE_RICHTEXTAREA) {
                    $formSetting['value'] = trim($this->getAttribute($attrName));
                    // render
                    $translationFormSetting = $formSetting;
                    $translationFormSetting['label'] .= ($enableTranslationInput ? ' (' . strtoupper($currentLocale) . ')' : '');
                    $mainView = View::make(self::$partialFormView[self::TYPE_RICHTEXTAREA], ['formSetting' => $translationFormSetting])->render();
                    $translationView = "";
                    if ($enableTranslationInput) {
                        // foreach targeted translation
                        foreach ($localeOptions as $lang) {
                            if (strtolower($lang) != $currentLocale) {
                                $translationFormSetting = $formSetting;
                                $translationFormSetting['container_id'] .= '_trans_' . $lang;
                                $translationFormSetting['id'] .= '_trans_' . $lang;
                                $translationFormSetting['name'] .= '_trans_' . $lang;
                                $translationFormSetting['label'] .= ' (' . strtoupper($lang) . ')';
                                $translationFormSetting['value'] = SuitTranslation::trans(strtolower($lang), $this->nodeFullClassName, $this->id, $attrName);
                                $translationFormSetting['required'] = false;
                                $translationFormSetting['errors'] = ($errors ? $errors->first($attrName) : "");
                                // translation input form
                                $translationView .= "\n" . View::make(self::$partialFormView[self::TYPE_RICHTEXTAREA], ['formSetting' => $translationFormSetting])->render();
                            }
                        }
                    }
                    return $mainView . "\n" .$translationView;
                } else if ($attrSettings[$attrName]['type'] == self::TYPE_FILE) {
                    if ($this->getAttribute($attrName)) {
                        if (is_array($this->imageAttributes) &&
                            count($this->imageAttributes) > 0 &&
                            in_array($attrName, array_keys($this->imageAttributes))) {
                            $formSetting['image_file_url'] = $this->getAttribute($attrName."_medium_cover");
                            // render
                            return View::make(self::$partialFormView[self::TYPE_FILE], ['formSetting' => $formSetting])->render();
                        } else {
                            $formSetting['file_url'] = $this->getFileAccessPath($attrName);
                            // render
                            return View::make(self::$partialFormView[self::TYPE_FILE], ['formSetting' => $formSetting])->render();
                        }
                    } else {
                        if (is_array($this->imageAttributes) &&
                            count($this->imageAttributes) > 0 &&
                            in_array($attrName, array_keys($this->imageAttributes))) {
                            $formSetting['image_file_url'] = 'nofile';
                            // render
                            return View::make(self::$partialFormView[self::TYPE_FILE], ['formSetting' => $formSetting])->render();
                        } else {
                            $formSetting['file_url'] = 'nofile';
                            // render
                            return View::make(self::$partialFormView[self::TYPE_FILE], ['formSetting' => $formSetting])->render();
                        }
                    }
                } elseif ($attrSettings[$attrName]['type'] == self::TYPE_PASSWORD) {
                    // render
                    return View::make(self::$partialFormView[self::TYPE_PASSWORD], ['formSetting' => $formSetting])->render();
                } else {
                    // default is inputText
                    if (isset($attrSettings[$attrName]['options']) && is_array($attrSettings[$attrName]['options'])) {
                        if ((isset($attrSettings[$attrName]['readonly']) &&
                             $attrSettings[$attrName]['readonly']) ||
                            (isset($attrSettings[$attrName]['initiated']) &&
                             $attrSettings[$attrName]['initiated'])){
                            // As Readonly InputText References
                            $relatedReferences = $attrSettings[$attrName]['options'];
                            $formSetting['masked_value'] = "-";
                            if (isset($relatedReferences[$this->getAttribute($attrName)]))
                                $formSetting['masked_value'] = $relatedReferences[$this->getAttribute($attrName)];
                            else
                                $formSetting['masked_value'] = ucfirst(strtolower($this->getAttribute($attrName)));
                            // render
                            return View::make(self::$partialFormView[self::TYPE_REFERENCES_LABEL], ['formSetting' => $formSetting])->render();
                        } else {
                            // As Dropdown List Options
                            // render
                            return View::make(self::$partialFormView[self::TYPE_SELECT], ['formSetting' => $formSetting])->render();
                        }
                    } else {
                        // default is inputText without options
                        // render
                        $translationFormSetting = $formSetting;
                        $translationFormSetting['label'] .= ($enableTranslationInput ? ' (' . strtoupper($currentLocale) . ')' : '');
                        $mainView = View::make(self::$partialFormView[self::TYPE_TEXT], ['formSetting' => $translationFormSetting])->render();
                        $translationView = "";
                        if ($enableTranslationInput) {
                            // foreach targeted translation
                            foreach ($localeOptions as $lang) {
                                if (strtolower($lang) != $currentLocale) {
                                    $translationFormSetting = $formSetting;
                                    $translationFormSetting['container_id'] .= '_trans_' . $lang;
                                    $translationFormSetting['id'] .= '_trans_' . $lang;
                                    $translationFormSetting['name'] .= '_trans_' . $lang;
                                    $translationFormSetting['label'] .= ' (' . strtoupper($lang) . ')';
                                    $translationFormSetting['value'] = SuitTranslation::trans(strtolower($lang), $this->nodeFullClassName, $this->id, $attrName);
                                    $translationFormSetting['required'] = false;
                                    $translationFormSetting['errors'] = ($errors ? $errors->first($attrName) : "");
                                    // translation input form
                                    $translationView .= "\n" . View::make(self::$partialFormView[self::TYPE_TEXT], ['formSetting' => $translationFormSetting])->render();
                                }
                            }
                        }
                        return $mainView . "\n" .$translationView;
                    }
                }
            }
        }
        // return empty form entry
        return "";
    }

    public function renderAttribute($attrName, $columnFormatted = null) {
        $attrSettings = $this->getBufferedAttributeSettings()[$attrName];
        $tmpRow = '';
        // if ($attrSettings['visible']) {
            $rendered = false;
            if (is_array($columnFormatted) &&
                isset($columnFormatted[$attrName]) &&
                !empty($columnFormatted[$attrName])) {
                // Custom Template / Format
                try {
                    $maskedValue = (property_exists(get_class($this), $attrName."_attribute_label") ? $this->getAttribute($attrName."_attribute_label") : $this->getAttribute($attrName));
                    if (isset($columnFormatted["_render_".$attrName])) {
                        // try render using provided function
                        try {
                            $maskedValue = call_user_func($columnFormatted["_render_".$attrName], $this->getAttribute($attrName));
                        } catch (Exception $e2) { }
                    }
                    if (is_array($columnFormatted[$attrName])) {
                        if (isset( $columnFormatted[$attrName][$this->getAttribute($attrName)] )) {
                            $tmpRow = str_replace('#'.$attrName.'#', $maskedValue, $columnFormatted[$attrName][$this->getAttribute($attrName)]);
                        } else {
                            $tmpRow = str_replace('#'.$attrName.'#', $maskedValue, $columnFormatted[$attrName][array_keys($columnFormatted[$attrName])[0]]);
                        }
                    } else {
                        $tmpRow = str_replace('#'.$attrName.'#', $maskedValue, $columnFormatted[$attrName]);
                    }
                    $rendered = true;
                } catch (Exception $e) {
                    // Back to default format
                    $rendered = false;
                }
            }
            if (!$rendered) {
                // Standard Template / Format
                if ($attrSettings['relation'] != null) {
                    $relatedObject = $this->getAttribute($attrSettings['relation']);
                    if ($relatedObject)
                        $tmpRow = $relatedObject->getFormattedValue();
                    else
                        $tmpRow = "-";
                } else if ($attrSettings['type'] == self::TYPE_NUMERIC) {
                    if (isset($attrSettings['options']) && is_array($attrSettings['options'])) {
                        $relatedReferences = $attrSettings['options'];
                        if (isset($relatedReferences[$this->getAttribute($attrName)]))
                            $tmpRow = $relatedReferences[$this->getAttribute($attrName)];
                        else
                            $tmpRow = $this->getAttribute($attrName);
                    } else {
                        try {
                            $tmpRow = ($this->getAttribute($attrName) ? number_format($this->getAttribute($attrName),0,'.',',') : 0);
                        } catch (Exception $e) {
                            // Back to default plain
                            $tmpRow = $this->getAttribute($attrName);
                        }
                    }
                } else if ($attrSettings['type'] == self::TYPE_FLOAT) {
                    if (isset($attrSettings['options']) && is_array($attrSettings['options'])) {
                        $relatedReferences = $attrSettings['options'];
                        if (isset($relatedReferences[$this->getAttribute($attrName)]))
                            $tmpRow = $relatedReferences[$this->getAttribute($attrName)];
                        else
                            $tmpRow = $this->getAttribute($attrName);
                    } else {
                        try {
                            $tmpRow = ($this->getAttribute($attrName) ? $this->getAttribute($attrName) : 0);
                        } catch (Exception $e) {
                            // Back to default plain
                            $tmpRow = $this->getAttribute($attrName);
                        }
                    }
                } else if ($attrSettings['type'] == self::TYPE_DATETIME) {
                    if (isEmptyDate($this->getAttribute($attrName))) {
                        $tmpRow = "-";
                    } else {
                        try {
                            $tmpRow = ($this->getAttribute($attrName) ? date("d F Y G:i", strtotime($this->getAttribute($attrName))) : '-');
                        } catch (Exception $e) {
                            // Back to default plain
                            $tmpRow = $this->getAttribute($attrName);
                        }
                    }
                } else if ($attrSettings['type'] == self::TYPE_DATE) {
                    if (isEmptyDate($this->getAttribute($attrName))) {
                        $tmpRow = "-";
                    } else {
                        try {
                            $tmpRow = ($this->getAttribute($attrName) ? date("d F Y", strtotime($this->getAttribute($attrName))) : '-');
                        } catch (Exception $e) {
                            // Back to default plain
                            $tmpRow = $this->getAttribute($attrName);
                        }
                    }
                } else if ($attrSettings['type'] == self::TYPE_TIME) {
                    if (isEmptyDate($this->getAttribute($attrName))) {
                        $tmpRow = "-";
                    } else {
                        try {
                            $tmpRow = ($this->getAttribute($attrName) ? date("G:i", strtotime($this->getAttribute($attrName))) : '-');
                        } catch (Exception $e) {
                            // Back to default plain
                            $tmpRow = $this->getAttribute($attrName);
                        }
                    }
                } else if ($attrSettings['type'] == self::TYPE_BOOLEAN) {
                    $tmpRow = ($this->getAttribute($attrName) ? "YES" : "NO");
                } else if ($attrSettings['type'] == self::TYPE_FILE) {
                    if ($this->getAttribute($attrName)) {
                        if (is_array($this->imageAttributes) &&
                            count($this->imageAttributes) > 0 &&
                            in_array($attrName, array_keys($this->imageAttributes))) {
                            $tmpRow = "<a href='" . $this->getAttribute($attrName) . "' target='_blank'><img class='".self::$thumbnailClass."' src='".$this->getAttribute($attrName."_medium_cover")."' style='max-height: 120px; max-width:120px;' alt=''></a>";
                        } else {
                            $tmpRow = "<a target='_BLANK' href='".$this->getFileAccessPath($attrName)."'>".$this->getAttribute($attrName)."</a>";
                        }
                    } else {
                        if (is_array($this->imageAttributes) &&
                            count($this->imageAttributes) > 0 &&
                            in_array($attrName, array_keys($this->imageAttributes))) {
                            $tmpRow = "<i>( No Image )</i>";
                        } else {
                            $tmpRow = "<i>( No File )</i>";
                        }
                    }
                } else if ($attrSettings['type'] == self::TYPE_RICHTEXTAREA) {
                    // Rich Text Based
                    $tmpRow = htmlspecialchars_decode($this->getAttribute($attrName));
                } else {
                    // Text Based
                    if (isset($attrSettings['options']) && is_array($attrSettings['options'])) {
                        $relatedReferences = $attrSettings['options'];
                        if (isset($relatedReferences[$this->getAttribute($attrName)]))
                            $tmpRow = $relatedReferences[$this->getAttribute($attrName)];
                        else
                            $tmpRow = ucfirst(strtolower($this->getAttribute($attrName)));
                    } else {
                        $tmpRow = $this->getAttribute($attrName);
                    }
                }
            }
        // }
        // Return
        return $tmpRow;
    }

    public function renderRawAttribute($attrName) {
        $attrSettings = $this->getBufferedAttributeSettings()[$attrName];
        $tmpRow = '';
        // Standard Template / Format
        if ($attrSettings['relation'] != null) {
            $relatedObject = $this->getAttribute($attrSettings['relation']);
            if ($relatedObject)
                $tmpRow = $relatedObject->getFormattedValue();
            else
                $tmpRow = "-";
        } else if ($attrSettings['type'] == self::TYPE_NUMERIC) {
            if (isset($attrSettings['options']) && is_array($attrSettings['options'])) {
                $relatedReferences = $attrSettings['options'];
                if (isset($relatedReferences[$this->getAttribute($attrName)]))
                    $tmpRow = $relatedReferences[$this->getAttribute($attrName)];
                else
                    $tmpRow = $this->getAttribute($attrName);
            } else {
                try {
                    $tmpRow = ($this->getAttribute($attrName) ? number_format($this->getAttribute($attrName),0,'.',',') : 0);
                } catch (Exception $e) {
                    // Back to default plain
                    $tmpRow = $this->getAttribute($attrName);
                }
            }
        } else if ($attrSettings['type'] == self::TYPE_FLOAT) {
            if (isset($attrSettings['options']) && is_array($attrSettings['options'])) {
                $relatedReferences = $attrSettings['options'];
                if (isset($relatedReferences[$this->getAttribute($attrName)]))
                    $tmpRow = $relatedReferences[$this->getAttribute($attrName)];
                else
                    $tmpRow = $this->getAttribute($attrName);
            } else {
                try {
                    $tmpRow = ($this->getAttribute($attrName) ? $this->getAttribute($attrName) : 0);
                } catch (Exception $e) {
                    // Back to default plain
                    $tmpRow = $this->getAttribute($attrName);
                }
            }
        } else if ($attrSettings['type'] == self::TYPE_DATETIME) {
            if (isEmptyDate($this->getAttribute($attrName))) {
                $tmpRow = "-";
            } else {
                try {
                    $tmpRow = ($this->getAttribute($attrName) ? date("d F Y G:i", strtotime($this->getAttribute($attrName))) : '-');
                } catch (Exception $e) {
                    // Back to default plain
                    $tmpRow = $this->getAttribute($attrName);
                }
            }
        } else if ($attrSettings['type'] == self::TYPE_DATE) {
            if (isEmptyDate($this->getAttribute($attrName))) {
                $tmpRow = "-";
            } else {
                try {
                    $tmpRow = ($this->getAttribute($attrName) ? date("d F Y", strtotime($this->getAttribute($attrName))) : '-');
                } catch (Exception $e) {
                    // Back to default plain
                    $tmpRow = $this->getAttribute($attrName);
                }
            }
        } else if ($attrSettings['type'] == self::TYPE_TIME) {
            if (isEmptyDate($this->getAttribute($attrName))) {
                $tmpRow = "-";
            } else {
                try {
                    $tmpRow = ($this->getAttribute($attrName) ? date("G:i", strtotime($this->getAttribute($attrName))) : '-');
                } catch (Exception $e) {
                    // Back to default plain
                    $tmpRow = $this->getAttribute($attrName);
                }
            }
        } else if ($attrSettings['type'] == self::TYPE_BOOLEAN) {
            $tmpRow = ($this->getAttribute($attrName) ? "YES" : "NO");
        } else if ($attrSettings['type'] == self::TYPE_FILE) {
            if ($this->getAttribute($attrName)) {
                if (is_array($this->imageAttributes) &&
                    count($this->imageAttributes) > 0 &&
                    in_array($attrName, array_keys($this->imageAttributes))) {
                    $tmpRow = $this->getAttribute($attrName."_medium_cover");
                } else {
                    $tmpRow = $this->getAttribute($attrName."_full_path");
                }
            } else {
                if (is_array($this->imageAttributes) &&
                    count($this->imageAttributes) > 0 &&
                    in_array($attrName, array_keys($this->imageAttributes))) {
                    $tmpRow = "No Image";
                } else {
                    $tmpRow = "No File";
                }
            }
        } else {
            // Text Based
            if (isset($attrSettings['options']) && is_array($attrSettings['options'])) {
                $relatedReferences = $attrSettings['options'];
                if (isset($relatedReferences[$this->getAttribute($attrName)]))
                    $tmpRow = $relatedReferences[$this->getAttribute($attrName)];
                else
                    $tmpRow = ucfirst(strtolower($this->getAttribute($attrName)));
            } else {
                $tmpRow = $this->getAttribute($attrName);
            }
        }
        // return
        return $tmpRow;
    }

    public function getFileAccessPath($field) {
        if (is_array($this->files) && isset($this->files[$field])) {
            return "/files/" . $this->files[$field] . "/" . $this->getAttribute($field);
        }
        return "";
    }

    // Overided from Query Builder
    /**
     * Increment a column's value by a given amount.
     *
     * @param  string  $column
     * @param  int     $amount
     * @param  array   $extra
     * @return int
     */
    public function increment($column, $amount = 1, array $extra = [])
    {
        $columns = array_merge([$column => $this->getAttribute($column) + $amount], $extra);

        return $this->update($columns);
    }

    /**
     * Decrement a column's value by a given amount.
     *
     * @param  string  $column
     * @param  int     $amount
     * @param  array   $extra
     * @return int
     */
    public function decrement($column, $amount = 1, array $extra = [])
    {
        $columns = array_merge([$column => $this->getAttribute($column) - $amount], $extra);

        return $this->update($columns);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->toIso8601String();
    }
}
