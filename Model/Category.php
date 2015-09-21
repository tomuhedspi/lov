<?php

class Category extends AppModel
{

    const INCOME_TYPE  = 1;
    const EXPENSE_TYPE = 0;

    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule'    => 'notBlank',
                'message' => 'Please Enter Category Name!.'
            ),
        ),
        'type' => array(
            'boolean' => array(
                'rule'    => 'boolean',
                'message'  => 'Please Enter Category Type.',
                'required' => true
            ),
        ),
    );

    /**
     * find user money transfer money transaction
     * @param int $userId
     * return int categoryId
     */
    public function findUserTransferMoneyCategory($userId, $isTransfer)
    {
        $data = $this->find('first', array(
            'conditions' => array('Category.is_transfer' => $isTransfer, 'Category.user_id' => $userId),
            'fields'     => array('Category.id'),
        ));
        return $data;
    }

    /**
     * check if category belong user
     * @param  int  $id category id
     * @param  int  $userID : user id
     * @return data array contain all info of category
     */
    public function categoryBelongUser($userId, $id)
    {
        $data = $this->find('first', array(
            'conditions' => array('Category.id' => $id, 'Category.user_id' => $userId)
        ));
        return $data;
    }

    /**
     * get list of  category 's name and id only, used to show in select form
     * @param int $userId
     * @return a list of category, which one element is an array contain category id and category name
     */
    public function getCategoryNameIDList($userId)
    {
        $data = $this->find('list', array(
            'conditions' => array('Category.user_id' => $userId),
            'fields'     => array('Category.id', 'Category.name')
        ));
        return $data;
    }

    /**
     * edit category with change data in $data
     * @param int $id  category id
     * @param array $data  new info data of category
     * @return result of save() function: false if  failure, and an array of data when success
     */
    public function edit($data, $id)
    {
        $this->id = $id;
        return $this->save($data);
    }

    /**
     * add a new category with input data to user who has $userID number
     * @param array $data info of new category
     * @return result of save() function: false if  failure, and an array of data when success
     */
    public function add($data, $userId)
    {
        $this->create();
        $data['user_id'] = $userId;
        return $this->save($data);
    }

    /**
     * getcategory by type : income or expense
     * @param int $userId
     * @param int $type
     * @return : array of categories which has same type
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

    /**
     * get all data of selected category id
     * @param int $id id of selected category
     * @return : array of all info about category
     */
    public function getCategoryById($userId, $id)
    {
        $data = $this->find('first', array('conditions' => array('Category.id' => $id, 'Category.user_id' => $userId)));
        return $data;
    }

}
