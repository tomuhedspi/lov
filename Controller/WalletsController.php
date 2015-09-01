<?php
class WalletsController extends AppController
{
    function  edit($walletId)
  {
        if (empty($walletId)) {
            $this->Session->setFlash(__('Sorry!Something Occur With Wallet Id!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
                 //auth user have logged in  yet
        $id = $this->Auth->user('id');
        if ($id == null) {
            $this->Session->setFlash("Please Loggin First!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        
        $selectedOne = $this->Wallet->getSelectedById($walletId);
        if($selectedOne)
        {
            //set view
            $selectedName = $selectedOne['Wallet']['name'];
            $this->set(array(
            'selectedName' => $selectedName,
            ));
            //save user change input data
            //step 1 : check input method : 
            if (!$this->request->is(array('post', 'put'))) 
             {
                return; 
             }
            //step 2 : get data from form
            $data = $this->request->data['Wallet']; 
            //step 3 : save change 
            $edit = $this->Wallet->edit($data,$walletId);
            if ($edit) {
                $this->Session->setFlash(__('Update Wallet Successfully !'), 'alert_box', array('class' => 'alert-success'));
            } else {
                $this->Session->setFlash(__('Sorry,Cannot Update Wallet For You Now. Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            }
            $this->redirect(array('action' => 'index'));
          
        }else
        {
          $this->Session->setFlash(__('Something Happen When Getting Wallet Name By Id, Sorry !'), 'alert_box', array('class' => 'alert-danger')); 
          $this->redirect(array('action' => 'index'));
        }
      
    }
    
    function delete($walletId)
    {
         //ENTER CODE HERE
         $this->Session->setFlash(__('Code Delete Doesnt Write Yet !'), 'alert_box', array('class' => 'alert-danger')); 
         $this->redirect(array('action' => 'index'));
    }
            
    function index()//list all Wallet User have
    {
        //get user id
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Loggin Before See Wallet List!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        
        //get list of waller of current user
        $walletList = $this->Wallet->getWalletList($userId);
        if (empty($walletList) ) {
            $this->Session->setFlash(__('You Dont Have Any Wallet Yet!'), 'alert_box', array('class' => 'alert-danger'));
           // $this->redirect(array('action'=>'add'));
         //   return;
        }

        //set view
        $this->set(array( 'walletList'=>$walletList ));   
    }
            
    function  add()
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
        $data = $this->request->data['Wallet'];

        //create new wallet then save data
        $add = $this->Wallet->add($data, $id);
        if ($add) {
            $this->Session->setFlash(__('Add Wallet Successfully !'), 'alert_box', array('class' => 'alert-success'));
        } else {
            $this->Session->setFlash(__('Sorry,Cannot Add A New Wallet Now. Please Try Again Or Contact Producer!'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        $this->redirect(array('action' => 'index'));   
    }
    
    public function beforeFilter() 
    {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('register','add');
     }

}

