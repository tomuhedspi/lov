<?php $this->assign('title', 'Edit User Info'); ?>
<div class="container">
    <h3> Edit User Avatar </h3>
    <?php echo $this->Form->create('Image', array('type' => 'file')); ?>

    <table class="table table-striped">
        <tbody>
            <tr>
                <th>Select Image</th>
                <th><?php echo $this->Form->input('img', array('type' => 'file', 'label' => '')); ?></th>
            </tr>
            <tr>
                <th><?php echo $this->Form->submit('Upload Images'); ?></th>
            </tr>
        </tbody>
    </table>
</div>