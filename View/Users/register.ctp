<div class="container">

    <fieldset>
        <?php
        echo $this->Form->create();
        ?>
        <legend>Register</legend>
        <?php
        echo $this->Form->input('username', array(
            'label' => "User Name",
            'type'  => 'text'
        ));

        echo $this->Form->input('email', array(
            'label' => "Email",
            'type'  => 'email'
        ));

        echo $this->Form->input('password', array(
            'label' => 'Password',
            'type'  => 'password'
        ));

        echo $this->Form->input('confirm_password', array(
            'label' => 'Confirm Password',
            'type'  => 'password'
        ));

        echo $this->Form->end('Register');
        ?>
    </fieldset>

</div>
