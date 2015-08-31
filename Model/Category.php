<?php
class Category extends AppModel
{
    public function addCategory($data,$userId)
    {
        $this->create();
        $data['user_id']= $userId;
       return  $this->save($data); 
    }
 
    public function getCategoriesByType($userId,$type)
    {
            $m_query = array
            (
               'condition' => array
               (
                  'Category.user_id' =>$userId,
                  'Category.type'=>$type
                )
            );
            $data= $this->find('all', $m_query);
            //if not match userid and token
            return $data;      
    }
}
?>
