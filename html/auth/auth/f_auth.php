<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
<?php
   /* formulaire */
   $form = new Form('horizontal');
   $form->fieldset(true);

   $form->add('html', '<h1>CGraphz</h1>');
   $form->add('text', 'f_user')
        ->label(USER)
        ->labelGrid('col-xs-3 col-md-4')
        ->inputGrid('col-xs-6 col-md-4')
        ->placeholder(USER);

   $form->add('text', 'f_passwd')
        ->iType('password')
        ->label(PASSWORD)
        ->labelGrid('col-xs-3 col-md-4')
        ->inputGrid('col-xs-6 col-md-4')
        ->placeholder(PASSWORD);

   $form->add('submit', 'f_submit_auth')
        ->iType('primary')
        ->labelGrid('col-xs-offset-3 col-md-offset-4')
        ->inputGrid('col-xs-6 col-md-4')
        ->value(SUBMIT);

   $form->bindValues($_POST);
   echo $form->bindForm();
?>
  </div>
  </div>
</div>

