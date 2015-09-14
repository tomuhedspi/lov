<div class="container">
    <h2>Add A New Transaction In : <?php echo $categoryName;   ?> </h2>
    <?php
    echo $this->Form->create('Transaction');
    echo $this->Form->input('content', array(
        'label' => "Transaction Content",
        'type'  => 'text'
    ));

    echo $this->Form->input('amount', array(
        'label' => "Transaction Amount",
        'type'  => 'double'
    ));
    echo '(Current Wallet : )'.$currentWalletName;
 echo $this->Form->end('Add Transaction '); ?>
</div>
