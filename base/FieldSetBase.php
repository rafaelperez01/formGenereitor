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

/**
 * Description of FieldSetBase
 *
 * @author Rafael Pérez.
 */
abstract class FieldSetBase {
    
    protected $attributes = ['id' => '', 'class' => '', 'style' => '', 'fields' => [],];
    protected $legend = "";
    protected $readOnly = false;
    protected $showFieldLabel = false;
    protected $showFieldBootstrap = false;

    public function __construct($legend = "", $fields = [])
    {
        $this->setLegend($legend);
        $this->setFields($fields);
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
    
    public function render()
    {
        $ret = "<fieldset {$this->renderAttributes()}>\n";
        if("" != $this->getLegend()){
            $ret .= "\t<legend>{$this->getLegend()}</legend>\n";
        }
        
        foreach ($this->getFields() as $key => $field){
            if($field instanceof \formGenereitor\ui\FieldUI){
                $f = $field;
            } else {
                $f = new \formGenereitor\Field($key, $field);
            }
            
            $f->showLabel($this->showFieldLabel)
                ->setReadonly($this->getReadOnly())
                ->showBootstrap($this->showFieldBootstrap);
            
            $ret .= $f->render();
        }
        
        $ret .= "</fiendset>";
        
        return $ret;
    }
    
    public function addField($name, $value = "", $type = "")
    {
        $f = new \formGenereitor\Field($name, $value, $type);
        $this->attributes['fields'][] = $f;
        return $this;
    }
    
    public function addFieldObj(\formGenereitor\ui\FieldUI $field)
    {
        $this->attributes['fields'][] = $field;
        return $this;
    }
    
    public function __toString() 
    {
        return $this->render();
    }
    
    public function toJson()
    {
        $ret['legend'] = $this->getLegend();
        $ret += array_filter($this->getAttributes());
        $ret['fields'] = [];
        
        foreach($this->getFields() as $field){
            $ret['fields'][] = $field->toArray();
        }
        
        return json_encode($ret);
    }
    
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }
    
    
    public function getAttributes()
    {
        return $this->attributes;
    }


    public function getId()
    {
        return $this->attributes['id'];
    }
    
    public function getClass()
    {
        return $this->attributes['class'];
    }
    
    public function getFields()
    {
        return $this->attributes['fields'];
    }
    
    public function setId($id)
    {
        $this->attributes['id'] = $id;
        return $this;
    }
    
    public function getStyle()
    {
        return $this->attributes['style'];
    }
    
    public function setStyle($style)
    {
        $this->attributes['style'] = str_replace('"', "'", $style);
        return $this;
    }
    
    public function setClass($class)
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    public function setFields(array $fields)
    {
        foreach ($fields as $key => $field){
            if($field instanceof \formGenereitor\ui\FieldUI){
                $f = $field;
            } else {
                $f = new \formGenereitor\Field($key, $field);
            }
            
            $this->attributes['fields'][] = $f;
        }
        
        return $this;
    }
    
    function getLegend() {
        return $this->legend;
    }

    function getReadOnly() {
        return $this->readOnly;
    }

    function setLegend($legend) {
        $this->legend = $legend;
        return $this;
    }

    function setReadOnly($readOnly) {
        $this->readOnly = true === $readOnly;
        return $this;
    }
    
    function showFieldLabel($show = true) 
    {
        $this->showFieldLabel = true === $show;
        return $this;
    }

    function showFieldBootstrap($show = true) {
        $this->showFieldBootstrap = true === $show;
        return $this;
    }
    
    

}
