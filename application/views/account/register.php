<div class="container-fluid container-fill-height">
  <div class="container-content-middle">
    <div role="form" class="m-x-auto text-center app-login-form">

        <a class="navbar-brand" href="#">
        <a href="<?php echo(base_url());?>" class="navbar-brand" style="font-size:1.8em; font-weight:bold; font-family:ubuntu;">Garden Recipes </a>
        </a>
    <?php echo form_open(); ?>
      <div class="form-group">
        <label for="firstname" ></label>
        <input name="firstname" class="form-control"  placeholder="Firstname" type="text" value="<?php echo set_value('firstname'); ?>" required="required" />
        <?php echo form_error('firstname','<div class="alert alert-danger text-center">','</div>'); ?>   
      </div>

      <div class="form-group">
        <label for="lastname" ></label>
        <input name="lastname" class="form-control"  placeholder="Lastname" type="text" value="<?php echo set_value('lastname'); ?>" required="required" />
        <?php echo form_error('lastname','<div class="alert alert-danger text-center">','</div>'); ?>   
      </div>

      <div class="form-group">
        <label for="email" ></label>
        <input name="email" class="form-control"  placeholder="Email" type="email" value="<?php echo set_value('email'); ?>" required="required" />
        <?php echo form_error('email','<div class="alert alert-danger text-center">','</div>'); ?>   
      </div>

      <div class="form-group">
        <label for="password" ></label>
        <input name="password" class="form-control"  placeholder="Password" type="password" value="<?php echo set_value('password'); ?>" required="required" />
        <?php echo form_error('password','<div class="alert alert-danger text-center">','</div>'); ?>   
      </div>

      <div class="form-group">
        <label for="confirmpassword" ></label>
        <input name="confirmpassword" class="form-control"  placeholder="Confirm Password" type="password" value="<?php echo set_value('confirmpassword'); ?>" required="required" />
        <?php echo form_error('confirmpassword','<div class="alert alert-danger text-center">','</div>'); ?>   
      </div>

      <div class="form-group">
        <label for="dob" ></label>
        <input name="dob" class="form-control"  placeholder="Date Of Birth" type="Date" value="<?php echo set_value('dob'); ?>" required="required" />
        <?php echo form_error('dob','<div class="alert alert-danger text-center">','</div>'); ?>   
      </div>

      <div class="form-group">
        <button  class="btn btn-primary" >Register</button>
        <?php echo anchor('account/login','Login',['class'=>'btn btn-default']); ?>
      </div>
    
      <footer class="screen-login">
        <a href="forgotpass" class="text-muted">Forgot password</a>
      </footer>
      <?php echo form_close(); ?>

    </div>
  </div>
</div>
