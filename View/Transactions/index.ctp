<h2>Wallet</h2>  

<div class="col-md-6"
    <h4 Wallet You Have :  />
    <table class="table table-hover"
           <thead>
            <tr>
                <th>Content</th>
                <th>Category</th>
                <th>Wallet</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($walletList as $item): ?>
                <tr>
                    <td><?php echo (empty($item['Transaction']['content'])) ? '': $item['Wallet']['name'] ?></td>
                    <td><?php echo (empty($item['Transaction']['amount'])) ? '': $item['Wallet']['amount'] ?></td>
                    <td><?php echo (empty($item['Transaction']['note'])) ? '': $item['Wallet']['note'] ?></td>
                    <td><?php
                        echo $this->Html->link
                                ('Edit   ',array('controller' => 'wallets','action' => 'edit', $item['Wallet']['id'],'full_base' => true) );
                        echo $this->Form->Postlink
                                ($this->Html->tag('i', 'Delete', array('class' => 'glyphicon glyphicon-trash')), array('controller' => 'wallets', 'action' => 'delete', $item['Wallet']['id']), array('method' => 'post', 'confirm' => 'Delete This Wallet ?', 'class' => 'btn btn-denger', 'escape' => false) )
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php
echo $this->Html->link(
        'Create A New Wallet', array('controller' => 'wallets', 'action' => 'add'), array('class' => 'button', 'target' => '_blank')
);
?>