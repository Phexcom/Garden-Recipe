<div class="container-fluid container-fill-height">
  <div class="container-content-middle">
    <?php if (isset($error)): ?>
          <div class="alert alert-danger alert-dismissible hidden-xs center">
              <strong><?=$error;?></strong>
          </div>
      <?php endif; ?> 
    <div role="form" class="m-x-auto text-center app-login-form">
      
      <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success alert-dismissible hidden-xs center">
           <strong><?=$this->session->flashdata('message')?></strong>
        </div>
      <?php endif; ?>



       <a class="navbar-brand" href="#">
        <a href="<?php echo(base_url());?>" class="navbar-brand" style="font-size:1.8em; font-weight:bold; font-family:ubuntu;">Garden Recipes </a>
      </a>
    <?php echo form_open(); ?>
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

      <div class="m-b-lg">
        <button  class="btn btn-primary" >Login</button>
        <?php echo anchor('account/register','Register',['class'=>'btn btn-default']); ?>
        <!-- <button type="submit" class="btn btn-primary" >Register</button>
        <button type="submit" class="btn btn-default">Login</button> -->
      </div>
    <?php echo form_close(); ?>
      <footer class="screen-login">
        <a href="forgotpass" class="text-muted">Forgot password</a>
      </footer>
  </div>
</div>
</div>
