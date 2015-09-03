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
        }

        //set view
        $this->set(array(
            'incomeList' => $incomeList,
            'expensList' => $expensList,
        ));
    }

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

    function edit($id)
    {
        if (empty($id)) {
            $this->Session->setFlash(__('Sorry!Something Occur When We Passing Category Id!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //auth user have logged in  yet
        $id = $this->Auth->user('id');
        if ($id == null) {
            $this->Session->setFlash("Please Loggin And Try Again!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        
        $targetCategory = $this->Category->getCategoryById($id);
        if($targetCategory)
        {
            //set view
            $categoryName = $targetCategory['Category']['name'];
            $this->set(array(
            'categoryName' => $categoryName,
            ));
            //save user change input data
            //step 1 : check input method : 
            if (!$this->request->is(array('post', 'put'))) 
             {
                return; 
             }
            //step 2 : get data from form
            $data = $this->request->data['Category']; 
            //step 3 : save change 
            $edit = $this->Category->edit($data,$id);
            if ($edit) {
                $this->Session->setFlash(__('Update Category Successfully !'), 'alert_box', array('class' => 'alert-success'));
            } else {
                $this->Session->setFlash(__('Sorry,Cannot Update Category For You Now. Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            }
            $this->redirect(array('action' => 'index'));
          
        }else
        {
          $this->Session->setFlash(__('Something Happen When Getting Category Name By Id, Sorry !'), 'alert_box', array('class' => 'alert-danger')); 
          $this->redirect(array('action' => 'index'));
        }
      
    }

    function delete($id)
    {
        //ENTER CODE HERE
         $this->Session->setFlash(__('Code Delete Doesnt Write Yet !'), 'alert_box', array('class' => 'alert-danger')); 
          $this->redirect(array('action' => 'index'));
    }

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to do following action
        $this->Auth->allow('index'); //'addCategory','editCategory','deleteCategory'
    }

}
