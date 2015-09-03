<?php

App::uses('CakeEmail', 'Network/Email');
App::uses('DigestAuthenticate', 'Controller/Component/Auth');

class User extends AppModel
{

    public $validate = array
        (
        'username'         => array(
            'notEmpty' => array(
                'rule'    => 'notBlank',
                'message' => 'Please input user name !'
            ),
            'unique'   => array(
                'rule'    => 'isUnique',
                'message' => 'Username has been used! Please try another name !'
            )
        ),
        'email'            => array(
            'notEmpty'   => array(
                'rule'    => 'notBlank',
                'message' => 'Please input user name !'
            ),
            'validEmail' => array(
                'rule'    => array('email'),
                'message' => 'Please enter a valid email adress'
            ),
            'unique'     => array(
                'rule'    => 'isUnique',
                'message' => 'This Email adress has been used! Try another email !'
            )
        ),
        'password'         => array(
            'notEmpty' => array(
                'rule'    => 'notBlank',
                'message' => 'Please enter your password'
            ),
            'length'   => array(
                'rule'    => array('between', 5, 256),
                'message' => 'The password must be between 5 and 256 characters.'
            ),
        ),
        'confirm_password' => array(
            'notEmpty'  => array(
                'rule'    => 'notBlank',
                'message' => 'Please Re_enter your password'
            ),
            'matchPass' => array(
                'rule'    => 'passwordsMatch',
                'message' => 'password do not match'
            )
        )
    );

    public function getUsingWallet($userId)
    {
        $data= $this->findById($userId);
        return $data['User']['using_wallet'];
    }
    
    public function setUserCurrentWallet($userId,$walletId)
    {
         $this->id = $userId;
         return ($this->saveField('using_wallet', $walletId));
    }
    
    public function resetPassword($userId, $userToken, $inputData)
    {
        $m_query = array(
            'condition' => array(
                'User.id'    => $userId,
                'User.token' => $userToken
            )
        );
        $data    = $this->find('first', $m_query);
        //if not match userid and token
        if (empty($data)) {
            return false;
        }
        //set activate true
        $this->id = $userId;
        $result   = $this->save(array(
            'User' => array(
                'token'    => NULL,
                'password' => $inputData['password']
        )));
        return $result;
    }

    public function getUserEmailAndToken($username)
    {
        $m_query = array(
            'condition' => array(
                'User.username' => $username
        ));
        $data    = $this->find('first', $m_query);
        //if cannot find userid
        if (empty($data)) {
            return false;
        }
        //if found, set new token and return
        $token  = uniqid();
        $result = $this->updateAll(
                array('User.token' => "'$token'"),
                // array('User.id' => $data['User']['id'])
                array('User.username' => $username)
        );
        //check if update token success?
        if (!$result) {
            return false;
        }
        $data = $this->find('first', $m_query);
        return $data;
    }

    public function beforeSave($options = array())
    {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }

    public function activate($userId, $userToken)
    {
        $m_query = array(
            'condition' => array(
                'User.id'    => $userId,
                'User.token' => $userToken
        ));
        $data    = $this->find('first', $m_query);
        //if not match userid and token
        if (empty($data)) {
            return false;
        }
        //set activate true
        $this->id = $userId;
        $this->save(array(
            'User' => array(
                'token'     => NULL,
                'activated' => true
        )));
        return true;
    }

    public function passwordsMatch($data)
    {
        if ($this->data['User']['password'] == $this->data['User']['confirm_password']) {
            return true;
        }
        return false;
    }

    public function createUser($data)
    {
        $this->create();
        $data['token']     = uniqid();
        $data['activated'] = false;
        return $this->save($data);
    }

}

?>