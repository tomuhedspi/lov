<?php
class Wallet extends AppModel
{
    public function edit($data,$id)
    {
        $this->id = $id;
        return $this->save($data);
    }
    
    public function getWalletList($userId)
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
