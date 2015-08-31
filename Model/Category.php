<?php
class Category extends AppModel
{
    public function addCategory($data,$userId)
    {
        $this->create();
        $this->user_id = $userId;
       return  $this->save($data); 
    }
 
}
?>
