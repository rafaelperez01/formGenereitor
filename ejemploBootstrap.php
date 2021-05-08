<?php
require_once 'Field.php';
require_once 'Fieldset.php';
require_once 'Form.php';

use formGenereitor\{Field, Fieldset, Form};

$showBootstrap = (bool) isset($_GET['showBootstrap']) ? !$_GET['showBootstrap'] : 0;
$form = new Form();
$form->showBootstrap($showBootstrap);
$nombre = $form->createField('Nombre')->setRequired();
$apellidos = $form->createField('Apellidos');
$email = $form->createField('Email')->setType('email');
$telefono = $form->createField('Telefono')->setType('number');
$sexoH = $form->createField('Sexo')->setType('radio')->setLabel('Hombre')->setValue('h')->setRequired();
$sexoM = $form->createField('Sexo')->setType('radio')->setLabel('Mujer')->setValue('m')->setChecked();
$aficionCorrer = $form->createField('aficion[]')->setType('checkbox')->setLabel('Correr')->setValue('correr');
$aficionLeer = $form->createField('aficion[]')->setType('checkbox')->setLabel('Leer')->setValue('leer');
$aficionCocina = $form->createField('aficion[]')->setType('checkbox')->setLabel('Cocinar')->setValue('cocinar');
$nacimiento = $form->createField('fechaNacimiento')->setType('date')->setLabel('Fecha de Nacimiento');
$paisNacimiento = $form->createField('Pais de Nacimiento')->setType('select')->setOptions(['' => '-', 'es' => 'España', 'rd' => 'Rep. Dominicana'])->setRequired();
$imagen = $form->createField('imagen')->setType('file');
$direccion = $form->createField('Direccion')->setType('textarea')->setRows(10)->setRequired()->setStyle('resize: none;');
$enviar = $form->createField('Enviar')->setType('submit')->setClass('btn-success');
if(isset($_POST['Enviar']) and $form->validate()){
    var_dump($_POST);
}
?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include_once 'includes/bootstrap.php'; ?>

    <title>FormGenereitor 2.0</title>
    <style>
        body {
            padding-top: 70px;
        }
    </style>
  </head>
  <body>

        <main>
            
            <!-- navBar -->
            <?php include_once 'includes/navBar.php'; ?>
            <!-- /navBar -->
            
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Form Genereitor 2.0</h1>
                        <a href="ejemploBootstrap.php?showBootstrap=<?= $showBootstrap ?>" class="btn btn-warning"><?php echo $showBootstrap ? 'No ' : ''; ?>Mostrar estilo Bootstrap</a>
                            <?= $form->start(); ?><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $nombre ?>
                                    <?= $apellidos ?>
                                    <?= $email ?>
                                    <?= $telefono ?>

                                    <p><strong>Seleccione el Sexo:</strong></p>
                                        <?= $sexoH ?>
                                        <?= $sexoM ?>

                                    <p><strong>Seleccione aficiones:</strong></p>
                                        <?= $aficionCorrer ?>
                                        <?= $aficionLeer ?>
                                        <?= $aficionCocina ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $nacimiento ?>
                                    <?= $paisNacimiento ?>
                                    <?= $imagen ?>
                                    <?= $direccion ?>
                                </div>
                            </div>
                                <?= $enviar; ?>
                            <?= $form->end(); ?>
                        
                    </div>
                </div>
            </div>
        </main>
    
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>
