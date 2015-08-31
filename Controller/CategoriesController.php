<?php

/**
 * Category controller
 */
class CategoriesController extends AppController
{

    public $helpers    = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Auth');

    function index()
    {
        $incomeType = 1;
        $expensType = 0;

        //get user id
        $id = $this->Auth->user('id');
        if ($id == null) {
            $this->Session->setFlash("Please Loggin Before See Category List!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $incomeList = $this->Category->getCategoriesByType($id, $incomeType);
        $expensList = $this->Category->getCategoriesByType($id, $expensType);

        if (empty($incomeList) && empty($expensList)) {
            $this->Session->setFlash(__('Empty Categories List ! Please Add Some New Categories!'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }

        //set view
        $this->set(array(
            'incomeList' => $incomeList,
            'expensList' => $expensList,
        ));
    }

    function addCategory()
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
        //get user data input
        $data = $this->request->data['Category'];

        //create new category then save data
        $add = $this->Category->addCategory($data, $id);
        if ($add) {
            $this->Session->setFlash(__('Add Category Successfully !'), 'alert_box', array('class' => 'alert-success'));
        } else {
            $this->Session->setFlash(__('Sorry, We Cannot Add A New Category For You Now. Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        $this->redirect(array('action' => 'index'));
    }

    function editCategory()
    {
        
    }

    function deleteCategory()
    {
        
    }

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('index'); //'addCategory','editCategory','deleteCategory'
    }

}
