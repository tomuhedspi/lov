<?php

echo (empty($username)) ? '' : 'WELCOME : ' . $username . ' !<br><br>Lets Go Through The Project :<br><br>';
echo $this->Html->link(
        'Login', array('action' => 'login'), array('class' => 'btn btn-primary btn-sm')
);
echo "\t";
echo $this->Html->link(
        'Logout', array('action' => 'logout'), array('class' => 'btn btn-success btn-sm')
);
echo "\t";
echo $this->Html->link(
        'Register', array('action' => 'register'), array('class' => 'btn btn-info btn-sm')
);
echo "\t";
echo $this->Html->link(
        'Transaction', array('controller' => 'transactions', 'action' => 'index'), array('class' => 'btn btn-warning btn-sm',)
);
echo "\t";
echo $this->Html->link(
        'Category', array('controller' => 'categories', 'action' => 'index'), array('class' => 'btn btn-danger btn-sm',)
);
echo "\t";
echo $this->Html->link(
        'Wallet', array('controller' => 'wallets', 'action' => 'index'), array('class' => 'btn btn-primary btn-sm',)
);
echo "\t";
