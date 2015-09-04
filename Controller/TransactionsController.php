<?php
//         * Add/Edit transaction
//         * Delete transaction
//         * Show transactions by date range, category
//         * Monthly report sao the nay
class TransactionsController extends AppController
{
    
    public $uses       = array('Wallet', 'User', 'Transaction', 'Category');
    
    function add()
    {
        //get user id   
        $userId = $this->Auth->user('id');
        if ($userId == NULL) {
            $this->Session->setFlash('Please Login And Try Again!');
            return;
        }
        //get data to show wallets list and categories list
        $walletList = $this->Wallet->getWalletNameIDList($userId);
        $categoryList = $this->Category->getCategoryNameIDList($userId);
        //set view
        $this->set(array('walletList'=>$walletList,'categoryList'=>$categoryList));
        //check request data
        if (!$this->request->is(array('post', 'put'))) {
            return;
        }
        //get user data input 
        $data = $this->request->data['Transaction'];
        $data['amount']= (double)$data['amount'];
        $walletId = $data['walletNumber'];
        $categoryId = $data['walletNumber'];
        
        //check wallet and category belongs user
        if(!$this->Wallet->walletBelongUser($userId,$walletId))
        {
            $this->Session->setFlash(__('Access Denied! Please Select Wallets Belong To You!'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        if(!$this->Category->categoryBelongUser($userId,$categoryId))
        {
            $this->Session->setFlash(__('Access Denied! Please Select Category  Belong To You!'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //create new transaction then save data
        $add = $this->Transaction->add($data['Transaction'], $userId);
        if ($add) {
            $this->Session->setFlash(__('Successfully Adding New Transaction !'), 'alert_box', array('class' => 'alert-success'));
        } else {
            $this->Session->setFlash(__('Cannot Add A New Transaction Now. Please Try Again Or Contact Producer!'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        $this->redirect(array('action' => 'index'));
    }
            
    function index()
    {
        //get user id
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Loggin Before See Transaction List!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //get user's transaction list
        $transList= $this->Transaction->getTransactionList($userId);
        //set view
        $this->set(array('transList'=>$transList));
    }
 
}