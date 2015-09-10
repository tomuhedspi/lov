<?php

/**
 * Add/Edit transaction
 * Delete transaction
 * Show transactions by date range, category
 * Monthly report 
 */
class TransactionsController extends AppController
{

    public $uses = array('Transaction', 'Category', 'Wallet', 'User');

    /*
     * view transaction by category
     */

    public function viewByCategory()
    {
        // Check if user logged in
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Login First!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //show category list for user to select
        $categoryList = $this->Category->getCategoryNameIDList($userId);
        $this->set(array('categoryList' => $categoryList));
        //get data input from user
        $data         = $this->request->data;
        $categoryId   = $data['Transaction']['category_id'];
        //get transaction list in selected category
        $transList    = $this->Transaction->getTransactionsInCategory($userId, $categoryId);
        //set view var
        $this->set(array('transList' => $transList,));
    }

    /*
     * income total,expense total
     */

    public function monthReport()
    {
        //get user id
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Loggin Before See Transaction List!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //get transaction of user in this month
        $end          = date('Y-m-d');
        $start        = date('Y-m-d', strtotime('-1 month'));
        $thisMonth    = $this->Transaction->getTransactionsInTime($userId, $start, $end);
        //get income and expense total
        $incomeTotal  = 0;
        $expenseTotal = 0;
        foreach ($thisMonth as $item) {
            if ($item['Category']['type'] == Category::EXPENSE_TYPE) {
                $expenseTotal+= $item['Transaction']['amount'];
            } else {
                $incomeTotal+= $item['Transaction']['amount'];
            }
        }
        //set view
        $this->set(array('transList' => $thisMonth, 'incomeTotal' => $incomeTotal, 'expenseTotal' => $expenseTotal, 'start' => $start, 'end' => $end));
    }

    /*
     * rank transaction by date modified
     */

    public function rankByDate()
    {
        //get user id
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->_setAlertMessage(__('Sorry!Sending Transaction Id Failed!Please Try Later'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //get user's transaction list
        $transList = $this->Transaction->getUserTransactionsDateRank($userId);
        //set view
        $this->set(array('transList' => $transList));
    }

    /*
     * a user edit page for user to put edit info
     * @param int $id transaction id to edit, get from browser
     */

    public function edit($id)
    {
        //check variable
        if (empty($id)) {
            $this->Session->setFlash(__('Sorry!Sending Transaction Id Failed!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        // Check if user logged in
        $userId = $this->Auth->user('id');
        if ($userId == null) {
            $this->Session->setFlash("Please Login First!");
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        //check and get data of seleected transaction  id
        $selectTransaction = $this->Transaction->transactionBelongUser($userId, $id);
        if (!$selectTransaction) {
            $this->_setAlertMessage(__('Access Denied! Selected Wallets Do Not Belong To You'));
            $this->redirect(array('action' => 'index'));
        }
        //get wallet and category list then echo to user
        $walletList   = $this->Wallet->getWalletNameIDList($userId);
        $categoryList = $this->Category->getCategoryNameIDList($userId);
        //set view vars
        $this->set(array('walletList' => $walletList, 'categoryList' => $categoryList, 'item' => $selectTransaction));

        //check valid input method
        if (!$this->request->is(array('post', 'put'))) {
            return;
        }
        // Validate inputs
        $this->Transaction->set($this->request->data);
        $valid = $this->Transaction->validates();
        if (!$valid) {
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
            $data['Transaction']['amount'] = - $data['Transaction']['amount'];
        }
        //caculate new money amount in wallet
        $data['Wallet']['amount'] = $selectWallet['Wallet']['amount'] + $data['Transaction']['amount'] - $selectTransaction['Transaction']['amount'];
        //check if enough money to expense
        if ($data['Wallet']['amount'] < 0) {
            $this->_setAlertMessage(__('Do Not Enough Money !'));
            return;
        }
        //save transaction
        $result = $this->Transaction->edit($data, $id);
        if ($result) {
            $this->Session->setFlash(__('Successfully Add Transaction!'), 'alert_box', array('class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->_setAlertMessage(__('Temporary Cannot Add Transaction, Please Try Later!'));
            $this->redirect(array('action' => 'index'));
        }
    }

    /* xoa mot transaction se hoan tra lai so tien ma transaction da su dung
     * @param int $id transaction id
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
        if ($this->Transaction->deleteTransaction($id, $selectTransaction)) {
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
        // Validate inputs
        $this->Transaction->set($this->request->data);
        $valid = $this->Transaction->validates();
        if (!$valid) {
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
            $data['Transaction']['amount'] = - $data['Transaction']['amount'];
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
