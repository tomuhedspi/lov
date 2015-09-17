<?php $this->assign('title', 'Edit Wallet'); ?>
<div class="container">

    <fieldset>
        <?php
        echo $this->Form->create();
        ?>
        <legend>Edit Wallet : <?php echo $item['Wallet']['name']; ?> </legend>
        <?php
        echo $this->Form->input('name', array(
            'label' => "Wallet Name ",
            'value' => $item['Wallet']['name'],
            'type'  => 'text'
        ));

        echo $this->Form->input('amount', array(
            'label' => "Money Amount",
            'value' => $item['Wallet']['amount'],
            'type'  => 'double'
        ));

        echo $this->Form->input('note', array(
            'label' => "Discription",
            'value' => $item['Wallet']['note'],
            'type'  => 'text'
        ));
        echo $this->Form->end('Update Wallet');
        ?>
    </fieldset>

</div>
