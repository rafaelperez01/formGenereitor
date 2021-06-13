<?php

namespace formGenereitor\base;

use formGenereitor\interfaces\FormInterface;

require_once "ErrorBase.php";

/**
 * @author Rafael Perez <rafaelperez7461@gmail.com>
 * Displays <a href="https://opensource.org/licenses/MIT">The MIT License</a>
 * @license https://opensource.org/licenses/MIT The MIT License
 * @package formGenereitor1.0.0
 */
abstract class FieldBase 
{    
    /**
     * The following list does NOT include all the attributes accepted by a field,
     * but the most used ones. To know all the allowed attributes visit:
     * Displays <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes">Global attributes</a>
     */
    protected $attributes = [];
    
    const FIELD_TYPES_LIST = ['submit', 'tel', 'text', 'textarea', 'select', 'button', 'checkbox', 'color', 'date', 'datetime-local', 'email', 'file', 'hidden', 'image', 'month', 'number', 'password', 'radio', 'range', 'reset', 'search',  'time', 'url', 'week',];
    
    // Options for Label
    protected $showLabel = true;
    protected $labelContent = "";
    protected $labelAttributes = [];
    
    // Options for field type select
    protected $selectOptions = [];
    const ALLOWED_ATTRIBUTES_FOR_SELECT = ['name', 'id', 'class', 'required', 'readonly', 'form', 'disabled', 'style',];
    protected $optionSelected = '';
    
    // Options for field type textarea
    const ALLOWED_ATTRIBUTER_FOR_TEXTAREA = ['name', 'id', 'cols', 'rows', 'class', 'maxlength', 'placeholder', 'required', 'wrap', 'readonly', 'form', 'disabled', 'title', 'style',];

    protected $showBootstrap = false;
    
    protected $form;
    
    protected static $id = 1;

    protected $errors = [];
    protected $renderErrors = "";
    protected $language = 'en';

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * FieldBase constructor.
     * @param string $name
     * @param null $value
     * @param string $type
     * @param bool $showBootstrap
     */
    public function __construct(string $name, $value = null, string $type = 'text', bool $showBootstrap = false)
    {
        $this->setName($name);
        $this->setType($type);
        $this->setValue($value);
        $this->setPlaceholder(trim($name, "[]"));
        $this->setTitle(trim($name, "[]"));
        if(1 == self::$id) { $this->setAutofocus(); }
        $fieldId = 'field_' . self::$id++;
        $this->setId($fieldId);
        $this->setLabelFor($fieldId);
        $this->showBootstrap($showBootstrap);
    }

    /**
     * If an attribute exists, it gets the value.
     *
     * @param string $attrName
     * @return mixed
     */
    public function get(string $attrName)
    {
        $attrName = strtolower($attrName);
        return @$this->getAttributes()[$attrName];
    }

    /**
     * @param string $attrName
     * @param $value
     * @return $this
     */
    public function set(string $attrName, $value)
    {
        $attrName = strtolower($attrName);
        $this->attributes[$attrName] = $value;
        
        return $this;
    }


    /**
     * Set the field type, validating that the type is one allowed within the FIELD_TYPES_LIST list
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {        
        $type = strtolower($type);
        $this->attributes['type'] = in_array($type, self::FIELD_TYPES_LIST) ? $type : 'text';        
        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $ret = '';
        
        if( !is_null($this->getForm()) and $this->getForm()->getShowBootstrap() ){
            $this->showBootstrap = true;
        }
        
        switch ($this->getType()) {
            case 'select': $ret .= $this->renderSelect();
                break;
            case 'textarea': $ret .= $this->renderTextArea();
                break;
            case 'date': $ret .= $this->renderDate();
                break;
            case 'radio': $ret .= $this->renderRadio();
                break;
            case 'checkbox': $ret .= $this->renderCheckbox();
                break;
            case 'reset':
            case 'button':
            case 'submit': $ret .= $this->renderSubmit();
                break;
            default: $ret .= $this->renderDefault();
                break;
        }
        
        return $ret;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->render();
    }

    /**
     * @return string
     */
    protected function renderAttributes()
    {
        switch($this->getType()){
            case 'textarea': $Attributes = $this->getTextAreaAttr();
            break;
            case 'select': $Attributes = $this->getSelectAttr();
            break;
            default: $Attributes = $this->getAttributes();
            break;
        }
        
        $renderAttributes = [];
        foreach ($Attributes as $attribute => $value){
            if("" != $value and !is_array($value)){
                if(true === $value){
                    $renderAttributes[] = "$attribute";
                } else {
                    $renderAttributes[] = "$attribute='$value'";
                }
            }
        }

        return implode(" ", $renderAttributes);
    }

    /**
     * @return array
     */
    protected function getTextAreaAttr()
    {
        $ret = [];
        $attrList = $this->getAttributes();
        foreach (self::ALLOWED_ATTRIBUTER_FOR_TEXTAREA as $attr){
            $attrValue = @$attrList[$attr];
            if(!is_null($attrValue)){
                $ret[$attr] = $attrValue;
            }
        }
        
        return $ret;
    }

    /**
     * @return array
     */
    protected function getSelectAttr()
    {
        $ret = [];
        $attrList = $this->getAttributes();
        foreach (self::ALLOWED_ATTRIBUTES_FOR_SELECT as $attr){
            $attrValue = @$attrList[$attr];
            if(!is_null($attrValue)){
                $ret[$attr] = $attrValue;
            }
        }
        
        return $ret;
    }

    /**
     * @return string
     */
    protected function renderDefault()
    {
        $ret = "";
        if($this->showLabel){
            $ret .= $this->renderLabel();
        }
        
        if($this->showBootstrap){
            $this->setClassBootstrap();
        }
        
        $attr = $this->renderAttributes();
        $ret .= "\t<input {$attr}/>" . PHP_EOL;
        $ret .= $this->renderErrors;
        
        if($this->showBootstrap){
            $hasError = !empty($this->errors) ? " has-error" : "";
            $ret = "<div class='form-group$hasError'>\n{$ret}</div>" . PHP_EOL;
        } elseif(empty($this->errors)) {
            $ret .= "\t<br>" . PHP_EOL;
        }

        return $ret;
    }

    /**
     * @return string
     */
    protected function renderRadio()
    {
        if($this->showBootstrap){
            $this->setClassBootstrap();
        }
        
        $attr = $this->renderAttributes();
        $ret = "\t<input {$attr}/>" . PHP_EOL;
        if($this->showLabel){
            $attr = $this->renderLabelAttibutes();
            $label = "\t<label {$attr}>";
            $label .= $ret . $this->getLabel();
            $label .= "</label><br>" . PHP_EOL;
            $ret = $label;
        }
        $ret .= $this->renderErrors;
        
        if($this->showBootstrap){
            $hasError = !empty($this->errors) ? " has-error" : "";
            $ret = "<div class='radio$hasError'>\n{$ret}</div>" . PHP_EOL;
        }
        
        return $ret;
    }

    /**
     * @return string
     */
    protected function renderCheckbox()
    {
        if($this->showBootstrap){
            $this->setClassBootstrap();
        }
        
        $attr = $this->renderAttributes();
        $ret = "\t<input {$attr}/>" . PHP_EOL;
        if($this->showLabel){
            $attr = $this->renderLabelAttibutes();
            $label = "\t<label {$attr}>" . PHP_EOL;
            $label .= $ret;
            $label .= $this->getLabel() . "" . PHP_EOL;
            $label .= "</label><br>" . PHP_EOL;
            $ret = $label;
        }
        $ret .= $this->renderErrors;
        
        if($this->showBootstrap){
            $hasError = !empty($this->errors) ? " has-error" : "";
            $ret = "<div class='checkbox$hasError'>\n{$ret}</div>" . PHP_EOL;
        }
        
        return $ret;
    }

    /**
     * @return string
     */
    protected function renderSubmit()
    {
        $this->showLabel(false);
        if($this->showBootstrap){
            $class = $this->getClass() . " btn";
            $this->setClass($class);
        }
        $attr = $this->renderAttributes();
        $ret = "<input {$attr}/><br>" . PHP_EOL;

        if (!$this->showBootstrap) {
            $ret = "\t<br>{$ret}" . PHP_EOL;
        }

        return $ret;
    }

    /**
     * @return string
     */
    protected function renderSelect()
    {
        $ret = "";
        if($this->showLabel){
            $ret .= $this->renderLabel();
        }
        
        if($this->showBootstrap){
            $this->setClassBootstrap();
        }
        
        $attr = $this->renderAttributes();
        $ret .= "\t<select {$attr}>" . PHP_EOL;
        $ret .= $this->renderOptions();
        $ret .= "\t</select>" . PHP_EOL;
        $ret .= $this->renderErrors;
        
        if($this->showBootstrap){
            $hasError = !empty($this->errors) ? " has-error" : "";
            $ret = "<div class='form-group$hasError'>\n{$ret}</div>" . PHP_EOL;
        } elseif(empty($this->errors)) {
            $ret .= "\t<br>" . PHP_EOL;
        }
        
        return $ret;
    }

    /**
     * @return string
     */
    protected function renderOptions()
    {
        $ret = "";
        $optionSelected = $this->getOptionSelected() ?: $this->getValue();
        $options = $this->getOptions() ?: $this->getValue();
        if(is_array($options)){
            foreach ($options as $value => $label){
                $selected = $optionSelected === $value ? "selected" : '';
                $ret .= "\t\t<option value='{$value}' {$selected}>{$label}</option>" . PHP_EOL;
            }
        }
        
        return $ret;
    }

    /**
     * @return string
     */
    protected function renderTextArea()
    {
        $ret = "";
        if($this->showLabel){
            $ret .= $this->renderLabel();
        }
        
        if($this->showBootstrap){
            $this->setClassBootstrap();
        }
        
        $ret .= "\t<textarea " . $this->renderAttributes() . ">";
        $ret .= $this->getValue();
        $ret .= "</textarea>" . PHP_EOL;
        $ret .= $this->renderErrors;
        
        if($this->showBootstrap){
            $hasError = !empty($this->errors) ? " has-error" : "";
            $ret = "<div class='form-group$hasError'>\n{$ret}</div>" . PHP_EOL;
        } elseif(empty($this->errors)) {
            $ret .= "\t<br>" . PHP_EOL;
        }
        
        return $ret;
    }

    /**
     * @return string
     */
    protected function renderDate()
    {
        $ret = "";
        if($this->showLabel){
            $ret .= $this->renderLabel();
        }
        
        if("" != $this->getValue()){
            $value = date('Y-m-d', strtotime($this->getValue()));
            $this->setValue($value);
        }
        
        if($this->showBootstrap){
            $this->setClassBootstrap();
        }
        
        $ret .= "\t<input " . $this->renderAttributes() . "/>" . PHP_EOL;
        $ret .= $this->renderErrors;
        
        if($this->showBootstrap){
            $hasError = !empty($this->errors) ? " has-error" : "";
            $ret = "<div class='form-group$hasError'>\n{$ret}</div>" . PHP_EOL;
        } elseif(empty($this->errors)) {
            $ret .= "\t<br>" . PHP_EOL;
        }
        
        return $ret;
    }

    /**
     * @return string
     */
    protected function getOptionSelected()
    {
        return $this->optionSelected;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->selectOptions;
    }


    /**
     * It receives as the first parameter an associative array with the key = value pair
     * @param array $options
     * @param null $selected
     * @return $this
     */
    public function setOptions(array $options, $selected = null)
    {
        if(!empty($options)){
            $this->selectOptions = $options;
            $this->setOptionSelected($selected);
        }
        
        return $this;
    }

    /**
     * @param $selected
     * @return $this
     */
    protected function setOptionSelected($selected)
    {
        if(!is_null($selected)){
            $this->optionSelected = $selected;
        }
        return $this;
    }

    /**
     * @param bool $show
     * @return $this
     */
    public function showLabel($show = true)
    {
        $this->showLabel = true === $show;
        return $this;
    }

    /**
     * @param bool $show
     * @return $this
     */
    public function showBootstrap($show = true)
    {
        $this->showBootstrap = true === $show;
        return $this;
    }

    /**
     * @return string
     */
    protected function renderLabelAttibutes()
    {
        $renderAttributes = [];
        foreach ($this->labelAttributes as $attribute => $value){
            if("" != $value){
                $renderAttributes[] = "$attribute='$value'";
            }
        }
        
        return implode(" ", $renderAttributes);
    }

    /**
     * @return string
     */
    protected function renderLabel()
    {        
        $attr = $this->renderLabelAttibutes();
        $ret = "\t<label {$attr}>";
        $ret .= $this->getLabel();
        $ret .= "</label><br>" . PHP_EOL;

        return $ret;      
    }

    /**
     * @return false|string
     */
    public function toJson()
    {
        $ret = array_filter($this->getAttributes());
        if($this->showLabel){
            $ret['label'] = array_filter($this->getLabelAttributes());
        }
        
        return json_encode($ret);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * @return mixed|string
     */
    public function getLabel()
    {
        return ("" != $this->labelContent) ? $this->labelContent : $this->getTitle();
    }

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {       
        $this->labelContent = $label;
        if("" == $this->getPlaceholder()){
            $this->setPlaceholder($label);
        }
        
        if("" == $this->getTitle()){
            $this->setTitle($label);
        }
        
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelId()
    {
        return @$this->labelAttributes['id'];
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setLabelId(string $id)
    {
        $id = str_replace(" ", "_", $id);
        $this->labelAttributes['id'] = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelFor()
    {
        return @$this->labelAttributes['for'];
    }

    /**
     * @param string $for
     * @return $this
     */
    public function setLabelFor(string $for)
    {
        $for = str_replace(" ", "_", $for);
        $this->labelAttributes['for'] = $for;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelClass()
    {
        return @$this->labelAttributes['class'];
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setLabelClass(string $class)
    {
        $this->labelAttributes['class'] = $class;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelForm()
    {
        return @$this->labelAttributes['form'];
    }

    /**
     * @param string $form
     * @return $this
     */
    public function setLabelForm(string $form)
    {
        $this->labelAttributes['form'] = $form;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelAccesskey()
    {
        return @$this->labelAttributes['accesskey'];
    }

    /**
     * @param string $accesskey
     * @return $this
     */
    public function setLabelAccesskey(string $accesskey)
    {
        $this->labelAttributes['accesskey'] = $accesskey;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getLabelAttributes()
    {
        return $this->labelAttributes;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return @$this->attributes['name'];
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return @$this->attributes['type'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return @$this->attributes['id'];
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return @$this->attributes['class'];
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return @$this->attributes['value'];
    }

    /**
     * @return mixed
     */
    public function getAlt()
    {
        return @$this->attributes['alt'];
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return @$this->attributes['title'];
    }

    /**
     * @return mixed
     */
    public function getPlaceholder()
    {
        return @$this->attributes['placeholder'];
    }

    /**
     * @return mixed
     */
    public function getRequired()
    {
        return @$this->attributes['required'];
    }

    /**
     * @return mixed
     */
    public function getFormTarget()
    {
        return @$this->attributes['form'];
    }

    /**
     * @return mixed
     */
    public function getMaxlength()
    {
        return @$this->attributes['maxlength'];
    }

    /**
     * @return mixed
     */
    public function getMinlength()
    {
        return @$this->attributes['minlength'];
    }

    /**
     * @return mixed
     */
    public function getMax()
    {
        return @$this->attributes['max'];
    }

    /**
     * @return mixed
     */
    public function getMin()
    {
        return @$this->attributes['min'];
    }

    /**
     * @return mixed
     */
    public function getRows()
    {
        return @$this->attributes['rows'];
    }

    /**
     * @return mixed
     */
    public function getCols()
    {
        return @$this->attributes['cols'];
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return @$this->attributes['width'];
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return @$this->attributes['height'];
    }

    /**
     * @return mixed
     */
    public function getDisabled()
    {
        return @$this->attributes['disabled'];
    }

    /**
     * @return mixed
     */
    public function getReadonly()
    {
        return @$this->attributes['readonly'];
    }

    /**
     * @return mixed
     */
    public function getAutofocus()
    {
        return @$this->attributes['autofocus'];
    }

    /**
     * @return mixed
     */
    public function getAutocomplete()
    {
        return @$this->attributes['autocomplete'];
    }

    /**
     * @return mixed
     */
    public function getSelected()
    {
        return @$this->attributes['selected'];
    }

    /**
     * @return mixed
     */
    public function getChecked()
    {
        return @$this->attributes['checked'];
    }

    /**
     * @return mixed
     */
    public function getMultiple()
    {
        return @$this->attributes['multiple'];
    }

    /**
     * @return mixed
     */
    public function getStep()
    {
        return @$this->attributes['step'];
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return @$this->attributes['size'];
    }

    /**
     * @return mixed
     */
    public function getSrc()
    {
        return @$this->attributes['src'];
    }

    /**
     * @return mixed
     */
    public function getPattern()
    {
        return @$this->attributes['pattern'];
    }

    /**
     * @return mixed
     */
    public function getAccept()
    {
        return @$this->attributes['accept'];
    }

    /**
     * @return mixed
     */
    public function getWrap()
    {
        return @$this->attributes['wrap'];
    }

    /**
     * @return mixed
     */
    public function getStyle()
    {
        return @$this->attributes['style'];
    }

    /**
     * @param string $style
     * @return $this
     */
    public function setStyle(string $style)
    {
        $this->attributes['style'] = $style;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $name = str_replace(" ", "_", $name);
        $this->attributes['name'] = $name;
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $id = str_replace(" ", "_", $id);
        $this->attributes['id'] = $id;
        $this->setLabelFor($id);
        return $this;
    }

    /**
     * @return $this
     */
    protected function setClassBootstrap()
    {
        switch ($this->getType()){
            case 'radio':
            case 'checkbox': $bootstrapClass = "";//"form-check-input";
                break;
            case 'range': $bootstrapClass = "";//"form-control-range";
                break;
            case 'file': $bootstrapClass = "";//"form-control-file";
                break;
            default : $bootstrapClass = "form-control";
                break;
        }
        
        $class = !empty($this->getClass()) ? $this->getClass() . " " . $bootstrapClass : $bootstrapClass;        
        $this->setClass($class);
        return $this;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setClass(string $class)
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        if (is_array($value)) {
            $this->setOptions($value);
            $this->setType('select');
        } else {
            $this->attributes['value'] = $value;
        }

        return $this;
    }

    /**
     * @param string $alt
     * @return $this
     */
    public function setAlt(string $alt)
    {
        $this->attributes['alt'] = $alt;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->attributes['title'] = $title;
        if("" == $this->getLabel()){
            $this->setLabel($title);
        }
        
        if("" == $this->getPlaceholder()){
            $this->setPlaceholder($title);
        }
        
        return $this;
    }

    /**
     * @param string $placeholder
     * @return $this
     */
    public function setPlaceholder(string $placeholder)
    {
        $this->attributes['placeholder'] = $placeholder;
        if("" == $this->getLabel()){
            $this->setLabel($placeholder);
        }
        
        if("" == $this->getTitle()){
            $this->setTitle($placeholder);
        }
        
        return $this;
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired($required = true)
    {
        $this->attributes['required'] = $required;
        return $this;
    }

    /**
     * 
     * @param string $formId
     * @return $this
     */
    public function setFormTarget(string $formId)
    {
        $this->attributes['form'] = $formId;
        return $this;
    }

    /**
     * @param $maxlength
     * @return $this
     */
    public function setMaxlength($maxlength)
    {
        $this->attributes['maxlength'] = $maxlength;
        return $this;
    }

    /**
     * @param $minlength
     * @return $this
     */
    public function setMinlength($minlength)
    {
        $this->attributes['minlength'] = $minlength;
        return $this;
    }

    /**
     * @param $max
     * @return $this
     */
    public function setMax($max)
    {
        $this->attributes['max'] = $max;
        return $this;
    }

    /**
     * @param $min
     * @return $this
     */
    public function setMin($min)
    {
        $this->attributes['min'] = $min;
        return $this;
    }

    /**
     * @param $rows
     * @return $this
     */
    public function setRows($rows)
    {
        $this->attributes['rows'] = $rows;
        return $this;
    }

    /**
     * @param $cols
     * @return $this
     */
    public function setCols($cols)
    {
        $this->attributes['cols'] = $cols;
        return $this;
    }

    /**
     * @param $width
     * @return $this
     */
    public function setWidth($width)
    {
        $this->attributes['width'] = $width;
        return $this;
    }

    /**
     * @param $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->attributes['height'] = $height;
        return $this;
    }

    /**
     * @param bool $disabled
     * @return $this
     */
    public function setDisabled($disabled = true)
    {
        $this->attributes['disabled'] = true === $disabled;
        return $this;
    }

    /**
     * @param bool $readonly
     * @return $this
     */
    public function setReadonly($readonly = true)
    {
        $this->attributes['readonly'] = true === $readonly;
        return $this;
    }

    /**
     * @param bool $autofocus
     * @return $this
     */
    public function setAutofocus($autofocus = true)
    {
        $this->attributes['autofocus'] = true === $autofocus;
        return $this;
    }

    /**
     * @param bool $autocomplete
     * @return $this
     */
    public function setAutocomplete($autocomplete = true)
    {
        $this->attributes['autocomplete'] = true ===  $autocomplete;
        return $this;
    }

    /**
     * @param bool $selected
     * @return $this
     */
    public function setSelected($selected = true)
    {
        $this->attributes['selected'] = true === $selected;
        return $this;
    }

    /**
     * @param bool $checked
     * @return $this
     */
    public function setChecked($checked = true)
    {
        $this->attributes['checked'] = true === $checked;
        return $this;
    }

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = true)
    {
        $this->attributes['multiple'] = true === $multiple;
        return $this;
    }

    /**
     * @param $step
     * @return $this
     */
    public function setStep($step)
    {
        $this->attributes['step'] = $step;
        return $this;
    }

    /**
     * @param $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->attributes['size'] = $size;
        return $this;
    }

    /**
     * @param $src
     * @return $this
     */
    public function setSrc($src)
    {
        $this->attributes['src'] = $src;
        return $this;
    }

    /**
     * The pattern must always be indicated between delimiters
     * ej: /[A-Z]/ in this case, the delimiters are the bars (/)
     * https://www.php.net/manual/es/regexp.reference.delimiters.php
     * @param string type $pattern
     * @return $this
     */
    public function setPattern($pattern)
    {
        $this->attributes['pattern'] = $pattern;
        return $this;
    }

    /**
     * @param $accept
     * @return $this
     */
    public function setAccept($accept)
    {
        $this->attributes['accept'] = $accept;
        return $this;
    }

    /**
     * @param $wrap
     * @return $this
     */
    public function setWrap($wrap)
    {
        $this->attributes['wrap'] = $wrap;
        return $this;
    }

    /**
     * @param array $constraint
     */
    public function setConstraint(array $constraint)
    {
        $this->constraint = $constraint;
    }
    
    /**
     * @return FormInterface|null
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param FormInterface $form
     * @return $this
     */
    public function setForm(FormInterface $form)
    {
        if(!is_null($form)){
            $this->form = $form;
        }
        
        return $this;
    }

    protected function typeValidate()
    {
        switch ($this->getType()){
            case 'text':
                if(
                    "" != $this->getValue()
                    and !is_string($this->getValue())
                    or is_numeric($this->getValue())
                ){
                    $this->errors[] = 'Texto no válido';
                }
                break;
                
            case 'number':
                if("" != $this->getValue() and !is_numeric($this->getValue())){
                    $this->errors[] = 'Número no válido';
                }
                break;
            
            case 'email':
                if(
                    "" != $this->getValue() 
                    and !filter_var($this->getValue(), FILTER_VALIDATE_EMAIL)
                ){
                    $this->errors[] = 'Email no válido';
                }
                break;
        }
    }

    /**
     * @throws \Exception
     */
    protected function attributeValidate()
    {
        $Attributes = $this->getAttributes();
        foreach ($Attributes as $attribute => $attrValue){
            if("" != $attrValue and !is_array($attrValue)){
                switch ($attribute){
                    case 'required':
                        $msj = ErrorBase::getError($attribute, $attrValue, $this->getLanguage());
                        if('checkbox' == $this->getType() and !$this->getChecked()){
                            $this->errors[] = $msj;
                        } elseif ('radio' == $this->getType() and !isset($_POST[$this->getName()])){
                            $this->errors[] = $msj;
                        } elseif ("" == $this->getValue()){
                            $this->errors[] = $msj;
                        }
                        break;
                        
                    case 'min':
                        if(($this->getValue() < $attrValue)){
                            $this->errors[] = ErrorBase::getError($attribute, $attrValue, $this->getLanguage()); //"El valor debe ser mayor o igual que {$attrValue}";
                        }
                        break;
                    
                    case 'max':
                        if(($this->getValue() > $attrValue)){
                            $this->errors[] = ErrorBase::getError($attribute, $attrValue, $this->getLanguage());
                        }
                        break;
                        
                    case 'minlength':
                        if(strlen($this->getValue()) < $attrValue){
                            $this->errors[] = ErrorBase::getError($attribute, $attrValue, $this->getLanguage());
                        }
                        break;
                        
                    case 'maxlength':
                        if(strlen($this->getValue()) > $attrValue){
                            $this->errors[] = ErrorBase::getError($attribute, $attrValue, $this->getLanguage());
                        }
                        break;
                        
                    case 'pattern':
                        if(!preg_match("/" . $attrValue . "/", $this->getValue())){
                            $this->errors[] = ErrorBase::getError($attribute, $attrValue, $this->getLanguage());
                        }
                        break;
                }
            }
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function validate()
    {
        $this->typeValidate();
        $this->attributeValidate();
        $ret = true;
        if(!empty($this->errors)){
            $ret = false;
            foreach($this->errors as $errorMsj){
                $this->renderErrors .= "\t<span class='help-block' style='color:red'>{$errorMsj}</span>" . PHP_EOL;
            }
        }
        
        return $ret;
    }
}
