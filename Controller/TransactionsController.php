<?php 
/**
* Add/Edit transaction
* Delete transaction
* Show transactions by date range, category
* Monthly report 
 */
class TransactionsController extends AppController
{
    
    public $uses       = array('Transaction','Wallet', 'User',  'Category');
    
    public function edit($id)
    {
        
    }
    /* xoa mot transaction se hoan tra lai so tien ma transaction da su dung
     * 
     */
    public function delete($id)//$id is transaction id
    {
        //step 1: check variable
        if (empty($id)) {
            $this->Session->setFlash(__('Sorry!Sending Transaction Id Failed!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //step 2: check user is logged in?
        $userId = $this->Auth->user('id');
        if ($userId== null) {
            $this->Session->setFlash("You Are Logging Out, Please Login First!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        } 
        //step 3: check valid input method
        if (!$this->request->is(array('post', 'put'))) {
            return; 
        }
        //step 4: check if selected transaction is own by current user
        if(!$this->Transaction->transactionBelongUser($userId, $id)){
            $this->Session->setFlash(__('Access Denied! Selected Transaction Do Not Belong To You'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
        //step 5: delete transaction
        if($this->Transaction->delete($id,false)){
            $this->Session->setFlash(__('Successfully Delete Transaction'), 'alert_box', array('class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));  
        }  else {
            $this->Session->setFlash(__('Cannot Delete Selected Transaction, Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
        
    }

    public function add()
    {
         //get current user id
        $userId = $this->Auth->user('id');
        if ($userId== null) {
            $this->Session->setFlash("Please Loggin First!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //get wallet and category list then echo to user
        $walletList = $this->Wallet->getWalletNameIDList($userId);
        $categoryList = $this->Category->getCategoryNameIDList($userId);
        //set view
        $this->set(array( 'walletList'=>$walletList,'categoryList'=>$categoryList ));
        
        //step1 :check valid input method
        if (!$this->request->is(array('post', 'put'))) {
            return; 
        }
        //step2 : get data input from user
        $data= $this->request->data;
        $walletId = $data['Transaction']['wallet_id'];
        $categoryId   = $data['Transaction']['category_id']  ;
        $data['Transaction']['amount'] =  (double)$data['Transaction']['amount'];
        //check if wallet belongs current user
        $selectWallet = $this->Wallet->walletBelongUser($userId,$walletId);
        if(!selectWallet)
        {
            $this->Session->setFlash(__('Access Denied! Selected Wallets Do Not Belong To You'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        $selectCategory= $this->Category->categoryBelongUser($userId,$categoryId);
        if(!$selectCategory)
        {
            $this->Session->setFlash(__('Access Denied! Selected Category Do Not Belong To You'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //neu la category thu nhap thi tien trong vi tang len, = so tien trong vi hien co + so tien chi tieu cua transaction
        //neu la category chi tieu thi tien trong vi giam di
        if($selectCategory['Category']['type']== 1){
            $data['Wallet']['amount'] = $selectWallet['Wallet']['amount'] + $data['Transaction']['amount'];
        }
        if($selectCategory['Category']['type']== 0){
            $data['Wallet']['amount'] = $selectWallet['Wallet']['amount'] - $data['Transaction']['amount'];
            if($data['Wallet']['amount'] < 0){ //check if enough money to expense
                $this->Session->setFlash(__('Do Not Enough Money !'), 'alert_box', array('class' => 'alert-danger'));
            return;  
            }
        }
        //add transaction
        $result = $this->Transaction->add($data,$userId);
        if($result){
            $this->Session->setFlash(__('Successfully Tranfer Money!'), 'alert_box', array('class' => 'alert-success')); 
            $this->redirect(array('action' => 'index'));
        }else{
            $this->Session->setFlash(__('Temporary Cannot Transfer Money For You Now, Please Try Later!'), 'alert_box', array('class' => 'alert-danger')); 
            $this->redirect(array('action' => 'index')); 
        }
       
    }
    
    public function index()
    {
        //get user id
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Loggin Before See Transaction List!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //get user's transaction list
        $transList= $this->Transaction->getUserTransactions($userId);
        //set view
        $this->set(array('transList'=>$transList));
    }
 
}