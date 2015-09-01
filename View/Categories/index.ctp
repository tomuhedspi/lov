  <h2>Categories</h2>
  <p>All Categories You Have :</p>    
 
  
  <div class="col-md-6"
       <h4 Income Categories />
  <table class="table table-hover"
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($incomeList as $category): ?>
                        <tr>
                            <td><?php echo $category['Category']['name']; ?></td>
                            <td><?php if($category['Category']['type']==1){ echo'Income'; }else{ echo'Expens';}  ?></td>
                            <td><?php echo $category['Category']['note']; ?></td>
                        </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
</div>
 

 <div class="col-md-6"
  <h4 Expens Categories />
  <table class="table table-hover"
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Note</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($expensList as $category): ?>
                        <tr>
                            <td><?php echo $category['Category']['name']; ?></td>
                            <td><?php if($category['Category']['type']==1){ echo'Income'; }else{ echo'Expens';}  ?></td>
                            <td><?php echo $category['Category']['note']; ?></td>
                            <td>    <?php 
                                        echo $this->Form->Postlink
                                            (   'Edit',
                                                array('controller'=>'categories','action'=>'editCategory', $category['Category']['id']),
                                                array('method'=>'post','class'=>'btn btn-warning','escape'=>false)
                                            )
                                    ?>
                                
                                   <?php 
                                        echo $this->Form->Postlink
                                            (   'Delete',
                                                array('controller'=>'categories','action'=>'deleteCategory', $category['Category']['id']),
                                                array('method'=>'post','confirm'=>'Delete This Category ?','class'=>'btn btn-denger','escape'=>false)
                                            )
                                    ?>
                            </td>
                        </tr>
        <?php endforeach; ?>
       

    </tbody>
  </table>
</div>
  
<?php
  echo $this->Html->link(
    'Create A New Category',
    array('controller' => 'categories', 'action' => 'addCategory'),
    array('class' => 'button', 'target' => '_blank')
);
?>