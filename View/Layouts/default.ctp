<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $this->fetch('title'); ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
//
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('style');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
    </head>
    <body>
        <div id="container">
            <!– Begin Logo –>
            <div id=”top”  >
                <a class="top_logo" >Money Lover - Expense Manager</a>
            </div>
            <!– end logo –>

            <!– Begin Menu –>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <?php echo $this->Html->tag('li', $this->Html->link('Home ', array('controller' => 'users', 'action' => 'index'))); ?>
                            <?php echo $this->Html->tag('li', $this->Html->link('Contact ', array('controller' => 'users', 'action' => 'contact'))); ?>
                            <li class="dropdown">
                                <a href= "" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Transaction <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php echo $this->Html->tag('li', $this->Html->link('Show All', array('controller' => 'transactions', 'action' => 'index'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('Add', array('controller' => 'transactions', 'action' => 'add'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('Month Report', array('controller' => 'transactions', 'action' => 'monthReport'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('By Date Rank', array('controller' => 'transactions', 'action' => 'rankByDate'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('By Category', array('controller' => 'transactions', 'action' => 'viewByCategory'))); ?>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href= "" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Wallet <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php echo $this->Html->tag('li', $this->Html->link('Show All', array('controller' => 'wallets', 'action' => 'index'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('Add', array('controller' => 'wallets', 'action' => 'add'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('Transfer Money', array('controller' => 'wallets', 'action' => 'transfer'))); ?>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href= "" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Category <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php echo $this->Html->tag('li', $this->Html->link('Show All', array('controller' => 'categories', 'action' => 'index'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('Add', array('controller' => 'categories', 'action' => 'add'))); ?>
                                </ul>
                            </li>

                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#"> <?php echo AuthComponent::user('username'); ?></a></li>

                            <li class="dropdown">
                                <a href= "" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php echo $this->Html->tag('li', $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('Change Avatar', array('controller' => 'users', 'action' => 'edit'))); ?>
                                    <li role="separator" class="divider"></li>
                                    <?php echo $this->Html->tag('li', $this->Html->link('Register', array('controller' => 'users', 'action' => 'register'))); ?>
                                </ul>
                            </li>
                        </ul>

                    </div><!-- /.navbar-collapse -->

                </div><!-- /.container-fluid -->
            </nav>
            <!– End Menu–>
            <div  class="col-md-12 col-lg-12 col-sm-12 col-xs-12 " id =" container" >
                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" id = "sidebar" >
                    <?php echo $this->fetch('sidebar'); ?>
                </div>

                <div id="content" class="col-md-9 col-lg-9 col-sm-9 col-xs-9 ">
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->fetch('content'); ?>
                </div>

                <div id ="rightbar" class="col-md-1 col-lg-1 col-sm-1 col-xs-1 " >
                    <?php echo $this->fetch('rightbar'); ?>
                </div>
            </div>

            <div class ="copyright">
                <span>©2015 Money Lover - An Expense Manager By Nguyen Thi Thom</span>
            </div>
        </div>
        <?php echo $this->element('sql_dump'); ?>
        <?php
        echo $this->Html->script('jquery-1.11.3.min');
        echo $this->Html->script('bootstrap.min');
        echo $this->fetch('script');
        ?>
    </body>
</html>
