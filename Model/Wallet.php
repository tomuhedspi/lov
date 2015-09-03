<?php
class Wallet extends AppModel
{
    public function transfer($fromId,$toId,$amount)
    {
        //start transaction
        $dataSource = $this->getDataSource();
        $dataSource->begin();
        //get money from wallet 1   
        $data = $this->findById($fromId);
        $data['Wallet']['amount']-= $amount;
        $result1= $this->save($data);
        //put money to wallet 2
        $data = $this->findById($toId);
        $data['Wallet']['amount']+= $amount;
        $result2= $this->save($data);        
        //finish transaction
        if($result1&&$result2){
            return $dataSource->commit();
        }  else {
            $dataSource->rollback();
            return  false;
        }
    }
    
    public function moneyInWallet($walletId)
    {
       $this->id=$walletId;
       $data = $this->findById($walletId);
       return $data['Wallet']['amount'];
    }

    public function walletBelongUser($userId,$walletId)
    {
        $data = $this->find('first',
           array(
               'conditions' => array( 'Wallet.id'=>$walletId,'Wallet.user_id' => $userId)
                 ));
        return $data;   
    }
    
    public  function getWalletNameID($userId)//danh sach wallet su dung cho transfer
    {
        $data = $this->find('list',
                array(
                    'conditions' => array('Wallet.user_id' => $userId),
                    'fields' => array('Wallet.id', 'Wallet.name')
                      ));
        return $data;
    }
    
    public function edit($data,$id)
    {
        $this->id = $id;
        return $this->save($data);
    }
    
    public function getWalletList($userId)//all data of wallet
    {
        $data = $this->find('all', array( 'conditions' => array(  $this->alias . '.user_id' => $userId ) ));
        return $data;
    }
    
    public function add($data, $id)
    {
           $this->create();
           $data['user_id'] = $id;
           return $this->save($data);
    }
    function getSelectedById($id)
    {
        $data = $this->find('first', array('conditions' => array('Wallet.id' => $id)));
        return $data;
    }
}
