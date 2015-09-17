<?php $this->assign('title', 'View Transaction In Category'); ?>
<div class="col-md-12"
     <h3>All Transaction In : <?php echo $categoryName;  ?></h3>  
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
        'Create A New Transaction In This Category', array('controller' => 'transactions', 'action' => 'addInCategory',$categoryId), array('class' => 'button',)
);
?>