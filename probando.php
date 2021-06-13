<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include_once 'includes/bootstrap.php'; ?>

    <title>Probando</title>
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
                        <h1>Probando</h1>
                        
                        
                            <?php                      
                            require_once 'Field.php';
                            require_once 'Fieldset.php';
                            require_once 'Form.php';

                            use formGenereitor\{Field, Fieldset, Form};

                            //var_dump($_POST);
                            
                            $form = new Form();
                            // crear un campo a pelo para ver el pattern
                            
                            $nombre = $form->createField('strName')->setLabel('Indique su Nombre')->setMaxlength(5)->setRequired();
                            
                            $form->createField('correo')->setType('email')->setLabel('Correo Electronico')->setPattern("[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$");

                            $form->createField('edad')->setType('number');
                            
                            $form->createField('sexo', ['' => '-', 'm' => 'mujer','h' => 'hombre']);

                            $form->createField('nacimiento')->setLabel('Fecha de Nacimiento')->setType('date')->setMin('2020')->setMax(2022);

                            $form->createField('disponible')->setLabel('Si quiero')->setValue('si')->setType('radio')->setRequired();
                            $form->createField('disponible')->setLabel('No quiero')->setValue('no')->setType('radio');

                            $form->createField('pasatiempo1')->setLabel('Leer')->setValue('leer')->setType('checkbox');
                            $form->createField('pasatiempo2')->setLabel('Cantautor')->setValue('cantar')->setType('checkbox');
                            $form->createField('pasatiempo[]')->setLabel('Bailar')->setValue('bailar')->setType('checkbox')->setRequired();
                            $form->createField('pasatiempo[]')->setLabel('Cocinar')->setValue('cocinar')->setType('checkbox');

                            $form->createField('direccion')->setType('textarea');

                            $aceptar = $form->createField('aceptar');
                            $aceptar->setType('submit');
                            
                            if(isset($_POST['aceptar']) and $form->validate()){
                                var_dump($_POST);
                                //header('location: probando.php?validado');
                            }
                            
                            if(isset($_GET['validado'])){
                                echo "<h3>El formulario ha sido validado correctamente</h3>";
                            }
                            
                            echo $form->start();
                            echo $nombre;
                            echo $form->getFieldById('field_13');
                            echo $form->end();
                            ?>
                        
                        
                    </div>
                </div>
            </div>
        </main>
    
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>
