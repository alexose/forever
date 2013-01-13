<h1>Create User</h1>
<p>Please enter your information below.</p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_user");?>
      <p>
            Email: <br />
            <?php echo form_input($email);?>
      </p>

      <p>
            Password: <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            Confirm Password: <br />
            <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', 'Register');?></p>

<?php echo form_close();?>
