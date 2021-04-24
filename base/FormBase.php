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
    protected $attributes = ['id' => '', 'class' => '', 'action' => '', 'method' => '', 'name' => '', 'caption' => '', 'fieldsets' => [], 'fields' => [], 'autocomplete' => '', 'novalidate' => '', 'enctype' => '', 'target' => '', 'accept' => '', 'enctype' => ''];
    protected $errors = [];
    
    public $showBootstrap = false;

    const METHOD_LIST = ['get', 'post'];

    public function __construct($fiels = [], $action = "", $method = 'post')
    {
        $this->setFields($fiels);
        $this->setAction($action);
        $this->setMethod($method);
    }

    public function setReadOnly($readOnly)
    {
        $this->readOnly = true === $readOnly;
        return $this;
    }
    
    public function showBootstrap($show = true)
    {
        $this->showBootstrap = true === $show;
        return $this;
    }   
    
    public function addField(FieldUI $field)
    {
        $this->attributes['fields'][$field->getName()] = $field;
        return $this;
    }
    
    public function getFieldByName($name)
    {
        $ret = null;
        if(isset($this->attributes['fields'][$name])){
            $ret = $this->attributes['fields'][$name];
        }
        
        return $ret;
    }

    public function render()
    {
        $ret = "<form {$this->renderAttributes()}>\n";
        $ret .= $this->renderFieldSets();
        $ret .= $this->renderFields();
        $ret .= "</form>\n";

        return $ret;
    }

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

    protected function renderFields()
    {
        $ret = "";
        if(!empty($this->getFields())){
            foreach($this->getFields() as $field){
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

    public function toArray(): array {
        return json_decode($this->toJson(), true);
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function getClass()
    {
        return $this->attributes['class'];
    }

    public function getAction()
    {
        return $this->attributes['action'];
    }

    public function getMethod()
    {
        return $this->attributes['method'];
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function getCaption()
    {
        return $this->attributes['caption'];
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
        return $this->attributes['autocomplete'];
    }

    public function getNovalidate()
    {
        return $this->attributes['novalidate'];
    }

    public function getEnctype()
    {
        return $this->attributes['enctype'];
    }

    public function getTarget()
    {
        return $this->attributes['target'];
    }

    public function getAccept()
    {
        return $this->attributes['accept'];
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

    public function setFieldsets(array $fieldsets)
    {
        foreach ($fieldsets as $key => $fieldSet){
            if($fieldSet instanceof FieldSetUI){
                $f = $fieldSet;
            } else {
                $f = new FieldSet($fieldSet);
                $f->setId('fielset_' . $key);
            }

            $this->attributes['fieldsets'][] = $f;
        }

        return $this;
    }

    public function setFields(array $fields)
    {

        foreach ($fields as $key => $field){
            if($field instanceof FieldUI){
                $f = $field;
            } else {
                $f = new Field($key, $field);
            }

            $this->attributes['fields'][] = $f;
        }

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
        $method = strtolower($method);
        $validMethod = isset(self::METHOD_LIST[$method]) ? $method : 'post';
        $this->attributes['method'] = $validMethod;
        return $this;
    }
    
    public function createFromObj($model)
    {
        $fields = 54;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
    
    public function validate()
    {
        return empty($this->getErrors());
    }
}
