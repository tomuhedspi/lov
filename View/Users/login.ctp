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
    
    <?php
        echo $this->Form->end('Login');
    ?>
    
    <div class ="row">
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
    echo '   You Dont Have Any An Account ?-->   ';
    echo $this->Html->link
    (
    'Create A New Account ?',array
        (
            'controller' => 'users',
            'action' => 'register',
            'full_base' => true
        )
    );
    ?>
    </div> 
    
</fieldset>

</div>
