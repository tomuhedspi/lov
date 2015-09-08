<?php

class Category extends AppModel
{
    const INCOME_TYPE  = 1;
    const EXPENSE_TYPE = 0;
    /*
     * check if category belong user
     * param : $id: category id
     *          $userID : user id
     */
    public function categoryBelongUser($userId,$id)
    {
        $data = $this->find('first',array(
               'conditions' => array( 'Category.id'=>$id,'Category.user_id' => $userId)
                ));
        return $data; 
    }
    /*
     * get list of  category 's name and id only, used to show in select form
     */
    public function getCategoryNameIDList($userId)
    {
        $data = $this->find('list',array(
                    'conditions' => array('Category.user_id' => $userId),
                    'fields' => array('Category.id', 'Category.name')
                      ));
        return $data;  
    }
    /*
     * edit category with change data in $data
     * param : $id : category id
     *          $data : new info data of category
     */
    public function edit($data,$id)
    {
        $this->id = $id;
        return $this->save($data);
    }
    /*
     * add a new category with input data to user who has $userID number
     * param : $data: info of new category
     */
    public function add($data, $userId)
    {
        $this->create();
        $data['user_id'] = $userId;
        return $this->save($data);
    }
    /*
     * getcategory by type : income or expense
     * return : array of same type category
     */
    public function getCategoriesByType($userId, $type)
    {
        $data = $this->find('all', array(
            'conditions' => array(
                $this->alias . '.user_id' => $userId,
                'Category.type'           => $type,
            ),
            ));
        return $data;
    }
    /*
     *get all data of selected category id
     */
    public function getCategoryById($id)
    {
        $data = $this->find('first', array(
            'conditions' => array('Category.id' => $id)
            ));
        return $data;
    }

}
