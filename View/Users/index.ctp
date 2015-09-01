<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Money Lover Index</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body  >
    <h1>Money Lover</h1>
    <?php
        echo $this->Html->link(
                'Login', array( 'action' => 'login'), array('class' => 'button', 'target' => '_blank')
        );
        echo '     ';
        echo $this->Html->link(
                'Logout', array( 'action' => 'logout'), array('class' => 'button', 'target' => '_blank')
        );
    ?>
</body>
</html>