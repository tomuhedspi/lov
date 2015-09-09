<?php
class Transaction extends AppModel
{
    public $belongsTo = array(
        'Wallet' => array(
            'className' => 'Wallet',
            'foreignKey' => 'wallet_id'
        ),
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id'
        )
    );
    /*
     * user's transaction in current month
     */
    public function getTransactionsInTime($userId,$start,$end)
    {    
        $data = $this->find('all',array(
                    'conditions' => array(
                        'Transaction.user_id'   => $userId,
                        'Transaction.created >=' => $start,
                        'Transaction.created <=' => $end
                        ),
                    'fields'=>array('Transaction.id','Transaction.content','Transaction.amount','Transaction.modified','Transaction.created','Category.name','Category.type','Wallet.name'),
                    'order' => array('Transaction.modified')
                      ));
        return $data;   
    }
    
    /*
     * all user transaction rank by date
     */
    public function getUserTransactionsDateRank($userId)
    {
        $data = $this->find('all',array(
                    'conditions' => array('Transaction.user_id' => $userId),
                    'fields'=>array('Transaction.id','Transaction.content','Transaction.amount','Transaction.modified','Transaction.created','Category.name','Wallet.name'),
                    'order' => array('Transaction.modified')
                      ));
        return $data; 
    }
    /*
     * delete transaction function, use transaction commit and rollback
     * return value : true or false (result of commit and rollback)
     * param : $id: transaction_id,  
     *         $data : data which contain updated wallet amount when delete a transaction
     */
    public function edit($data, $id)
    {
        $this->id = $id;
        return $this->saveAssociated($data);  
    }
    
    public function deleteTransaction($id,$data)
    {
        $dataSource = $this->getDataSource();
        $dataSource->begin();
        $result1 = $this->saveAssociated($data);
        $result2 = $this->delete($id);
        
        if($result1&&$result2){
            return $dataSource->commit();
        }  else {
            return $dataSource->rollback();
        }
    }
    /*
     * check if this transaction belong current user
     * return value: all data associate with param ( sometime use that returnvalue, eg:money amount in wallet, so it not return true - false)
     * param: $userId = userID && $id = transaction ID
     */
    public function transactionBelongUser($userId,$id)
    {
        $data = $this->find('first',array(
               'conditions' => array( 'Transaction.id'=>$id,'Transaction.user_id' => $userId)
                 ));
        return $data;   
    }
    /*
     * add a new transaction with related data,which contain new wallet money amount,...
     * param : user input data and related data( update wallet money amount)
     */
    public function add($data, $userId)
    {
        $this->create();
        $data['Transaction']['user_id'] = $userId;
//        return $this->save($data);
        return $this->saveAssociated($data);
      
    }
    /*
     * all transaction of user which has $userId, 
     * return value contain in an array(not a list )
     */   
    public function  getUserTransactions($userId)
    {
        $data = $this->find('all',array(
                    'conditions' => array('Transaction.user_id' => $userId),
                    'fields'=>array('Transaction.id','Transaction.content','Transaction.amount','Category.name','Wallet.name'),
                      ));
        return $data;
    }
   /*
    * return all transaction ralated with selected category
    * param: $id : category id
    */
    public function transactionBelongCategory($id)
    {
        $data = $this->find('all',array(
               'conditions' => array('Transaction.category_id' => $id)
                 ));
        return $data;   
    }
    
    /*
    * return all transaction ralated with selected wallet
    * param: $id : category id
    */
    public function transactionBelongWallet($id)
    {
        $data = $this->find('all',array(
               'conditions' => array('Transaction.wallet_id' => $id)
                 ));
        return $data;   
    }
    
}

