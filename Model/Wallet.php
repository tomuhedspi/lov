<?php
class Wallet extends AppModel
{
    /*
     * transfer money between 2 wallet
     * @return true false
     * @param int $fromId id of wallet get money from
     * @param int $toId id of wallet put money to
     * @param float $amount amount of money to transfer
     */
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
    /*
     * get the money amount in wallet
     * @return float money amount
     * @param int $walletId
     */
    public function moneyInWallet($walletId)
    {
       $this->id=$walletId;
       $data = $this->findById($walletId);
       return $data['Wallet']['amount'];
    }
    /*
     * check if this wallet  belong user
     * @return info array of wallet
     * @param int $userId
     * @param int $id wallet id
     */
    public function walletBelongUser($userId,$id)
    {
        $data = $this->find('first',array(
               'conditions' => array( 'Wallet.id'=>$id,'Wallet.user_id' => $userId)
                 ));
        return $data;
    }
    /*
     * get list of user's wallet , use for form select
     * @return list of wallet, which contain only wallet id and wallet name
     * @param int $userId
     */
    public  function getWalletNameIDList($userId)
    {
        $data = $this->find('list',array(
                    'conditions' => array('Wallet.user_id' => $userId),
                    'fields' => array('Wallet.id', 'Wallet.name')
                      ));
        return $data;
    }
    
    /*
     * update data of selected wallet
     * @return result of save functino: false or array data if success
     * @param int $id wallet id
     * @param array $data info of wallet
     */
    public function edit($data,$id)
    {
        $this->id = $id;
        return $this->save($data);
    }
    
    /*
     * all data of all wallet belong current user
     * @return array data of all wallet of user which has $userId
     * @param int $userId
     */
    public function getUserWallets($userId)
    {
        $data = $this->find('all', array( 'conditions' => array(  $this->alias . '.user_id' => $userId ) ));
        return $data;
    }
    
    /*
     * add a wallet
     * @return result of save functino: false or array data if success
     * @param int $userId
     * @param array $data  info of new wallet
     */
    public function add($data, $userId)
    {
           $this->create();
           $data['user_id'] = $userId;
           return $this->save($data);
    }
    
    /*
     * get all data of selected wallet id
     * @return array of info of wallet
     * @param int $id wallet id
     */
    function getSelectedById($id)
    {
        $data = $this->find('first', array('conditions' => array('Wallet.id' => $id)));
        return $data;
    }
}
