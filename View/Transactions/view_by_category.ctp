<?php $this->assign('title', 'By Category'); ?>
<div class="col-md-12"
     <h3>Transaction In Selected Category</h3>
         <?php echo $this->Form->create('Transaction'); ?>
    <table class="table table-hover">
        <tbody>
            <tr>
                <th>Select Category</th>
                <th><?php
                    echo $this->Form->input('category_id', array(
                        'label'   => '',
                        'options' => $categoryList,
                        'empty'   => '(choose one)'
                    ));
                    ?>
                </th>
            </tr>
            <tr>
                <th colspan="2"><?php echo $this->Form->end('View Transaction '); ?></th>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover"
           <thead>
            <tr>
                <th>Content</th>
                <th>Money Amount</th>
                <th><?php echo $this->Html->link('Category', array('controller' => 'categories', 'action' => 'index', 'full_base' => true)); ?></th>
                <th><?php echo $this->Html->link('Wallet ', array('controller' => 'wallets', 'action' => 'index', 'full_base' => true)); ?></th>
                <th>Created</th>
                <th>Modified</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody> 
            <?php foreach ($transList as $item): ?>
                <tr>
                    <td><?php echo (empty($item['Transaction']['content'])) ? '' : $item['Transaction']['content'] ?></td>
                    <td><?php echo (empty($item['Transaction']['amount'])) ? '' : $item['Transaction']['amount'] ?></td>
                    <td><?php echo (empty($item['Category']['name'])) ? '' : $item['Category']['name'] ?></td>
                    <td><?php echo (empty($item['Wallet']['name'])) ? '' : $item['Wallet']['name'] ?></td>
                    <td><?php echo (empty($item['Transaction']['created'])) ? '' : $item['Transaction']['created'] ?></td>
                    <td><?php echo (empty($item['Transaction']['modified'])) ? '' : $item['Transaction']['modified'] ?></td>
                    <td><?php
                        echo $this->Html->link
                                ('Edit   ', array('controller' => 'transactions', 'action' => 'edit', $item['Transaction']['id'], 'full_base' => true));
                        echo $this->Form->Postlink
                                ($this->Html->tag('i', 'Delete', array('class' => 'glyphicon glyphicon-trash')), array('controller' => 'transactions', 'action' => 'delete', $item['Transaction']['id']), array('method' => 'post', 'confirm' => 'Delete This Transaction ?', 'class' => 'btn btn-denger', 'escape' => false));
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php
echo $this->Html->link(
        'Create A New Transaction', array('controller' => 'transactions', 'action' => 'add'), array('class' => 'button', 'target' => '_blank')
);
echo ' Or View Transaction : ';
echo $this->Html->link(
        'In This Month', array('controller' => 'transactions', 'action' => 'monthReport'), array('class' => 'button', 'target' => '_blank')
);
echo ' - ';
echo $this->Html->link(
        'Rank By Date ', array('controller' => 'transactions', 'action' => 'rankByDate'), array('class' => 'button', 'target' => '_blank')
);
echo ' - ';
echo $this->Html->link(
        'By Category', array('controller' => 'transactions', 'action' => 'viewByCategory'), array('class' => 'button', 'target' => '_blank')
);
?>