<?php

/*
 * Copyright 2020 Rafael Pérez.
 *
 * Software protegido por la propiedad intelectual.
 * Queda prohibido copiar, modificar, fusionar, publicar, distribuir, sublicenciar y / o vender
 * copias no autorizadas del software
 *
 * El aviso de copyright anterior y este aviso de permiso se incluirán en todas las copias o 
 * porciones sustanciales del software.
 */


/**
 * TODO: 
 * tener en cuenta al momento de subir un archivo o imagen, hacer que el formulario acepte el formato
 * 
 * hacer el primer campo que siempre haga autofocus
 * 
 * hacer una clase manejador de formulario, que valide, mueva, recorte las imagenes, que valide los formularios y muestres mensajes de error, que indique cuales campos serán tipo select, etc que tambien indique si el formulario tiene estilos bootstrap, que filtre/escape/limpie/valide los campos de acuerdo a tu tipo
 * 
 * usar interfaces para inyectar las dependencias, es decir, que la clase FieldSetBase tiene que recibir por parametro la interface FieldBase y que la clase FormBase tiene que recibir por parametro la interface FieldSetBase y FieldBase 
 * 
 * 
 */

namespace formGenereitor\base;

/**
 * Description of FieldBase
 *
 * @author Rafael Pérez.
 */
abstract class FieldBase 
{    
    /**
     * En la siguiente lista NO estan incluidos todos los atributos aceptados por un 
     * campo, pero si los más usados.
     * Para saber todos los atributos permitidos visitar:
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes
     * @var type 
     */
    protected $attributes = ['name' => '', 'type' => 'text', 'id' => '', 'class' => '', 'value' => '', 'style' => '', 'alt' => '', 'title' => '', 'placeholder' => '', 'required' => '', 'form' => '', 'maxlength' => '', 'minlength' => '', 'max' => '', 'min' => '', 'rows' => '', 'cols' => '', 'wrap' => '', 'width' => '', 'height' => '', 'disabled' => '', 'readonly' => '', 'autofocus' => '', 'autocomplete' => '', 'selected' => '', 'multiple' => '', 'step' => '', 'size' => '',  'src' => '', 'pattern' => '', 'accept' => '',];
    
    const FIELD_TYPES_LIST = ['submit', 'tel', 'text', 'textarea', 'select', 'button', 'checkbox', 'color', 'date', 'datetime-local', 'email', 'file', 'hidden', 'image', 'month', 'number', 'password', 'radio', 'range', 'reset', 'search',  'time', 'url', 'week',];
    // Options for Label
    protected $showLabel = false;
    protected $labelContent = "";
    protected $labelAttributes = ['id' => '', 'class' => '', 'for' => '', 'form' => '', 'accesskey' => ''];
    
    // Options for field type select
    protected $selectOptions = [];
    protected $allowedAttrForSelect = ['name', 'id', 'class', 'required', 'readonly', 'form'];
    protected $optionSelected = '';
    
    // Options for field type textarea
    protected $allowedAttrForTextarea = ['name', 'id', 'cols', 'rows', 'class', 'maxlength', 'placeholder', 'required', 'wrap', 'readonly', 'form'];

    protected $showBootstrap = false;

    public function __construct(string $name, $value = null, string $type = 'text', $showBootstrap = false)
    {
        $this->setName($name);
        $this->setValue($value);
        $this->setType($type);
        $this->setPlaceholder($name);
        $this->setTitle($name);
        $this->setId($name);
        $this->setLabelFor($name);
        $this->showBootstrap($showBootstrap);
    }
    
    /**
     * Obtiene el valor del atributo solicitado (si existe dicho atributo)
     * 
     * @param string $attrName
     * @return string
     */
    public function get(string $attrName)
    {
        $attrName = strtolower($attrName);
        $ret = @$this->getAttributes()[$attrName];
        return $ret;
    }
    
    /**
     * 
     * @param string $attrName
     * @param type $value
     * @return $this
     */
    public function set(string $attrName, $value)
    {
        $attrName = strtolower($attrName);
        if(isset($this->attributes[$attrName])){
            $this->attributes[$attrName] = $value;
        }
        
        return $this;
    }
    
    
    /**
     * Setea el tipo de campo, validando que el tipo sea uno permitido dentro 
     * de la lista FIELD_TYPES_LIST
     * 
     * @param string $type
     * @return Field
     */
    public function setType(string $type)
    {        
        $type = strtolower($type);
        $this->attributes['type'] = in_array($type, self::FIELD_TYPES_LIST) ? $type : 'text';
        
        return $this;        
    }    
    
    public function render()
    {
        $ret = '';
        
        if($this->showBootstrap){
            $this->setClassBootstrap();
        }
        
        if($this->showLabel){
            $ret .= $this->renderLabel();
        }
        
        switch ($this->getType()) {
            case 'select': $ret .= $this->renderSelect();
                break;
            case 'textarea': $ret .= $this->renderTextArea();
                break;
            case 'date': $ret .= $this->renderDate();
                break;
            default: $ret .= $this->renderDefault();
                break;
        }
        
        if($this->showBootstrap){
            $ret = "<div class='form-group'>\n{$ret}</div>\n";
        }
        
        return $ret;
    }
    
    public function __toString() {
        return $this->render();
    }
    
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
    
    protected function getTextAreaAttr()
    {
        $ret = [];
        $attrList = $this->getAttributes();
        foreach ($this->allowedAttrForTextarea as $attr){
            $attrValue = $attrList[$attr];
            if(!is_null($attrValue)){
                $ret[$attr] = $attrValue;
            }
        }
        
        return $ret;
    }
    
    protected function getSelectAttr()
    {
        $ret = [];
        $attrList = $this->getAttributes();
        foreach ($this->allowedAttrForSelect as $attr){
            $attrValue = $attrList[$attr];
            if(!is_null($attrValue)){
                $ret[$attr] = $attrValue;
            }
        }
        
        return $ret;
    }

    public function renderDefault()
    {
        $attr = $this->renderAttributes();
        $ret = "\t<input {$attr}/>\n";
        return $ret;
    }
    
    public function renderSelect()
    {
        $attr = $this->renderAttributes();
        $ret = "\t<select {$attr}>\n";
        $ret .= $this->renderOptions();
        $ret .= "\t</select>\n";
        return $ret;
    }
    
    protected function renderOptions()
    {
        $ret = "";
        $optionSelected = $this->getOptionSelected() ?: $this->getValue();
        $options = $this->getOptions() ?: $this->getValue();
        if(is_array($options)){
            foreach ($options as $value => $label){
                $selected = $optionSelected == $value ? "selected" : '';
                $ret .= "\t\t<option value='{$value}' {$selected}>{$label}</option>\n";
            }
        }
        
        
        return $ret;
    }
    
    protected function renderTextArea()
    {
        $ret = "\t<textarea " . $this->renderAttributes() . ">\n";
        $ret .= $this->getValue() ."\n";
        $ret .= "\t</textarea>\n";
        return $ret;
    }
    
    protected function renderDate()
    {
        if("" != $this->getValue()){
            $value = date('Y-m-d', strtotime($this->getValue()));
            $this->setValue($value);
        }
        
        return "\t<input " . $this->renderAttributes() . "/>\n";
    }

    protected function getOptionSelected()
    {
        return $this->optionSelected;
    }
    
    public function getOptions()
    {
        return $this->selectOptions;
    }


    public function setOptions(array $options, $selected = null)
    {
        $this->selectOptions = $options;
        $this->setOptionSelected($selected);
        return $this;
    }
    
    protected function setOptionSelected($selected)
    {
        if(!is_null($selected)){
            $this->optionSelected = $selected;
        }
        return $this;
    }
    
    public function showLabel($show = true)
    {
        $this->showLabel = true === $show;
        return $this;
    }
    
    public function showBootstrap($show = true)
    {
        $this->showBootstrap = true === $show;
        return $this;
    }


    public function renderLabel()
    {        
        $renderAttributes = [];
        foreach ($this->labelAttributes as $attribute => $value){
            if("" != $value){
                $renderAttributes[] = "$attribute='$value'";
            }
        }
        
        $attr =  implode(" ", $renderAttributes);
        $ret = "\t<label {$attr}>";
        $ret .= $this->getLabel();
        $ret .= " &nbsp </label>\n";

        return $ret;      
    }
    
    public function toJson()
    {
        $ret = array_filter($this->getAttributes());
        if($this->showLabel){
            $ret['label'] = array_filter($this->getLabelAttributes());
        }
        
        return json_encode($ret);
    }
    
    public function toArray(): array
    {
        return json_decode($this->toJson(), true);
    }


    public function getLabel()
    {
        $ret = ("" != $this->labelContent) ? $this->labelContent : $this->getTitle();
        return $ret;
    }
    
    public function setLabel($label)
    {
        $this->labelContent = $label;
        return $this;
    }
    
    public function getLabelId()
    {
        return $this->labelAttributes['id'];
    }
    
    public function setLabelId(string $id)
    {
        $id = str_replace(" ", "_", $id);
        $this->labelAttributes['id'] = $id;
        return $this;
    }
    
    public function getLabelFor()
    {
        return $this->labelAttributes['for'];
    }
    
    public function setLabelFor(string $for)
    {
        $for = str_replace(" ", "_", $for);
        $this->labelAttributes['for'] = $for;
        return $this;
    }
    
    public function getLabelClass()
    {
        return $this->labelAttributes['class'];
    }
    
    public function setLabelClass(string $class)
    {
        $this->labelAttributes['class'] = $class;
        return $this;
    }
    
    public function getLabelForm()
    {
        return $this->labelAttributes['form'];
    }
    
    public function setLabelForm(string $form)
    {
        $this->labelAttributes['form'] = $form;
        return $this;
    }

    public function getLabelAccesskey()
    {
        return $this->labelAttributes['accesskey'];
    }
    
    public function setLabelAccesskey(string $accesskey)
    {
        $this->labelAttributes['accesskey'] = $accesskey;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
    
    public function getLabelAttributes()
    {
        return $this->labelAttributes;
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function getType()
    {
        return $this->attributes['type'];
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function getClass()
    {
        return $this->attributes['class'];
    }

    public function getValue()
    {
        return $this->attributes['value'];
    }

    public function getAlt()
    {
        return $this->attributes['alt'];
    }

    public function getTitle()
    {
        return $this->attributes['title'];
    }

    public function getPlaceholder()
    {
        return $this->attributes['placeholder'];
    }

    public function getRequired()
    {
        return $this->attributes['required'];
    }

    public function getForm()
    {
        return $this->attributes['form'];
    }

    public function getMaxlength()
    {
        return $this->attributes['maxlength'];
    }

    public function getMinlength()
    {
        return $this->attributes['minlength'];
    }

    public function getMax()
    {
        return $this->attributes['max'];
    }

    public function getMin()
    {
        return $this->attributes['min'];
    }

    public function getRows()
    {
        return $this->attributes['rows'];
    }

    public function getCols()
    {
        return $this->attributes['cols'];
    }

    public function getWidth()
    {
        return $this->attributes['width'];
    }

    public function getHeight()
    {
        return $this->attributes['height'];
    }

    public function getDisabled()
    {
        return $this->attributes['disabled'];
    }

    public function getReadonly()
    {
        return $this->attributes['readonly'];
    }

    public function getAutofocus()
    {
        return $this->attributes['autofocus'];
    }

    public function getAutocomplete()
    {
        return $this->attributes['autocomplete'];
    }

    public function getSelected()
    {
        return $this->attributes['selected'];
    }

    public function getMultiple()
    {
        return $this->attributes['multiple'];
    }

    public function getStep()
    {
        return $this->attributes['step'];
    }

    public function getSize()
    {
        return $this->attributes['size'];
    }

    public function getSrc()
    {
        return $this->attributes['src'];
    }

    public function getPattern()
    {
        return $this->attributes['pattern'];
    }

    public function getAccept()
    {
        return $this->attributes['accept'];
    }
    
    public function getWrap()
    {
        return $this->attributes['wrap'];
    }
    
    public function getStyle()
    {
        return $this->attributes['style'];
    }
    
    public function setStyle($style)
    {
        $this->attributes['style'] = $style;
        return $this;
    }

    public function setName($name)
    {
        $name = str_replace(" ", "_", $name);
        $this->attributes['name'] = $name;
        return $this;
    }

    public function setId($id)
    {
        $id = str_replace(" ", "_", $id);
        $this->attributes['id'] = $id;
        $this->setLabelFor($id);
        return $this;
    }
    
    public function setClassBootstrap()
    {
        $class = $this->getClass();
        switch ($this->getType()){
            case 'radio':
            case 'checkbox': $class .= " form-check-input";
                break;
            case 'range': $class .= " form-control-range";
                break;
            case 'file': $class .= " form-control-file";
                break;
            default : $class .= " form-control";
                break;
        }
        
        $this->setClass($class);
        return $this;
    }

    public function setClass($class)
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    public function setValue($value)
    {
        $this->attributes['value'] = $value;
        return $this;
    }

    public function setAlt($alt)
    {
        $this->attributes['alt'] = $alt;
        return $this;
    }

    public function setTitle($title)
    {
        $this->attributes['title'] = $title;
        return $this;
    }

    public function setPlaceholder($placeholder)
    {
        $this->attributes['placeholder'] = $placeholder;
        return $this;
    }

    public function setRequired($required)
    {
        $this->attributes['required'] = $required;
        return $this;
    }

    public function setForm($form)
    {
        $this->attributes['form'] = $form;
        return $this;
    }

    public function setMaxlength($maxlength)
    {
        $this->attributes['maxlength'] = $maxlength;
        return $this;
    }

    public function setMinlength($minlength)
    {
        $this->attributes['minlength'] = $minlength;
        return $this;
    }

    public function setMax($max)
    {
        $this->attributes['max'] = $max;
        return $this;
    }

    public function setMin($min)
    {
        $this->attributes['min'] = $min;
        return $this;
    }

    public function setRows($rows)
    {
        $this->attributes['rows'] = $rows;
        return $this;
    }

    public function setCols($cols)
    {
        $this->attributes['cols'] = $cols;
        return $this;
    }

    public function setWidth($width)
    {
        $this->attributes['width'] = $width;
        return $this;
    }

    public function setHeight($height)
    {
        $this->attributes['height'] = $height;
        return $this;
    }

    public function setDisabled($disabled = true)
    {
        $this->attributes['disabled'] = true === $disabled;
        return $this;
    }

    public function setReadonly($readonly = true)
    {
        $this->attributes['readonly'] = true === $readonly;
        return $this;
    }

    public function setAutofocus($autofocus = true)
    {
        $this->attributes['autofocus'] = true === $autofocus;
        return $this;
    }

    public function setAutocomplete($autocomplete = true)
    {
        $this->attributes['autocomplete'] = true ===  $autocomplete;
        return $this;
    }

    public function setSelected($selected = true)
    {
        $this->attributes['selected'] = true === $selected;
        return $this;
    }

    public function setMultiple($multiple = true)
    {
        $this->attributes['multiple'] = true === $multiple;
        return $this;
    }

    public function setStep($step)
    {
        $this->attributes['step'] = $step;
        return $this;
    }

    public function setSize($size)
    {
        $this->attributes['size'] = $size;
        return $this;
    }

    public function setSrc($src)
    {
        $this->attributes['src'] = $src;
        return $this;
    }

    public function setPattern($pattern)
    {
        $this->attributes['pattern'] = $pattern;
        return $this;
    }

    public function setAccept($accept)
    {
        $this->attributes['accept'] = $accept;
        return $this;
    }
    
    public function setWrap($wrap)
    {
        $this->attributes['wrap'] = $wrap;
        return $this;
    }
}
