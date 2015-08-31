<div class="container">

<fieldset>
    <?php
        echo $this->Form->create();
    ?>
    <legend>Register</legend>
    <?php 

    echo $this->Form->input('categoryname',array(
        'label'=>"Category Name ",
        'type' =>'text'
        ));
    
    echo'Category Type:    ';
    $options = array('0' => 'Expense', '1' => 'Income');
    echo $this->Form->select('type', $options);
    
    
    
   echo $this->Form->end('Add Category');
    ?>
</fieldset>

</div>
