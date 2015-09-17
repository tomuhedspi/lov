<?php $this->assign('title', 'Edit Category'); ?>
<div class="container">

    <fieldset>
        <?php
        echo $this->Form->create();
        ?>
        <legend>Edit Category : <?php echo $item['Category']['name']; ?> </legend>
        <?php
        echo $this->Form->input('name', array(
            'label' => "Category Name ",
            'value' => $item['Category']['name'],
            'type'  => 'text'
        ));

        echo'Category Type:    ' . '<br>';
        $options = array('0' => 'Expense', '1' => 'Income');
        echo $this->Form->select('type', $options);
        echo '<br>';

        echo $this->Form->input('note', array(
            'label' => "Discription ",
            'value' => $item['Category']['note'],
            'type'  => 'text'
        ));
        echo $this->Form->end('Update Category');
        ?>
    </fieldset>

</div>