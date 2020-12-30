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
?>
<?= $form->start(); ?>
<div class="col-sm-6">
    <?= $form->createField('Nombre')->showBootstrap()->showLabel(); ?>
</div>
<div class="col-sm-6">
    <?= $form->createField('Apellidos')->showBootstrap()->showLabel(); ?>
</div>
<div class="col-sm-6">
    <?= $form->createField('Email')->showBootstrap()->showLabel(); ?>
</div>
<div class="col-sm-6">
    <?= $form->createField('Telefono')->showBootstrap()->showLabel(); ?>
</div>
<div class="col-sm-6">
    <?= $form->createField('Sexo')->setType('radio')->setLabel('Hombre')->showLabel()->setValue('h'); ?>
</div>
<div class="col-sm-6">
    <?= $form->createField('Sexo')->setType('radio')->setLabel('Mujer')->showLabel()->setValue('m'); ?>
</div>
<div class="col-sm-12">
    <?= $form->createField('Direccion')->showBootstrap()->showLabel()->setType('textarea')->setRows(10); ?>
</div>
<?= $form->createField('Enviar')->setType('submit'); ?>

<?= $form->end(); ?>