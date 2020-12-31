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
                        
                        
                            <?php                      
                            require_once 'Field.php';
                            require_once 'Fieldset.php';
                            require_once 'Form.php';

                            use formGenereitor\{Field, Fieldset, Form};

                            $form = new Form();
                            $form->showBootstrap();
                            ?>


                        
                            <?= $form->start(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->createField('Nombre'); ?>
                                    <?= $form->createField('Apellidos'); ?>
                                    <?= $form->createField('Email'); ?>
                                    <?= $form->createField('Telefono'); ?>

                                    <p><strong>Seleccione el Sexo:</strong></p>
                                        <?= $form->createField('Sexo')->setType('radio')->setLabel('Hombre')->setValue('h')->setId('h'); ?>
                                        <?= $form->createField('Sexo')->setType('radio')->setLabel('Mujer')->setValue('m')->setId('m')->setChecked(); ?>

                                    <p><strong>Seleccione aficiones:</strong></p>
                                        <?= $form->createField('aficion')->setType('checkbox')->setLabel('Correr')->setValue('correr')->setId('correr') ?>
                                        <?= $form->createField('aficion')->setType('checkbox')->setLabel('Leer')->setValue('leer')->setId('leer') ?>
                                        <?= $form->createField('aficion')->setType('checkbox')->setLabel('Cocinar')->setValue('cocinar')->setId('cocinar') ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->createField('imagen')->setType('file') ?>
                                    <?= $form->createField('fechaNacimiento')->setType('date')->setLabel('Fecha de Nacimiento'); ?>
                                    <?= $form->createField('Pais de Nacimiento')->setType('select')->setOptions(['es' => 'España', 'rd' => 'Rep. Dominicana']); ?>
                                    <?= $form->createField('Direccion')->setType('textarea')->setRows(10); ?>
                                </div>
                            </div>
                                <?= $form->createField('Enviar')->setType('submit')->setClass('btn-success'); ?>
                            

                            <?= $form->end(); ?>
                        
                        
                    </div>
                </div>
            </div>
        </main>
    
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>
