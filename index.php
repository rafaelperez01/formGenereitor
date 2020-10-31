<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap 4 CSS -->
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">-->
    
    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>formGenereitor 2.0</title>
  </head>
  <body>
    <h1>Form Genereitor 2.0</h1>

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

use formGenereitor\Field;


// cuando se crea un campo, se setean automaticamente los atributos name, id, placeholder y title
$campo = new Field('nombre',3, 'textarea');
echo $campo->setOptions(['papa', 'ajo', 'cebolla']);
echo "<br>";

// los valores de los atributos se pueden cambiar
//echo $campo->setPlaceholder('Indique su Nombre');
echo "<br>";

// se puede indicar si se quiere mostrar la label del campo
echo $campo->showLabel();
echo "<br>";

// se puede cambiar la label
echo $campo->setLabel('Indique su Nombre');
echo "<br>";

// tener en cuenta que si se cambia el id del campo, tambien se deberia cambiar el for del label
echo $campo->setId(25)->setLabelFor(25);
echo "<br>";

echo "<h2>creando todos los tipos de campos </h2>";
$fields = ['submit', 'tel', 'text', 'textarea', 'select', 'button', 'checkbox', 'color', 'date', 'datetime-local', 'email', 'file', 'hidden', 'image', 'month', 'number', 'password', 'radio', 'range', 'reset', 'search',  'time', 'url', 'week',];


echo "<p>Sexto</p>\n";

$sexo = ['h' => 'hombre', 'm' => 'mujer'];
foreach ($sexo as $value => $label){
    $f = new Field('sexo', $value, 'checkbox');
    $f->setLabel($label)->setId($value)->showLabel()->setLabelClass('checkbox-inline');
    echo $f;
}





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

?>
    
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>
