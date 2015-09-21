<?php $this->assign('title', 'Transfer Money Between Wallet'); ?>
<div class="container">
    <h2>Transfer Money Between Wallet</h2>
    <fieldset>
        <?php echo $this->Form->create(); ?>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>From Wallet</th>
                    <th><?php
                        echo $this->Form->input('from', array(
                            'label'   => '',
                            'options' => $walletList,
                            'empty'   => '(choose one)'
                        ));
                        ?>             
                    </th>
                    <th><?php echo $emptyFrom;  ?></th>
                </tr>
                <tr>
                    <th>To Wallet</th>
                    <th><?php
                        echo $this->Form->input('to', array(
                            'label'   => '',
                            'options' => $walletList,
                            'empty'   => '(choose one)'
                        ));
                        ?>
                    </th>
                    <th><?php  echo $emptyTo;  ?></th>
                </tr>
                <tr>
                    <th>Transfer Amount</th>
                    <th colspan="2"><?php
                        echo $this->Form->input('amount', array(
                            'label' => "",
                            'type'  => 'double'
                        ));
                        ?> 
                    </th>
                </tr>
                <tr>
                    <th colspan="3"><?php echo $this->Form->end('Transfer Money Now '); ?></th>
                </tr>
            </tbody>
        </table>

    </fieldset>

</div>