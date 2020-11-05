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
interface FormUI
{
    public function getFieldByParamValue($paramValue, $param = 'name');

    public function render();

    public function toJson();

    public function toArray();

    public function getId();

    public function getClass();

    public function getAction();

    public function getMethod();

    public function getName();

    public function getCaption();

    public function getFieldsets();

    public function getFields();

    public function getAutocomplete();

    public function getNovalidate();

    public function getEnctype();

    public function getTarget();

    public function getAccept();

    public function setId($id);

    public function setClass($class);

    public function setAction($action);

    public function setName($name);

    public function setCaption($caption);

    public function setFieldsets(array $fieldsets);

    public function setFields(array $fields);

    public function setAutocomplete($autocomplete);

    public function setNovalidate($novalidate);

    public function setEnctype($enctype);

    public function setTarget($target);

    public function setAccept($accept);

    public function setMethod($method);
}
