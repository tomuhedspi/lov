<div class="container">
    <h2>Transfer Money Between Wallet</h2>
<fieldset>
<?php
    echo $this->Form->create();
    echo $this->Form->input('from',array(
        'label'=>'From Wallet : ',
        'options'=>$walletList,
        'empty' => '(choose one)'
        ));

    echo $this->Form->input('to',array(
        'label'=>'To Wallet : ',
        'options'=>$walletList,
        'empty' => '(choose one)'
    ));

    echo $this->Form->input('amount',array(
        'label'=>"Transfer Amount : ",
        'type' =>'double'
    ));
   echo $this->Form->end('Transfer Money Now ');
?>
</fieldset>

</div>