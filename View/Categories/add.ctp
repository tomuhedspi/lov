<div class="container">

<fieldset>
    <?php
        echo $this->Form->create();
    ?>
    <legend>Add Category</legend>
    <?php 

    echo $this->Form->input('name',array(
        'label'=>"Category Name ",
        'type' =>'text'
        ));
    
    echo'Category Type:    '.'<br>';
    $options = array('0' => 'Expense', '1' => 'Income');
    echo $this->Form->select('type', $options);
    echo '<br>';
    
    echo $this->Form->input('note',array(
        'label'=>"Discription ",
        'type' =>'text'
        ));
  
    
   echo $this->Form->end('Add Category');
    ?>
</fieldset>

</div>
