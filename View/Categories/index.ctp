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
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incomeList as $category): ?>
                <tr>
                    <td><?php echo $category['Category']['name']; ?></td>
                    <td><?php echo ($category['Category']['type'] == 1) ? 'Income' : 'Expens'; ?></td>
                    <td><?php echo $category['Category']['note']; ?></td>
                    <td><?php
                        echo $this->Html->link
                                ('Edit',array('controller' => 'categories','action' => 'edit', $category['Category']['id'],'full_base' => true) );
                        echo $this->Form->Postlink
                                ($this->Html->tag('i', 'Delete', array('class' => 'glyphicon glyphicon-trash')), array('controller' => 'categories', 'action' => 'delete', $category['Category']['id']), array('method' => 'post', 'confirm' => 'Delete This Category ?', 'class' => 'btn btn-denger', 'escape' => false) )
                        ?>
                    </td>
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
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expensList as $category): ?>
                <tr>
                    <td><?php echo $category['Category']['name']; ?></td>
                   <td><?php echo ($category['Category']['type'] == 1) ? 'Income' : 'Expens'; ?></td>
                    <td><?php echo $category['Category']['note']; ?></td>
                    <td><?php
                        echo $this->Html->link
                                ('Edit',array('controller' => 'categories','action' => 'edit', $category['Category']['id'],'full_base' => true) );
               
                        echo $this->Form->Postlink
                                ($this->Html->tag('i', 'Delete', array('class' => 'glyphicon glyphicon-trash')), array('controller' => 'categories', 'action' => 'delete', $category['Category']['id']), array('method' => 'post', 'confirm' => 'Delete This Category ?', 'class' => 'btn btn-denger', 'escape' => false)
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
        'Create A New Category', array('controller' => 'categories', 'action' => 'add'), array('class' => 'button', 'target' => '_blank')
);
?>