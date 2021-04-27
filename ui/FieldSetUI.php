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

use formGenereitor\ui\{FieldUI, FormUI};

/**
 *
 * @author Rafael Pérez.
 */
interface FieldSetUI 
{    
    public function get(string $attrName);
    
    public function set(string $attrName, $value);
    
    public function render();
    
    public function addField($name, $value = "", $type = "");
    
    public function addFieldObj(FieldUI $field);
    
    public function toJson();
    
    public function toArray();
    
    public function getAttributes();

    public function getId();
    
    public function getClass();
    
    public function getFields();
    
    public function setId($id);
    
    public function getStyle();
    
    public function setStyle($style);
    
    public function setClass($class);

    public function setFields(array $fields);
    
    public function getLegend();

    public function getReadOnly();

    public function setLegend($legend);

    public function setReadOnly($readOnly);
    
    public function showFieldLabel($show = true);

    public function showFieldBootstrap($show = true);
    
    public function setForm(FormUI $form);
}
