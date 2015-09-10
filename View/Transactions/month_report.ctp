<h3>Transaction From <?php echo $start; ?> To <?php echo $end; ?></h3>  
<div class="row">
    <div class="col-md-5">
        <table class="table tab-content">
            <tbody>
                <tr>
                    <th>Month Income Total</th>
                    <th><?php echo $incomeTotal; ?></th>
                </tr> 
                <tr>
                    <th>Month Expense Total</th>
                    <th><?php echo $expenseTotal; ?></th>
                </tr> 
                <tr>
                    <th>Total Money</th>
                    <th><?php echo ($incomeTotal + $expenseTotal); ?></th>
                </tr> 
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
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

</div>
<?php
echo $this->Html->link(
        'Create A New Transaction', array('controller' => 'transactions', 'action' => 'add'), array('class' => 'button', 'target' => '_blank')
);
?>