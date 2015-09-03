<div class="container">

    <fieldset>
        <?php
        echo $this->Form->create();
        ?>
        <legend>Reset password</legend>
        <?php
        echo $this->Form->input('username', array(
            'label' => "Please enter your Username",
            'type'  => 'text'
        ));

        echo $this->Form->end('Reset Password');
        ?>
    </fieldset>

</div>
