<?php $this->assign('title', 'Add Wallet'); ?>
<div class="container">
    <h2>Add A New Wallet</h2>
    <fieldset>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Wallet Name</th>
                    <th>
                        <?php
                        echo $this->Form->create();
                        echo $this->Form->input('name', array(
                            'label' => "",
                            'type'  => 'text'
                        ));
                        ?>
                    </th>
                </tr>
                <tr>
                    <th>Money Amount</th>
                    <th>
                        <?php
                        echo $this->Form->input('amount', array(
                            'label' => "",
                            'type'  => 'double'
                        ));
                        ?>
                    </th>
                </tr>
                <tr>
                    <th>Discription</th>
                    <th>
                        <?php
                        echo $this->Form->input('note', array(
                            'label' => "",
                            'type'  => 'text'
                        ));
                        ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="2"> 
                        <?php echo $this->Form->end('Add Wallet '); ?>
                    </th>
                </tr>
            </tbody>
        </table>
    </fieldset>

</div>
