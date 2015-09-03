<?php

class Category extends AppModel
{

    public function edit($data,$id)
    {
        $this->id = $id;
        return $this->save($data);
    }
    
    public function add($data, $userId)
    {
        $this->create();
        $data['user_id'] = $userId;
        return $this->save($data);
    }

    public function getCategoriesByType($id, $type)
    {
        $data = $this->find('all', array(
            'conditions' => array(
                $this->alias . '.user_id' => $id,
                'Category.type'           => $type,
            ),
        ));
        return $data;
    }
    
    public function getCategoryById($id)
    {
        $data = $this->find('first', array
            (
            'conditions' => array('Category.id' => $id)
            ));
        return $data;
    }

}
