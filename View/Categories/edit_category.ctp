<div class="container">

<fieldset>
    <?php
        echo $this->Form->create();
    ?>
    <legend>Edit Category</legend>
    <?php 

    echo $this->Form->input('categoryname',array(
        'label'=>"Category Name ",
        'type' =>'text'
        ));
    
    echo'Category Type:    ';
    $options = array('0' => 'Expense', '1' => 'Income');
    echo $this->Form->select('type', $options);
    
    
    
   echo $this->Form->end('Update Category');
    ?>
</fieldset>

</div>
