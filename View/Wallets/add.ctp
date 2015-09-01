<div class="container">
    <h2>Add A New Wallet</h2>
<fieldset>
<?php
    echo $this->Form->create();
    echo $this->Form->input('name',array(
        'label'=>"Wallet Name",
        'type' =>'text'
        ));

    echo $this->Form->input('amount',array(
    'label'=>"Money Amount",
    'type' =>'double'
    ));

    echo $this->Form->input('note',array(
    'label'=>"Discription",
    'type' =>'text'
    ));
   echo $this->Form->end('Add Wallet ');
?>
</fieldset>

</div>
