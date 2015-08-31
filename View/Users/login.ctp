<?php
echo $this->Html->script('additional-methods.min');
echo $this->Html->script('jquery.validate.min');
echo $this->Html->script('users');
?>

<div class="container">

<fieldset>
    <?php
        echo $this->Form->create();
    ?>
    <legend>Login</legend>
    <?php 

        echo $this->Form->input('username',array(
            'label'=>"User Name or Email",
            'type' =>'text'
            ));

        echo $this->Form->input('password', array(
            'label'=> 'Password',
            'type'=> 'password'
        ));
    ?>
<div class="form-group">
    <input type="checkbox"  id="remember" />
    <label for="remember">Remember Me</label>
</div>
    <?php
        echo $this->Form->end('Login');
    ?>
    <?php
    echo $this->Html->link
    (
    'Forgot Password ?',array
        (
            'controller' => 'users',
            'action' => 'forgotPassword',
            'full_base' => true
        )
    );
    
    ?>
</fieldset>

</div>
