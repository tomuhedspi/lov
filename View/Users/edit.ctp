<h3> Edit User Avatar </h3>
<?php
echo $this->Form->create('Image', array('type' => 'file'));
echo $this->Form->input('img', array('type' => 'file','label'=> 'Select Image'));
echo $this->Form->submit('Upload Images');