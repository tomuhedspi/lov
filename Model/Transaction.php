<?php

class Transaction extends AppModel
{

    public $name      = 'Transaction';
    public $validate  = array(
        'content'     => array(
            'notEmpty' => array(
                'rule'    => 'notBlank',
                'message' => 'Please Enter Money Amount Here!.'
            ),
        ),
        'amount'      => array(
            'notEmpty' => array(
                'rule'    => 'notBlank',
                'message' => 'Please Enter Money Amount Here!.'
            ),
        ),
        'wallet_id'   => array(
            'notEmpty' => array(
                'rule'    => 'notBlank',
                'message' => 'Please Select A Wallet!.'
            ),
        ),
        'category_id' => array(
            'notEmpty' => array(
                'rule'    => 'notBlank',
                'message' => 'Please Select Category!.'
            ),
        ),
    );
    /*
     * relation with associate model
     */
    public $belongsTo = array(
        'Wallet'   => array(
            'className'  => 'Wallet',
            'foreignKey' => 'wallet_id'
        ),
        'Category' => array(
            'className'  => 'Category',
            'foreignKey' => 'category_id'
        )
    );

    /*
     * get user transaction in selected category
     * @param int $userId id of current user
     * @param int $categoryId id of user's selected category
     * @return array of transaction which in selected category
     */

    public function getTransactionsInCategory($userId, $categoryId)
    {
        $data = $this->find('all', array(
            'conditions' => array(
                'Transaction.user_id'     => $userId,
                'Transaction.category_id' => $categoryId
            ),
            'fields'     => array('Transaction.id', 'Transaction.content', 'Transaction.amount', 'Transaction.modified', 'Transaction.created', 'Category.name', 'Category.type', 'Wallet.name'),
            'order'      => array('Transaction.modified')
        ));
        return $data;
    }

    /*
     * user's transaction in current month
     * @param int $userId
     * @param time $start 
     * @param time $end
     * @return array of transactions which is created between $start time and $end time
     */

    public function getTransactionsInTime($userId, $start, $end)
    {
        $data = $this->find('all', array(
            'conditions' => array(
                'Transaction.user_id'    => $userId,
                'Transaction.created >=' => $start,
                'Transaction.created <=' => $end
            ),
            'fields'     => array('Transaction.id', 'Transaction.content', 'Transaction.amount', 'Transaction.modified', 'Transaction.created', 'Category.name', 'Category.type', 'Wallet.name'),
            'order'      => array('Transaction.modified')
        ));
        return $data;
    }

    /*
     * all user transaction rank by date
     * @param int $userId
     * @return all info of all transaction of user which sorted by date
     */

    public function getUserTransactionsDateRank($userId)
    {
        $data = $this->find('all', array(
            'conditions' => array('Transaction.user_id' => $userId),
            'fields'     => array('Transaction.id', 'Transaction.content', 'Transaction.amount', 'Transaction.modified', 'Transaction.created', 'Category.name', 'Wallet.name'),
            'order'      => array('Transaction.modified')
        ));
        return $data;
    }

    /*
     * delete transaction function, use transaction commit and rollback
     * @param  int $id: transaction_id,  
     * @param  array  $data : data which contain updated wallet amount when delete a transaction
     * @return value : true or false (result of commit and rollback)
     */

    public function edit($data, $id)
    {
        $this->id = $id;
        return $this->saveAssociated($data);
    }

    /*
     * delete a transaction , with related amount in wallet, user transaction to make sure that all action come completely
     * @param int $id id of transaction
     * @param array $data relate data in other model, eg: delete a buy car transaction will return the money to wallet
     * @return result of commit or rollback: true if success, false if failure
     */

    public function deleteTransaction($id, $data)
    {
        $dataSource = $this->getDataSource();
        $dataSource->begin();
        $result1    = $this->saveAssociated($data);
        $result2    = $this->delete($id);

        if ($result1 && $result2) {
            return $dataSource->commit();
        } else {
            return $dataSource->rollback();
        }
    }

    /*
     * check if this transaction belong current user
     * @param int $userId  userID 
     * @param int $id  transaction ID
     * @return value: all data associate with selected transaction and current user ( sometime use that returnvalue, eg:money amount in wallet, so it not return true - false)
     */

    public function transactionBelongUser($userId, $id)
    {
        $data = $this->find('first', array(
            'conditions' => array('Transaction.id' => $id, 'Transaction.user_id' => $userId)
        ));
        return $data;
    }

    /*
     * add a new transaction with related data,which contain new wallet money amount,...
     * @param array $data user input data and related data( update wallet money amount)
     * @param int $userId
     * @return true false (result of saveAssociate function)
     */

    public function add($data, $userId)
    {
        $this->create();
        $data['Transaction']['user_id'] = $userId;
//        return $this->save($data);
        return $this->saveAssociated($data);
    }

    /*
     * all transaction of user which has $userId
     * @param  int $userId
     * @return value contain in an array(not a list )
     */

    public function getUserTransactions($userId)
    {
        $data = $this->find('all', array(
            'conditions' => array('Transaction.user_id' => $userId),
            'fields'     => array('Transaction.id', 'Transaction.content', 'Transaction.amount', 'Category.name', 'Wallet.name'),
        ));
        return $data;
    }

    /*
     * get all transaction which belong a selected category
     * @param int $id  category id
     * @return an array of all transaction related with selected category
     */

    public function transactionBelongCategory($id)
    {
        $data = $this->find('all', array(
            'conditions' => array('Transaction.category_id' => $id)
        ));
        return $data;
    }

    /*
     * get all transaction which belong a selected wallet
     * @param int $id  category id
     * @return an array of all transaction ralated with selected wallet
     */

    public function transactionBelongWallet($id)
    {
        $data = $this->find('all', array(
            'conditions' => array('Transaction.wallet_id' => $id)
        ));
        return $data;
    }

}
