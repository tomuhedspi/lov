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
    /*
     * wallet user using 
     * @return the id of wallet user using
     * @param int $userId
     */
    public function getUsingWallet($userId)
    {
        $data= $this->findById($userId);
        return $data['User']['using_wallet'];
    }
    /*
     * set selected wallet become user current wallet
     * @return result of saveField function: False on failure or an array of model data on success
     * @param int $userId
     * @param int $walletId wallet to set to default wallet for user
     */
    public function setUserCurrentWallet($userId,$walletId)
    {
         $this->id = $userId;
         return ($this->saveField('using_wallet', $walletId));
    }
    /*
     * save new password for user
     * @return result of save function: False on failure or an array of model data on success
     * @param int $userId
     * @param string $userToken
     * @param array $inputData : contain new password for user
     */
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
    /*
     * set a new token for username account then return it 
     * if does not exit $username account, the return data will not contain any thing
     * @return user data array
     * @param int $username
     */
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
    /*
     * hash password befor save
     */
    public function beforeSave($options = array())
    {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }
    /*
     * check if userID and userToken is match with databse
     * if match, set activate of user true, if not, return false
     * @param int $userId
     * @param string $userToken
     */
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
    /*
     * check if user data input password(use in auth component) match
     * @param array $data : user input info data
     */
    public function passwordsMatch($data)
    {
        if ($this->data['User']['password'] == $this->data['User']['confirm_password']) {
            return true;
        }
        return false;
    }
    /*
     * create an new account and set it activate status false(will activate later when user kick on link in activate email)
     * param array $data user input info data
     */
    public function createUser($data)
    {
        $this->create();
        $data['token']     = uniqid();
        $data['activated'] = false;
        return $this->save($data);
    }

}

?>