<?php $this->assign('title', 'Money Lover Login'); ?>
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
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>Username Or Email</td>
                    <td>
                        <?php
                        echo $this->Form->input('username', array(
                            'label' => "",
                            'type'  => 'text'
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <?php
                        echo $this->Form->input('password', array(
                            'label' => '',
                            'type'  => 'password'
                        ));
                        ?>
                    </td>
                </tr>
                <tr>   
                    <td colspan="2">
                        <?php echo $this->Form->end('Login'); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class ="row">
            <?php
            echo $this->Html->link
                    (
                    'Forgot Password ?', array
                (
                'controller' => 'users',
                'action'     => 'forgotPassword',
                'full_base'  => true
                    )
            );
            echo '   You Dont Have Any An Account ?-->   ';
            echo $this->Html->link
                    (
                    'Create A New Account ?', array
                (
                'controller' => 'users',
                'action'     => 'register',
                'full_base'  => true
                    )
            );
            ?>
        </div> 

    </fieldset>

</div>
