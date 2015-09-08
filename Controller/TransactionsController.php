<?php

/**
 * Add/Edit transaction
 * Delete transaction
 * Show transactions by date range, category
 * Monthly report 
 */
class TransactionsController extends AppController
{

    public $uses = array('Transaction', 'Wallet', 'User', 'Category');

    public function edit($id)
    {
        
    }

    /* xoa mot transaction se hoan tra lai so tien ma transaction da su dung
     * param: $id: transaction id
     */

    public function delete($id)
    {
        //check variable
        if (empty($id)) {
            $this->Session->setFlash(__('Sorry!Sending Transaction Id Failed!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //step 2: check user is logged in?
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("You Are Logging Out, Please Login First!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //step 3: check valid input method
        if (!$this->request->is(array('post', 'put'))) {
            return;
        }
        //step 4: check if selected transaction is own by current user
        $selectTransaction = $this->Transaction->transactionBelongUser($userId, $id);
        if (!$selectTransaction) {
            $this->Session->setFlash(__('Access Denied! Selected Transaction Do Not Belong To You'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
        //step 5: update amount in wallet
        $selectTransaction['Wallet']['amount'] = $selectTransaction['Wallet']['amount'] - $selectTransaction['Transaction']['amount'];
       // $selectTransaction['Wallet']['id']     = $selectTransaction['Wallet']['id'] + 0;
        if ($this->Transaction->deleteTransaction($id,$selectTransaction)) {
            $this->Session->setFlash(__('Successfully Delete Transaction !'), 'alert_box', array('class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('Cannot Delete Selected Transaction, Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
    }
    /*
     * get data from user and add a new transaction
     */
    public function add()
    {
        // Check if user logged in
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Login First!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //get wallet and category list then echo to user
        $walletList   = $this->Wallet->getWalletNameIDList($userId);
        $categoryList = $this->Category->getCategoryNameIDList($userId);
        //set view vars
        $this->set(array('walletList' => $walletList, 'categoryList' => $categoryList));

        //check valid input method
        if (!$this->request->is(array('post', 'put'))) {
            return;
        }
        //get data input from user
        $data                          = $this->request->data;
        $walletId                      = $data['Transaction']['wallet_id'];
        $data['Wallet']['id']          = $walletId;
        $categoryId                    = $data['Transaction']['category_id'];
        $data['Transaction']['amount'] = abs((double) $data['Transaction']['amount']);
        //check if wallet belongs current user
        $selectWallet                  = $this->Wallet->walletBelongUser($userId, $walletId);
        if (!$selectWallet) {
            $this->_setAlertMessage(__('Access Denied! Selected Wallets Do Not Belong To You'));
            return;
        }
        $selectCategory = $this->Category->categoryBelongUser($userId, $categoryId);
        if (!$selectCategory) {
            $this->_setAlertMessage(__('Access Denied! Selected Category Do Not Belong To You'));
            return;
        }
        //neu la category thu nhap thi tien trong vi tang len, = so tien trong vi hien co + so tien chi tieu cua transaction
        //neu la category chi tieu thi tien trong vi mang dau am
        if ($selectCategory['Category']['type'] == Category::EXPENSE_TYPE) {
          $data['Transaction']['amount']= - $data['Transaction']['amount'];  
        }
        //caculate new money amount in wallet
        $data['Wallet']['amount'] = $selectWallet['Wallet']['amount'] + $data['Transaction']['amount'];        
        //check if enough money to expense
        if ($data['Wallet']['amount'] < 0) {
            $this->_setAlertMessage(__('Do Not Enough Money,Cannot Add Transaction !'));
            return;
        }
        //save transaction
        $result = $this->Transaction->add($data, $userId);
        if ($result) {
            $this->Session->setFlash(__('Successfully Add Transaction!'), 'alert_box', array('class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->_setAlertMessage(__('Temporary Cannot Add Transaction, Please Try Later!'));
            $this->redirect(array('action' => 'index'));
        }
    }
    /*
     * show all user transaction
     */
    public function index()
    {
        //get user id
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Loggin Before See Transaction List!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //get user's transaction list
        $transList = $this->Transaction->getUserTransactions($userId);
        //set view
        $this->set(array('transList' => $transList));
    }

}
