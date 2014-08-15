<?php
include('config/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/bootstrap/js/bootstrap.min.js"></script>

   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/bootstrap/css/bootstrap.min.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/bootstrap/css/bootstrap-theme.min.css" />
</head>
<body>
<div class="container">
<?php


   /* formulaire */
   $form = new Form('inline');

   $form->add('text', 'test')
        ->label('test')
        ->placeholder('InputText');
    
   $form->add('text', 'test2')
        ->label('test2')
        ->placeholder('InputText');

   $form->add('submit', 'pseudo')
        ->iType('warning')
        ->value('Envoyer');
 
   $form->bindValues($_POST); // Ici on lie automatiquement un tableau de variable ou une entité de la couche modèle
   echo $form->bindForm();

echo '<hr />';

   /* formulaire */
   $form2 = new Form('horizontal');

   $form2->add('text', 'test')
        ->labelGrid('col-sm-2')
        ->inputGrid('col-sm-10')
        ->label('test')
        ->placeholder('InputText');
    
   $form2->add('text', 'test2')
        ->labelGrid('col-sm-2')
        ->inputGrid('col-sm-10')
        ->label('test2')
        ->placeholder('InputText');

   $form2->add('submit', 'pseudo')
        ->value('Envoyer');
 
   $form2->bindValues($_POST); // Ici on lie automatiquement un tableau de variable ou une entité de la couche modèle
   echo $form2->bindForm();

echo '<hr />';

   /* formulaire */
   $form3 = new Form('default');

   $form3->add('text', 'test')
        ->label('test')
        ->placeholder('InputText');
    
   $form3->add('text', 'test2')
        ->label('test2')
        ->placeholder('InputText');

   $form3->add('submit', 'pseudo')
        ->value('Envoyer');
 
   $form3->bindValues($_POST); // Ici on lie automatiquement un tableau de variable ou une entité de la couche modèle
   echo $form3->bindForm();
?>
</div>
</body>
</html>
