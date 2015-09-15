<?php

/**
 * Category controller
 */
class CategoriesController extends AppController
{

    public $helpers    = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Auth');
    public $uses       = array('Category', 'Transaction', 'Wallet', 'User');

    /**
     * get list transaction in category, used when user click into a category in category list
     */
    public function viewTransactionsInCategory($categoryId)
    {
        $userId = $this->Auth->user('id');
        if (!$userId) {
            $this->_setAlertMessage(__('Please Loggin First'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $data      = $this->Category->getCategoryById($userId, $categoryId);
        $transList = $this->Transaction->getTransactionsInCategory($userId, $categoryId);
        //set view var
        $this->set(array('transList' => $transList, 'categoryId' => $categoryId, 'categoryName' => $data['Category']['name']));
    }

    /**
     * show category list and it's option and link to another action
     */
    function index()
    {
        $incomeType = 1;
        $expensType = 0;

        //get user id
        $id = $this->Auth->user('id');
        if ($id == null) {
            $this->_setAlertMessage(__('Please Loggin Before See Category List'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $incomeList = $this->Category->getCategoriesByType($id, $incomeType);
        $expensList = $this->Category->getCategoriesByType($id, $expensType);

        if (empty($incomeList) && empty($expensList)) {
            $this->Session->setFlash(__('Empty Categories List ! Please Add Some New Categories!'), 'alert_box', array('class' => 'alert-danger'));
        }

        //set view
        $this->set(array(
            'incomeList' => $incomeList,
            'expensList' => $expensList,
        ));
    }

    /**
     * add a new category
     */
    function add()
    {
        if (!$this->request->is(array('post', 'put'))) {
            return;
        }
        //get user id   
        $id = $this->Auth->user('id');
        if ($id == NULL) {
            $this->Session->setFlash('Please Login And Try Again!');
            return;
        }
        // Validate inputs
        $this->Category->set($this->request->data);
        $valid = $this->Category->validates();
        if (!$valid) {
            return;
        }
        //get user data input
        $data = $this->request->data['Category'];

        //create new category then save data
        $add = $this->Category->add($data, $id);
        if ($add) {
            $this->Session->setFlash(__('Add Category Successfully !'), 'alert_box', array('class' => 'alert-success'));
        } else {
            $this->Session->setFlash(__('Sorry, We Cannot Add A New Category For You Now. Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     * edit a new category
     * @param int $id id of category to edit
     */
    function edit($id)
    {
        if (empty($id)) {
            $this->Session->setFlash(__('Sorry!Something Occur When We Passing Category Id!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //auth user have logged in  yet
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Loggin And Try Again!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $targetCategory = $this->Category->getCategoryById($userId, $id);
        if (!$targetCategory) {
            $this->Session->setFlash(__('You Cannot Edit This Category !'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
        //set view
        $this->set(array(
            'item' => $targetCategory,
        ));
        //save user change input data
        //step 1 : check input method : 
        if (!$this->request->is(array('post', 'put'))) {
            return;
        }
        // Validate inputs
        $this->Category->set($this->request->data);
        $valid = $this->Category->validates();
        if (!$valid) {
            return;
        }
        //step 2 : get data from form
        $data = $this->request->data['Category'];
        //step 3 : save change 
        $edit = $this->Category->edit($data, $id);
        if ($edit) {
            $this->Session->setFlash(__('Update Category Successfully !'), 'alert_box', array('class' => 'alert-success'));
        } else {
            $this->Session->setFlash(__('Sorry,Cannot Update Category For You Now. Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     * delete a category
     * cannot delete a category which has transaction has relation with it
     * @param int $id id of selected category to delete
     */
    function delete($id)
    {
        if (empty($id)) {
            $this->Session->setFlash(__('Sorry!Something Occur When We Passing Category Id!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //auth user have logged in  yet
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Loggin And Try Again!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //check if selected category belong user
        if (!$this->Category->categoryBelongUser($userId, $id)) {
            $this->_setAlertMessage(__('You Do Not Have Right To Delete This Category !'));
            $this->redirect(array('action' => 'index'));
        }
        //check if are there any transaction related with selected category
        if ($this->Transaction->transactionBelongCategory($id)) {
            $this->_setAlertMessage(__('Cannot Delete This Category, There Are Transactions Related To It!'));
            $this->redirect(array('action' => 'index'));
        }
        //delete category
        if ($this->Category->delete($id)) {
            $this->Session->setFlash(__('Successfully Delete Category'), 'alert_box', array('class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->_setAlertMessage(__('Cannot Delete Category,Please Try Later !'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to do following action
        $this->Auth->allow('index'); //'addCategory','editCategory','deleteCategory'
    }

}
