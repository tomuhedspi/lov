<?php

class WalletsController extends AppController
{

    public $uses = array('Wallet', 'Transaction', 'Category', 'User');

    /**
     * set selected wallet to current wallet of current user
     * @param int $walletId
     */
    public function setCurrentWallet($walletId)
    {   //get user ID
        $userId = $this->Auth->user('id');
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
        $result = $this->User->setUserCurrentWallet($userId, $walletId);
        if (!$result) {
            $this->Session->setFlash(__('Cannot Set This Wallet To Default Now, Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            return;
        } else {
            $this->Session->setFlash(__('Successfully Set To Defaul Wallet!'), 'alert_box', array('class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * transfer money between wallet
     */
    public function transfer()
    {
        //get current user id
        $userId = $this->Auth->user('id');
        //get wallet list then echo to user
        $walletList = $this->Wallet->getWalletNameIDList($userId);
        $emptyFrom  = ''; //notice to select wallet
        $emptyTo    = '';
        //set view
        $this->set(array('walletList' => $walletList, 'emptyFrom' => $emptyFrom, 'emptyTo' => $emptyTo));

        //transfer money action
        //step1 :check valid input method
        if (!$this->request->is(array('post', 'put'))) {
            return;
        }
        // Validate inputs
        $this->Wallet->set($this->request->data);
        $valid = $this->Wallet->validates();
        if (!$valid) {
            return;
        }
        //step2 : get data input from user
        $data   = $this->request->data;
        $fromId = $data['Wallet']['from'];
        $toId   = $data['Wallet']['to'];
        $amount = abs((double) $data['Wallet']['amount']);
        if (empty($fromId)) {
            $emptyFrom = 'Please Select Wallet To Get Money From';
            $this->set(array('emptyFrom' => $emptyFrom));
            return;
        }
        if (empty($toId)) {
            $emptyTo = 'Please Select Wallet To Put Money';
            $this->set(array('emptyTo' => $emptyTo));
            return;
        }
        //check if wallet belongs current user
        if (!$this->Wallet->walletBelongUser($userId, $fromId)) {
            $this->Session->setFlash(__('Access Denied! The From Wallets Do Not Belong To You'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->Wallet->walletBelongUser($userId, $toId)) {
            $this->Session->setFlash(__('Access Denied! The To Wallet Do Not Belong To You'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
        // process transfer
        //step1: check money in wallet and money user want to transfer
        $moneyInFromWallet = $this->Wallet->moneyInWallet($fromId);
        if ($amount > $moneyInFromWallet) {
            echo'Money From Wallet =' . $moneyInFromWallet;
            $this->Session->setFlash(__('The Transfer Money Amount Is Much More Than Money In Wallet You Take From, Please Enter A Smaller Number! '), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //step2:transfer money between 2 wallet
        $transResult = $this->Wallet->transfer($fromId, $toId, $amount); //transResult variable contain message about transfer process
        if ($transResult) {
            $createTransaction = $this->_createTransferTransaction($userId, $amount, $fromId, $toId);
            if (!$createTransaction) {
                $this->Session->setFlash(__('Successfully Tranfer Money But Create Transaction Name Failed!'), 'alert_box', array('class' => 'alert-success'));
                //  $this->redirect(array('action' => 'index'));
                return;
            }
            $this->Session->setFlash(__('Successfully Tranfer Money!'), 'alert_box', array('class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('Temporary Cannot Transfer Money For You Now, Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * create a transfer money transaction
     * tao transaction voi category co is_transfer = true
     * trong transaction co wallet_id va second_walletId
     * chi tao transaction, khong update tien cua cac wallet
     */
    private function _createTransferTransaction($userId, $amount, $fromId, $toId)
    {
        $isTransfer = true;
        $categoryId = $this->Category->findUserTransferMoneyCategory($userId, $isTransfer);
        if (!$categoryId) {
            $thongbao = "khong tim thay categoryId";
            debug($thongbao);
            return false;
        }
        $data['Transaction']['amount']           = $amount;
        $data['Transaction']['wallet_id']        = $fromId;
        $data['Transaction']['second_wallet_id'] = $toId;
        $data['Transaction']['category_id']      = $categoryId['Category']['id'];
        $data['Transaction']['user_id']          = $userId;
        $data['Transaction']['content']          = 'chuyen tien qua vi';
        $result                                  = $this->Transaction->addTransferTransaction($data);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * edit wallet info
     * @param int $walletId
     */
    function edit($walletId)
    {
        if (empty($walletId)) {
            $this->Session->setFlash(__('Sorry!Something Occur With Wallet Id!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        $selectedOne = $this->Wallet->getSelectedById($walletId);
        if ($selectedOne) {
            //set view
            $this->set(array(
                'item' => $selectedOne,
            ));
            //save user change input data
            //step 1 : check input method : 
            if (!$this->request->is(array('post', 'put'))) {
                return;
            }
            // Validate inputs
            $this->Wallet->set($this->request->data);
            $valid = $this->Wallet->validates();
            if (!$valid) {
                return;
            }
            //step 2 : get data from form
            $data           = $this->request->data['Wallet'];
            $data['amount'] = abs((double) $data['amount']);
            //step 3 : save change 
            $edit           = $this->Wallet->edit($data, $walletId);
            if ($edit) {
                $this->Session->setFlash(__('Update Wallet Successfully !'), 'alert_box', array('class' => 'alert-success'));
            } else {
                $this->Session->setFlash(__('Sorry,Cannot Update Wallet For You Now. Please Try Later!'), 'alert_box', array('class' => 'alert-danger'));
            }
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('Something Happen When Getting Wallet Name By Id, Sorry !'), 'alert_box', array('class' => 'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * list all Wallet User have
     */
    function index()
    {
        //get user id
        $userId = $this->Auth->user('id');

        //get user using wallet id :$usingWallet
        $usingWallet = $this->User->getUsingWallet($userId);

        //get all waller of current user
        $walletList = $this->Wallet->getUserWallets($userId); //all data of wallet
        if (empty($walletList)) {
            $this->Session->setFlash(__('You Dont Have Any Wallet Yet!'), 'alert_box', array('class' => 'alert-danger'));
        }

        //set view
        $this->set(array('walletList' => $walletList, 'usingWallet' => $usingWallet));
    }

    /**
     * add a wallet
     */
    function add()
    {
        if (!$this->request->is(array('post', 'put'))) {
            return;
        }
        //get user id   
        $id = $this->Auth->user('id');
        // Validate inputs
        $this->Wallet->set($this->request->data);
        $valid = $this->Wallet->validates();
        if (!$valid) {
            return;
        }
        //get user data input
        $data           = $this->request->data['Wallet'];
        $data['amount'] = abs((double) $data['amount']);
        //create new wallet then save data
        $add            = $this->Wallet->add($data, $id);
        if ($add) {
            $this->Session->setFlash(__('Add Wallet Successfully !'), 'alert_box', array('class' => 'alert-success'));
        } else {
            $this->Session->setFlash(__('Sorry,Cannot Add A New Wallet Now. Please Try Again Or Contact Producer!'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     * delete a wallet
     * cannot delete a delete which has transaction has relation with it
     * @param int $id  wallet id
     */
    function delete($id)
    {
        if (empty($id)) {
            $this->Session->setFlash(__('Sorry!Something Occur When We Passing Category Id!Please Try Later'), 'alert_box', array('class' => 'alert-danger'));
            return;
        }
        //get user id
        $userId = $this->Auth->user('id');
        //check if are there any transaction related with selected wallet
        if ($this->Transaction->transactionBelongWallet($id)) {
            $this->_setAlertMessage(__('Cannot Delete This Category, There Are Transactions Related To It!'));
            $this->redirect(array('action' => 'index'));
        }
        //check if selected wallet belong user
        if (!$this->Wallet->walletBelongUser($userId, $id)) {
            $this->_setAlertMessage(__('You Do Not Have Right To Delete This Wallet !'));
            $this->redirect(array('action' => 'index'));
        }
        //delete wallet
        if ($this->Wallet->delete($id)) {
            $this->Session->setFlash(__('Successfully Delete Wallet'), 'alert_box', array('class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->_setAlertMessage(__('Cannot Delete Wallet,Please Try Later !'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
