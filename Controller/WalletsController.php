<?php
//Transfer money between wallets
class WalletsController extends AppController
{
    public $uses       = array('Wallet', 'User', 'Transaction', 'Category');
    function setCurrentWallet($walletId)
    {   //check current user
        $userId = $this->Auth->user('id');
        if ($userId== null) {
            $this->Session->setFlash("Please Loggin First!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //check input method
        if (!$this->request->is(array('post', 'put'))) {
            return; 
        }
        //check input parameter
        if (empty($walletId)) {
            $this->Session->setFlash(__('Sorry!Something Occur With Wallet Id!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //set current wallet to user
        $result = $this->User->setUserCurrentWallet($userId,$walletId);
        if(!$result){
            $this->Session->setFlash(__('Cannot Set This Wallet To Default Now, Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            return;   
        }else{
            $this->Session->setFlash(__('Successfully Set To Defaul Wallet!'), 'alert_box', array('class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));   
        }
        
    }
    
    function transfer()
    {
        //get current user id
        $userId = $this->Auth->user('id');
        if ($userId== null) {
            $this->Session->setFlash("Please Loggin First!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //get wallet list then echo to user
        $walletList = $this->Wallet->getWalletNameIDList($userId);
        //set view
        $this->set(array( 'walletList'=>$walletList ));
        
        //transfer money action
        //step1 :check valid input method
        if (!$this->request->is(array('post', 'put'))) {
            return; 
        }
        //step2 : get data input from user
        $data= $this->request->data;
        $fromId = $data['Wallet']['from'];
        $toId   = $data['Wallet']['to']  ;
        $amount =  (double)$data['Wallet']['amount'];
        //check if wallet belongs current user
        if(!$this->Wallet->walletBelongUser($userId,$fromId))
        {
            $this->Session->setFlash(__('Access Denied! Selected Wallets Do Not Belong To You'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
        if(!$this->Wallet->walletBelongUser($userId,$toId))
        {
            $this->Session->setFlash(__('Access Denied! Selected Category Do Not Belong To You'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
       // process transfer
        //step1: check money in wallet and money user want to transfer
        $moneyInFromWallet = $this->Wallet->moneyInWallet($fromId);
        if($amount> $moneyInFromWallet){
            echo'Money From Wallet ='.$moneyInFromWallet;
            $this->Session->setFlash(__('The Transfer Money Amount Is Much More Than Money In Wallet You Take From, Please Enter A Smaller Number! '), 'alert_box', array('class' => 'alert-danger'));   
            return;
        }
        //step2:transfer money between 2 wallet
        $transResult = $this->Wallet->transfer($fromId,$toId,$amount);//transResult variable contain message about transfer process
        if($transResult){
            $this->Session->setFlash(__('Successfully Tranfer Money!'), 'alert_box', array('class' => 'alert-success')); 
            $this->redirect(array('action' => 'index'));
        }else{
            $this->Session->setFlash(__('Temporary Cannot Transfer Money For You Now, Please Try Later!'), 'alert_box', array('class' => 'alert-danger')); 
            $this->redirect(array('action' => 'index')); 
        }
       
    }
            
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
            $data['amount']= (double)$data['amount'];
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
        
        //get user using wallet id :$usingWallet
        $usingWallet=$this->User->getUsingWallet($userId);
        
        //get all waller of current user
        $walletList = $this->Wallet->getAllWalletOfUser($userId);//all data of wallet
        if (empty($walletList) ) {
            $this->Session->setFlash(__('You Dont Have Any Wallet Yet!'), 'alert_box', array('class' => 'alert-danger'));
           // $this->redirect(array('action'=>'add'));
         //   return;
        }

        //set view
        $this->set(array( 'walletList'=>$walletList,'usingWallet'=>$usingWallet ));   
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
        $data['amount']= (double)$data['amount'];
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

