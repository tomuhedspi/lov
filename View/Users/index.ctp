<?php

echo $this->Html->link(
        'Login', array('action' => 'login'), array('class' => 'btn btn-primary', 'target' => '_blank')
);
?>

<?php

echo $this->Html->link(
        'Logout', array('action' => 'logout'), array('class' => 'btn btn-success', 'target' => '_blank')
);
?>

<?php

echo $this->Html->link(
        'Register', array('action' => 'register'), array('class' => 'btn btn-info', 'target' => '_blank')
);
