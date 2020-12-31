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
require_once 'Field.php';
require_once 'Fieldset.php';
require_once 'Form.php';

use formGenereitor\{Field, Fieldset, Form};


// cuando se crea un campo, el únivo parametro necesario es el valor para el atributos name, los atributos id, placeholder y title toman el mismo valor que name por defecto
$campo = new Field('nombre');
echo $campo->setOptions(['papa', 'ajo', 'cebolla']);

// los valores de los atributos se pueden cambiar
echo $campo->setPlaceholder('Indique su Nombre');

// se puede indicar si se quiere mostrar la label del campo
echo $campo->showLabel(false);

// se puede cambiar la label
echo $campo->setLabel('Indique su Nombre')->showLabel();

// tener en cuenta que si se cambia el id del campo, tambien se deberia cambiar el for del label
echo $campo->setId(25)->setLabelFor(25);
echo "<br>";


// formulario tipico

$campos = ['Nombre', 'Apellidos', 'Edad', 'Tel'];
foreach ($campos as $value) {
    $f = new Field($value);
    echo $f->showBootstrap()->showLabel()->setClass('form-control-sm');
}






echo "<h2>creando todos los tipos de campos </h2>";
$fields = ['submit', 'tel', 'text', 'textarea', 'select', 'button', 'checkbox', 'color', 'date', 'datetime-local', 'month', 'number', 'email' => "mi correo", 'file', 'hidden', 'image', 'password', 'radio', 'range', 'reset', 'search',  'time', 'url', 'week',];


echo "\n<h2>Fieldset</h2>\n";

$fieldSet = new Fieldset('Datos del Titular');
$fieldList = [];
foreach ($fields as $field) {
    $f = new Field($field, $field, $field);
    $f->showBootstrap()->showLabel();
    if('image' == $field){
        $f->setSrc("https://cdn.pixabay.com/photo/2016/01/23/11/41/button-1157299_960_720.png");
        $f->showBootstrap(false)->setStyle("width:50%");
    }

    $fieldList[] = $f;
}
$fieldSet->setFields($fieldList);
$campos = ['nombre' => '', 'Apellidos' => '', 'Email' => ''];
$form = new Form($campos);
$form->setFieldsets([$fieldSet]);
echo $form;


//$class = 'col col-md-2';
//$fieldSet->setFields($fieldList)->setClass($class)->showFieldLabel()->showFieldLabel()->showFieldBootstrap();
//$fieldSet->setFields($fieldList)->setClass('col col-md-4');
//var_dump($fieldSet);
//echo($fieldSet->setStyle('width:300px; color: red; border: solid 2px blue; margin: 20px'));

//var_dump( $fieldSet->setReadOnly(true));




//$f->setName('fecha')->setClass('col-sm-3')->showLabel()->showBootstrap();
//$f->setId(9);
//echo $f;

/*
foreach ($fields as $field){
    $campo = new Field($field, '', $field);
    echo $campo->showLabel()->showBootstrap()->setClass('col-sm-4')->setReadonly();
    echo "\n";
}
 *
 */
