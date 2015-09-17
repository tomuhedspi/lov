<?php $this->assign('title', 'Add A New Transaction'); ?>
<div class="container">
    <h2>Add A New Transaction</h2>
    <table class="table table-condensed">
        <thead></thead>
        <tbody>
            <tr>
                <th>Transaction Content</th>
                <th colspan="2"><?php
                    echo $this->Form->create('Transaction');
                    echo $this->Form->input('content', array(
                        'label' => "",
                        'type'  => 'text'
                    ));
                    ?>    
                </th>
            </tr>
            <tr>
                <th>Transaction Amount</th>
                <th colspan="2"><?php
                    echo $this->Form->input('amount', array(
                        'label' => "",
                        'type'  => 'double'
                    ));
                    ?>
                </th>
            </tr>
            <tr>
                <th>Wallet</th>
                <th>
                    <?php
                    echo $this->Form->input('wallet_id', array(
                        'label'   => '',
                        'options' => $walletList,
                        'empty'   => '(choose one)'
                    ));
                    ?>
                </th>
                <th>
                    <?php
                    echo $this->Html->link(
                            'Create A New Wallet', array('controller' => 'wallets', 'action' => 'add'), array('class' => 'button', 'target' => '_blank')
                    );
                    ?>
                </th>
            </tr>
            <tr>
                <th>Category</th>
                <th>
                    <?php
                    echo $this->Form->input('category_id', array(
                        'label'   => '',
                        'options' => $categoryList,
                        'empty'   => '(choose one)'
                    ));
                    ?>
                </th>
                <th>
                    <?php
                    echo $this->Html->link(
                            'Create A New Category', array('controller' => 'categories', 'action' => 'add'), array('class' => 'button', 'target' => '_blank')
                    );
                    ?>
                </th>
            </tr>
        </tbody>
    </table>
    <?php echo $this->Form->end('Add Transaction '); ?>
</div>
