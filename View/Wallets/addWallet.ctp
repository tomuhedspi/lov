<div class="container">

<fieldset>
    <?php
        echo $this->Form->create();
    ?>
    <legend>Register</legend>
    <?php 

    echo $this->Form->input('walletname',array(
        'label'=>"Wallet Name",
        'type' =>'text'
        ));

    echo $this->Form->input('amount',array(
    'label'=>"Money Amount",
    'type' =>'double'
    ));

   echo $this->Form->end('Register');
    ?>
</fieldset>

</div>
