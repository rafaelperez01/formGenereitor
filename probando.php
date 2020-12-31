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

                            $form = new Form();
                            $form->showBootstrap();
                            $nombre = $form->createField('nombre');
                            $nombre->setLabel('Indique su Nombre')->setRequired();
                            echo $nombre;
                            
                            $apellidos = $form->createField('apellidos');
                            $apellidos->setLabel('Indique sus Apellidos')->setRequired();
                            echo $apellidos;
                            
                            var_dump($form->getFieldByName('apellidos'));
                            ?>
                        
                        
                    </div>
                </div>
            </div>
        </main>
    
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>
