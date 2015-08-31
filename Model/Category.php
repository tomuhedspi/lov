<?php

class Category extends AppModel
{

    public function addCategory($data, $userId)
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

}
