<div class="container">

<fieldset>
    <?php
        echo $this->Form->create();
    ?>
    <legend>Edit Wallet : <?php  echo $selectedName ;  ?> </legend>
    <?php 
        echo $this->Form->input('name',array(
            'label'=>"Wallet Name ",
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
        echo $this->Form->end('Update Wallet');
    ?>
</fieldset>

</div>
