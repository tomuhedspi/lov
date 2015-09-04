<h2>Transaction</h2>  

<div class="col-md-12"
    <h4 Wallet You Have :  />
    <table class="table table-hover"
           <thead>
            <tr>
                <th>Content</th>
                <th>Money Amount</th>
                <th>Category</th>
                <th>Wallet</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody> 
            <?php foreach ($transList as $item): ?>
                <tr>
                    <td><?php echo (empty($item['Transaction']['content'])) ? '': $item['Transaction']['name']   ?></td>
                    <td><?php echo (empty($item['Transaction']['amount']))  ? '': $item['Transaction']['amount'] ?></td>
                    <td><?php echo (empty($item['Transaction']['note']))    ? '': $item['Transaction']['note']   ?></td>
                    <td><?php echo (empty($item['Transaction']['note']))    ? '': $item['Transaction']['note']   ?></td>
                    <td><?php
                        echo $this->Html->link
                                ('Edit   ',array('controller' => 'transactions','action' => 'edit', $item['Transaction']['id'],'full_base' => true) );
                        echo $this->Form->Postlink
                                ($this->Html->tag('i', 'Delete', array('class' => 'glyphicon glyphicon-trash')), array('controller' => 'transactions', 'action' => 'delete', $item['transaction']['id']), array('method' => 'post', 'confirm' => 'Delete This Transaction ?', 'class' => 'btn btn-denger', 'escape' => false) )
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
?>