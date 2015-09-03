Dear <?php echo $user['username'];  ?> ,
<p>To reset password, Please click the link below.</p>
<p>
    <?php
    echo $this->Html->link
            ('Reset Password Now !',array
                (
                    'controller' => 'users',
                    'action'     => 'resetPassword',
                    $user['id'],
                    $user['token'],
                    'full_base'  => true,
                )
            )
    ?>
</p>