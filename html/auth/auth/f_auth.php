<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
    <form class="form-horizontal" method="post" action="">
      <fieldset>
        <!-- Form Name -->
        <h1>CGraphz</h1>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="f_user"><?php echo USER; ?></label>  
          <div class="col-md-4">
          <input id="f_user" name="f_user" placeholder="<?php echo USER; ?>" class="form-control input-md" type="text" value="<?php @$_POST['f_user']?>" />
          </div>
        </div>
        
        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="f_passwd"><?php echo PASSWORD; ?></label>
          <div class="col-md-4">
            <input id="f_passwd" name="f_passwd" placeholder="<?php echo PASSWORD; ?>" class="form-control input-md" type="password" />
          </div>
        </div>
        
        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="f_submit_auth"></label>
          <div class="col-md-4">
            <button type="submit" name="f_submit_auth" class="btn btn-primary"><?php echo SUBMIT ?></button>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
  </div>
</div>

