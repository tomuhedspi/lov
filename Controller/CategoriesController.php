<!--        * Add/Edit category
         * Delete category-->
<?php
    class CategoriesController extends AppController
    {
       public $helpers = array('Html','Form','Session');
       public $components = array('Session','Auth');
        
       function index()
       {
           
       }
       
       function  addCategory()
       {
            if (!$this->request->is(array('post', 'put'))) 
             {
                return;
             }
          //get user id   
         $id = $this->Auth->user('id');
         if ($id == NULL)
         {
             $this->Session->setFlash('Please Login And Try Again!');
             return;
         }
         //get user data input
         $data = $this->request->data['Category'];
         
         //create new category then save data
         $add = $this->Category->addCategory($data,$id);
         if ($add)
            {
                $this->Session->setFlash(__('Add Category Successfully !'), 'alert_box', array('class' => 'alert-success'));
            }
         else
            {
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
            $this->Auth->allow('index','addCategory','editCategory','deleteCategory');
         }

       
    }

?>
