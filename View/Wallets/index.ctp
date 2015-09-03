<h2>Wallet</h2>  

<div class="col-md-12 col-lg-12 col-sm-12"
    <h4 Wallet You Have :  />
    <table class="table table-hover"
           <thead>
            <tr>
                <th>Wallet Name</th>
                <th>Money Amount</th>
                <th>Is Default Wallet</th>
                <th>Discription</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($walletList as $item): ?>
                <tr>
                    <td><?php echo (empty($item['Wallet']['name'])) ? '': $item['Wallet']['name'] ?></td>
                    <td><?php echo (empty($item['Wallet']['amount'])) ? '': $item['Wallet']['amount'] ?></td>
                    <td><?php echo ($item['Wallet']['id']==$usingWallet)? $this->Form->Postlink
                                ($this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ok')), array('action'=>'index'),array('escape' => false) ):'' ?> </td>
                    <td><?php echo (empty($item['Wallet']['note'])) ? '': $item['Wallet']['note'] ?></td>
                    <td><?php
                        echo $this->Html->link
                                ('Edit   ',array('controller' => 'wallets','action' => 'edit', $item['Wallet']['id'],'full_base' => true) );
                        echo $this->Form->Postlink
                                ($this->Html->tag('i', 'SetCurrentWallet', array('class' => 'glyphicon glyphicon-heart-empty')), array('controller' => 'wallets', 'action' => 'setCurrentWallet', $item['Wallet']['id']), array('method' => 'post', 'confirm' => 'Use This Wallet As Default Wallet ?', 'class' => 'btn btn-denger', 'escape' => false) );
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
echo '  ';
echo $this->Html->link(
        'Transfer Money Bettween Wallet', array('controller' => 'wallets', 'action' => 'transfer'), array('class' => 'button', 'target' => '_blank')
);
?>