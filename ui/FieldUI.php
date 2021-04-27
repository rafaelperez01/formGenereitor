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


namespace formGenereitor\ui;

/**
 *
 * @author Rafael Pérez.
 */
interface FieldUI 
{
    public function get(string $attrName);
    
    public function set(string $attrName, $value);
    
    public function setType(string $type);
    
    public function render();
    
    public function setOptions(array $options, $selected = null);
    
    public function showLabel($show = true);
    
    public function showBootstrap($show = true);
    
    public function toJson();
    
    public function toArray(): array;

    public function getLabel();
    
    public function setLabel($label);
    
    public function getLabelId();
    
    public function setLabelId(string $id);
    
    public function getLabelFor();
    
    public function setLabelFor(string $for);
    
    public function getLabelForm();
    
    public function setLabelForm(string $form);
    
    public function getLabelClass();
    
    public function setLabelClass(string $class);

    public function getLabelAccesskey();
    
    public function setLabelAccesskey(string $accesskey);

    public function getAttributes();
    
    public function getLabelAttributes();

    public function getName();

    public function getType();
    
    public function getId();

    public function getClass();

    public function getValue();

    public function getAlt();

    public function getTitle();

    public function getPlaceholder();

    public function getRequired();

    public function getForm();

    public function getMaxlength();
    
    public function getMinlength();

    public function getMax();
    
    public function getMin();
    
    public function getRows();

    public function getCols();
    
    public function getWidth();

    public function getHeight();

    public function getDisabled();

    public function getReadonly();

    public function getAutofocus();

    public function getAutocomplete();

    public function getSelected();
    
    public function getChecked();

    public function getMultiple();

    public function getStep();

    public function getSize();

    public function getSrc();

    public function getPattern();

    public function getAccept();
    
    public function getWrap();
    
    public function setName($name);

    public function setId($id);

    public function setClass($class);

    public function setValue($value);

    public function setAlt($alt);

    public function setTitle($title);

    public function setPlaceholder($placeholder);
    
    public function setRequired($required);

    public function setForm(FormUI $form);

    public function setMaxlength($maxlength);

    public function setMinlength($minlength);

    public function setMax($max);

    public function setMin($min);

    public function setRows($rows);
    
    public function setCols($cols);

    public function setWidth($width);

    public function setHeight($height);

    public function setDisabled($disabled = true);

    public function setReadonly($readonly = true);

    public function setAutofocus($autofocus = true);
    
    public function setAutocomplete($autocomplete = true);

    public function setSelected($selected = true);
    
    public function setChecked($checked = true);

    public function setMultiple($multiple = true);

    public function setStep($step);

    public function setSize($size);
    
    public function setSrc($src);

    public function setPattern($pattern);

    public function setAccept($accept);
    
    public function setWrap($wrap);
}
