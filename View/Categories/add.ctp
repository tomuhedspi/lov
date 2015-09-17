<?php $this->assign('title', 'Add Category'); ?>
<div class="container">

    <fieldset>
        <?php
        echo $this->Form->create();
        ?>
        <legend>Add Category</legend>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Category Name</th>
                    <th> <?php echo $this->Form->input('name', array('type' => 'text','label'=>'')); ?></th>
                </tr>
                <tr>
                    <th>Category Type</th>
                    <th><?php
                        $options = array('0' => 'Expense', '1' => 'Income');
                        echo $this->Form->select('type', $options);
                        ?> 
                    </th>
                </tr>
                <tr>
                    <th>Discription</th>
                    <th><?php echo $this->Form->input('note', array('type' => 'text','label'=>'')); ?> </th>
                </tr>
            </tbody>
        </table>
        <?php echo $this->Form->end('Add Category'); ?>
    </fieldset>
</div>