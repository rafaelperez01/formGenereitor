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

namespace formGenereitor\base;

use formGenereitor\Field;
use formGenereitor\FieldSet;
use formGenereitor\ui\FieldSetUI;
use formGenereitor\ui\FieldUI;

/**
 * Description of FormBase
 * poner la opcion del bootstrap y show label
 *
 * @author Rafael Pérez.
 */
abstract class FormBase 
{
    protected $readOnly = false;
    protected $attributes = ['fieldsets' => [], 'fields' => [], 'accept' => 'image/*,.pdf', 'enctype' => 'multipart/form-data'];
    
    protected $showBootstrap = false;

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    const METHOD_PUT = 'put';
    const METHOD_DELETE = 'delete';
    
    const METHOD_LIST = [
        self::METHOD_GET,
        self::METHOD_POST,
        self::METHOD_PUT,
        self::METHOD_DELETE,
    ];
    
    protected static $id = 1;

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
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
        return $this;
    }

    public function __construct($fiels = [], $action = "", $method = 'post')
    {
        $this->setFields($fiels);
        $this->setAction($action);
        $this->setMethod($method);
        $formId = 'form_' . self::$id++;
        $this->setId($formId);
        $this->setName($formId);
    }

    public function setReadOnly($readOnly)
    {
        $this->readOnly = true === $readOnly;
        return $this;
    }
    
    /**
     * Configura una lista de campos como campos de sólo lectura
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsReadOnly(array $fieldIdList)
    {
        if(!empty($fieldIdList)){
            foreach ($fieldIdList as $id){
                if($f = $this->getFieldById($id)){
                    $f->setReadonly();
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Configura una lista de campos como campos desabilitados
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsDisableds(array $fieldIdList)
    {
        if(!empty($fieldIdList)){
            foreach ($fieldIdList as $id){
                if($f = $this->getFieldById($id)){
                    $f->setDisabled();
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Configura una lista de campos como campos ocultos
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsHidden(array $fieldIdList)
    {
        if(!empty($fieldIdList)){
            foreach ($fieldIdList as $id){
                if($f = $this->getFieldById($id)){
                    $f->setType('hidden')->showLabel(false);
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Configura una lista de campos como campos de tipo textArea
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsTextArea(array $fieldIdList)
    {
        if(!empty($fieldIdList)){
            foreach ($fieldIdList as $id){
                if($f = $this->getFieldById($id)){
                    $f->setType('textarea');
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Configura las opciones para un campo (select, list, optgroup) 
     * @param string $fieldId
     * @param array $options
     * @return $this
     */
    public function setFieldOptions($fieldId, array $options)
    {
        if($f = $this->getFieldById($fieldId) and !empty($options)){
            $f->setOptions($options);
        }
        
        return $this;
    }

    /**
     * Indica si se debe mostrar los estilos bootstrap
     * @param boolean $show
     * @return $this
     */
    public function showBootstrap($show = true)
    {
        $this->showBootstrap = true === $show;
        return $this;
    }
    
    public function getShowBootstrap()
    {
        return $this->showBootstrap;
    }


    /**
     * Añade o sustituye un campo en la lista de campos
     * @param FieldUI $field
     * @return $this
     */
    public function addField(FieldUI $field)
    {
        $field->setForm($this);
        $this->attributes['fields'][$field->getId()] = $field;
        return $this;
    }
    
    /**
     * Añade una lista de campos (los items tienen que ser objetos de tipo FieldUI)
     * @param array <FieldUI> $fieldList
     * @return $this
     */
    public function addFieldList(array $fieldList)
    {
        if(!empty($fieldList)){
            foreach ($fieldList as $field){
                $this->addField($field);                
            }
        }
        
        return $this;
    }
    
    /**
     * Puede recivir un array con el par clave-valor para crear y añadir campos
     * a partir de este, o puede recivir un array de objetos de tipo FieldUI y
     * los añade a la lista de campos
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {

        foreach ($fields as $name => $value){
            if($value instanceof FieldUI){
                $f = $value;
            } else {
                $f = new Field($name, $value);
            }

            $f->setForm($this);
            $this->attributes['fields'][$f->getId()] = $f;
        }

        return $this;
    }

    /**
     * Obtiene un campo por su id
     * @param string $id
     * @return FieldUI
     */
    public function getFieldById($id)
    {
        $ret = null;
        if(isset($this->attributes['fields'][$id])){
            $ret = $this->attributes['fields'][$id];
        }
        
        return $ret;
    }
    
    /**
     * Añade o sustituye un fieldset en la lista de fieldsets
     * @param FieldSetUI $fieldset
     * @return $this
     */
    public function addFieldset(FieldSetUI $fieldset)
    {
        $fieldset->setForm($this);
        $this->attributes['fieldsets'][$fieldset->getId()] = $fieldset;
        return $this;
    }
    
    /**
     * Añade una lista de fieldset (los items tienen que ser de tipo FieldSetUI)
     * @param array <FieldSetUI> $fieldsetList
     * @return $this
     */
    public function addFieldsetList(array $fieldsetList)
    {
        if(!empty($fieldsetList)){
            foreach ($fieldsetList as $fieldset){
                $this->addFieldset($fieldset);
            }
        }
        
        return $this;
    }
    
    /**
     * Puede recivir un array con el par clave-valor para crear y añadir fieldset
     * a partir de este, o puede recivir un array de objetos de tipo FieldSetUI y
     * los añade a la lista de fieldset
     * @param array $fieldsets
     * @return $this
     */
    public function setFieldsets(array $fieldsets)
    {
        foreach ($fieldsets as $key => $fieldSet){
            if($fieldSet instanceof FieldSetUI){
                $f = $fieldSet;
            } else {
                $f = new FieldSet($fieldSet);
            }
            
            $f->setForm($this);
            $this->attributes['fieldsets'][$f->getId()] = $f;
        }

        return $this;
    }

    /**
     * Obtiene un fieldset por su id
     * @param string | int $id
     * @return null | FieldSetUI
     */
    public function getFieldsetById($id)
    {
        $ret = null;
        if(isset($this->attributes['fieldsets'][$id])){
            $ret = $this->attributes['fieldsets'][$id];
        }
        
        return $ret;
    }

    /**
     * Renderiza el formulario completo (fieldsets y campos)
     * @return string
     */
    public function render()
    {
        $ret = "<form {$this->renderAttributes()}>\n";
        $ret .= $this->renderFieldSets();
        $ret .= $this->renderFields();
        $ret .= "</form>\n";

        return $ret;
    }

    /**
     * 
     * @return string
     */
    protected function renderAttributes()
    {
        $ret = [];
        foreach ($this->attributes as $attribute => $value){
            if("" != $value and !is_array($value)){
                $ret[] = "$attribute='$value'";
            }
        }

        return implode(" ", $ret);
    }

    /**
     * 
     * @return string
     */
    protected function renderFieldSets()
    {
        $ret = "";
        if(!empty($this->getFieldsets())){
            foreach($this->getFieldsets() as $fieldset){
                if($this->readOnly){
                    $fieldset->setReadOnly();
                }
                $ret .= $fieldset->render();
            }
        }

        return $ret;
    }

    /**
     * 
     * @return string
     */
    protected function renderFields()
    {
        $ret = "";
        if(!empty($this->getFields())){
            
            foreach($this->getFields() as $field){
                /**
                 * @var FieldBase $field
                 */
                if($this->readOnly){
                    $field->setReadOnly();
                }                
                $ret .= $field->render();
            }
        }

        return $ret;
    }

    public function __toString()
    {
        return $this->render();
    }

    /**
     * Retorna el formulario convertido a json
     * @return string JSON
     */
    public function toJson()
    {
        $paramList = [];
        foreach($this->attributes as $attributes => $value){
            if("" != $value and !is_array($value)){
                $paramList[$attributes] = $value;
            }
        }

        $fieldsetList = [];
        if(!empty($this->getFieldsets())){
            foreach($this->getFieldsets() as $fieldset){
                $fieldsetList[] = $fieldset->toArray();
            }
        }
        $paramList['fieldsets'] = $fieldsetList;

        $fieldList = [];
        if(!empty($this->getFields())){
            foreach($this->getFields() as $field){
                $fieldList[] = $field->toArray();
            }
        }
        $paramList['fields'] = $fieldList;

        return json_encode($paramList);
    }

    /**
     * Retorna el formulario convertido en array
     * @return array
     */
    public function toArray(): array {
        return json_decode($this->toJson(), true);
    }
    
    /**
     * 
     * @return string
     */
    public function start()
    {
        $atributesPrint = [];
        foreach ($this->attributes as $attribute => $value){
            if("" != $value and !is_array($value)){
                $atributesPrint[] = "$attribute='$value'";
            }
        }
        
        $ret = "<form ". implode(" ", $atributesPrint) .">\n";
        
        return $ret;
    }
    
    /**
     * 
     * @return string
     */
    public function end()
    {       
        $ret = "</form>\n";
        return $ret;
    }

    /**
     * @param $name
     * @param string $value
     * @param string $type
     * @return Field
     */
    public function createField($name, $value = '', $type = '')
    {
        $field = new Field($name, $value, $type);
        $this->addField($field);
        $field->setForm($this);
        $field->setLanguage($this->getLanguage());
        return $field;
    }

    public function getId()
    {
        return @$this->attributes['id'];
    }

    public function getClass()
    {
        return @$this->attributes['class'];
    }

    public function getAction()
    {
        return @$this->attributes['action'];
    }

    public function getMethod()
    {
        return @$this->attributes['method'];
    }

    public function getName()
    {
        return @$this->attributes['name'];
    }

    public function getCaption()
    {
        return @$this->attributes['caption'];
    }

    public function getFieldsets()
    {
        return $this->attributes['fieldsets'];
    }

    public function getFields()
    {
        return $this->attributes['fields'];
    }

    public function getAutocomplete()
    {
        return @$this->attributes['autocomplete'];
    }

    public function getNovalidate()
    {
        return @$this->attributes['novalidate'];
    }

    public function getEnctype()
    {
        return @$this->attributes['enctype'];
    }

    public function getTarget()
    {
        return @$this->attributes['target'];
    }

    public function getAccept()
    {
        return @$this->attributes['accept'];
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function setClass($class)
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    public function setAction($action)
    {
        $this->attributes['action'] = $action;
        return $this;
    }

    public function setName($name)
    {
        $this->attributes['name'] = $name;
        return $this;
    }

    public function setCaption($caption)
    {
        $this->attributes['caption'] = $caption;
        return $this;
    }

    public function setAutocomplete($autocomplete)
    {
        $this->attributes['autocomplete'] = $autocomplete;
        return $this;
    }

    public function setNovalidate($novalidate)
    {
        $this->attributes['novalidate'] = $novalidate;
        return $this;
    }

    public function setEnctype($enctype)
    {
        $this->attributes['enctype'] = $enctype;
        return $this;
    }

    public function setTarget($target)
    {
        $this->attributes['target'] = $target;
        return $this;
    }

    public function setAccept($accept)
    {
        $this->attributes['accept'] = $accept;
        return $this;
    }

    public function setMethod($method)
    {
        $method = strtolower(trim($method));
        $validMethod = in_array($method, self::METHOD_LIST) ? $method : self::METHOD_POST;
        $this->attributes['method'] = $validMethod;
        return $this;
    }
    
    /**
     * Valida si los valores de los campos son correctos (tipo, longitud y formato)
     * @return boolean
     */
    public function validate()
    {
        $ret = true;
        $this->loadDataFromRequest();
        foreach ($this->getFields() as $field){
            /** @var FieldBase $field  */
            $ret *= $field->validate();
        }
        
        return $ret;
    }
    
    /**
     * Rellena los valores de los campos con los datos que llegan desde los metodos post y get
     * @return $this
     */
    public function loadDataFromRequest()
    {
        switch ($this->getMethod()){
            case 'get':
                $this->loadDataFromGet();
                break;
            case 'post':
                $this->loadDataFromPost();
                break;
        }
        
        return $this;
    }
    
    protected function loadDataFromGet()
    {
        foreach ($this->getFields() as $field){
            if($value = filter_input(INPUT_GET, $field->getName())){
                $field->setValue($value);
            }
        }
        
        return $this;
    }
    
    protected function loadDataFromPost()
    {
        foreach ($this->getFields() as $field){
            /**
             * @var FieldBase $field
             */
            $fieldName = trim($field->getName(), "[]");
            switch($field->getType()){
                case 'radio':
                    $value = filter_input(INPUT_POST, $fieldName);
                    $field->setChecked($value == $field->getValue());
                    break;

                case 'checkbox':
                    $value = filter_input(INPUT_POST, $fieldName, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                    if(is_array($value)){
                        $field->setChecked(in_array($field->getValue(), $value));
                    } else {
                        $value = filter_input(INPUT_POST, $fieldName);
                        $field->setChecked($value == $field->getValue());
                    }
                    break;

                default:
                    $value = filter_input(INPUT_POST, $fieldName);
                    $field->setValue($value);
                    break;
            }
        }
        
        return $this;
    }
}
