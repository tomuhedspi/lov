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
    

    public function transactionBelongUser($userId,$id)
    {
        $data = $this->find('first',array(
               'conditions' => array( 'Transaction.id'=>$id,'Transaction.user_id' => $userId)
                 ));
        return $data;   
    }
    public function add($data, $userId)
    {
        $this->create();
        $data['Transaction']['user_id'] = $userId;
        //return $this->save($data);
        return $this->saveAssociated($data);
      
    }
    
    public function  getUserTransactions($userId)//return transaction and belongs array
    {
        $data = $this->find('all',array(
                    'conditions' => array('Transaction.user_id' => $userId),
                    'fields'=>array('Transaction.id','Transaction.content','Transaction.amount','Category.name','Wallet.name'),
                      ));
        return $data;
    }
    
}

