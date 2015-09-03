<div class="container">

<fieldset>
    <?php
        echo $this->Form->create();
    ?>
    <legend>Reset Password</legend>
    <?php 

    echo $this->Form->input('password', array(
        'label'=> 'New Password',
        'type'=> 'password'
    ));
 
    echo $this->Form->input('confirm_password', array(
        'label'=> 'Confirm New Password',
        'type'=> 'password'
    ));
    
   echo $this->Form->end('Change Password');
    ?>
</fieldset>

</div>
