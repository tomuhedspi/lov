<?php
class Transaction extends AppModel
{
    public function add($data, $userId)
    {
        $this->create();
        $data['user_id'] = $userId;
        return $this->save($data);
    }
    
    public function  getTransactionList($userId)
    {
        $data = $this->find('list',
                array(
                    'conditions' => array('Transaction.user_id' => $userId),
                    'fields'=>array('Transaction.id','Transaction.content','Transaction.amount','Transaction.wallet_id')
                      ));
        return $data;
    }
    
}

