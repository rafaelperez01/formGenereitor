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

$form = new Form();
$form->showBootstrap();
?>
<?= $form->start(); ?>

    <?= $form->createField('Nombre'); ?>

    <?= $form->createField('Apellidos'); ?>

    <?= $form->createField('Email'); ?>

    <?= $form->createField('Telefono'); ?>

<p>Seleccione el Sexo:</p>
    <?= $form->createField('Sexo')->setType('radio')->setLabel('Hombre')->setValue('h')->setId('h'); ?>
    <?= $form->createField('Sexo')->setType('radio')->setLabel('Mujer')->setValue('m')->setId('m')->setChecked(); ?>

<p>Seleccione aficiones:</p>
    <?= $form->createField('aficion')->setType('checkbox')->setLabel('Correr')->setValue('correr')->setId('correr') ?>
    <?= $form->createField('aficion')->setType('checkbox')->setLabel('Leer')->setValue('leer')->setId('leer') ?>
    <?= $form->createField('aficion')->setType('checkbox')->setLabel('Cocinar')->setValue('cocinar')->setId('cocinar') ?>

    <?= $form->createField('fechaNacimiento')->setType('date')->setLabel('Fecha de Nacimiento'); ?>

    <?= $form->createField('Pais de Nacimiento')->setType('select')->setOptions(['es' => 'España', 'rd' => 'Rep. Dominicana']); ?>

    <?= $form->createField('Direccion')->setType('textarea')->setRows(10); ?>

<?= $form->createField('Enviar')->setType('submit')->showLabel(false); ?>

<?= $form->end(); ?>