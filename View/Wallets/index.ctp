<!--wallet index-->

<h2>List Of Your Wallet : </h2>   
<div class="col-md-6"
    <table class="table table-hover"
           <thead>
            <tr>
                <th>Wallet Name</th>
                <th>Money Amount</th>
                <th>Discription</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach  ($walletList as $wallet): ?>
                <tr> 
                    <td><?php echo (empty($wallet['Wallet']['name'])) ? '': $wallet['Wallet']['name'] ?></td>
                    <td><?php echo (empty($wallet['Wallet']['amount'])) ? '': $wallet['Wallet']['amount'] ?></td>
                    <td><?php echo (empty($wallet['Wallet']['note'])) ? '': $wallet['Wallet']['note'] ?></td>
                    <td><?php
                        echo $this->Html->link
                                ('Edit',array('controller' => 'wallets','action' => 'edit', $wallet['Wallet']['id'],'full_base' => true) );
                        echo $this->Form->Postlink
                                ($this->Html->tag('i', 'Delete', array('class' => 'glyphicon glyphicon-trash')), array('controller' => 'wallets', 'action' => 'delete', $wallet['Wallet']['id']), array('method' => 'post', 'confirm' => 'Delete This Wallet ?', 'class' => 'btn btn-denger', 'escape' => false) )
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<br> </br>
<?php
echo $this->Html->link(
        'Create A New Wallet', array('controller' => 'wallets', 'action' => 'add'), array('class' => 'button', 'target' => '_blank')
);
?>