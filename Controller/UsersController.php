<?php

 class UsersController extends AppController
    {

       public $helpers = array('Html','Form','Session');
       public $components = array('Session','Auth');
        
       
       public function edit()
       {
           
       }
       
       public function resetPassword($userId,$userToken)
       {
           //check request
            if (!$this->request->is(array('post', 'put'))) 
                   {
                       return;
                   }

            if(empty($userId)){  $this->Session->setFlash('empty user ID  !');  return;}
            if (empty($userToken)){ $this->Session->setFlash('empty token !'); return;}
            //validate user input user name
            $this->User->set($this->request->data);
            $valid= $this->User->validates();
            if (!$valid) 
                {
                    return;
                }
             //get username and check if it match user id and reset password
            $data= $this->request->data['User'];   
            $resetResult = $this->User->resetPassword($userId,$userToken,$data);
            if ($resetResult==FALSE) //reset failed
            {
                 $this->Session->setFlash('Cannot reset password!Maybe your username does not match with your email or email is overdate. Please try again later! ') ; 
                 return;   
            }
            //succesfully reset password
             $this->Session->setFlash('Successfully Reset Password! Congratulation!');
             $this->redirect(array('action'=>'login'))  ;
       }
       
       public function forgotPassword()
       {    //check request method
            if (!$this->request->is(array('post', 'put'))) 
                {
                    return;
                } 
             //valid data   
            $this->User->set($this->request->data);
             $this->User->validator()->remove('username', 'unique');
            $valid = $this->User->validates();
            if (!$valid) 
                {
                    return;
                }
            $username = $this->request->data['User']['username'];
            $data = $this->User->getUserEmailAndToken($username);
            // echo 'data after get email and token: '.$data;
            if(!$data)
             {
                 $this->Session->setFlash('Your Username does not exit or cannot set activate token!You can try enter a correct username or register a new account ') ; 
                 return;     
             }
              //send password reset email
            $this->_send_password_reset_email($data['User']);
            $this->Session->setFlash('Check you email and follow instruction to reset password.');
            $this->redirect(array('action'=>'index'))  ;
       }
       
       public function beforeFilter() 
        {
            parent::beforeFilter();
            // Allow users to register and logout.
            $this->Auth->allow('register','login','logout','activate','forgotPassword','resetPassword','index','edit');
         }
        
       public function logout() 
        {
           $this->Session->setFlash('You logged out !');
           $this->Cookie->delete('remember');
           return $this->redirect($this->Auth->logout());
           $this->redirect(array('action'=>'index'));
        }
             
       public function login()
        {
            if (!$this->request->is('post')   ) 
                {
                     return;
                } 
                
            $this->User->set($this->request->data);
            $this->User->validator()->remove('username', 'unique');
            $valid = $this->User->validates();
            if(! $valid)  
                {
                    return;
                }
            //if loggin successfully
            if ($this->Auth->login())
            {
              if($remember)
                {
                    $cookieTime = '2 months';
                    //remove remember me checkbox
                    unset($remember); 
                    //hass password
                    $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
                    //write cookie
                    $this->Cookie->write('remember', $this->request->data['User'], true, $cookieTime);
                }
                $this->Session->setFlash(__('You have loggin!'), 'alert-box', array('class'=>'alert-success')); 
                //$this->Session->setFlash('ban da login vao he thong!');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash('Cannot login! Please check your user name and password!');
            return false;
        }
     
       public function activate($userID,$userToken)
        {
          //check variable
            if (empty ($userID)||empty($userToken))
            {
                throw InvalidArgumentException('Sorry! We cannot activate userID! Some argument has been wrong!');
                return;
            }
            
            $activateUser = $this->User->activate($userID,$userToken);
            if (!$activateUser)
            {
                $this->Session->setFlash('Failed Activation! Please try later !');
                return;
            }
            $this->Session->setFlash('Succesfully activated! Login and enjoy !');
            
        }
        
       public function index()
        {
         
        }

       public function register() 
        {   
            //check request method
            if (!$this->request->is('post')   ) 
                {
                     return;
                }
               
            //validate input
            $this->User->set($this->request->data);
            $valid = $this->User->validates();
            if(! $valid)  
                {
                    return;
                }
            //save user register info into database
            $data= $this->request->data['User'];
            $createUser = $this->User->createUser($data);
            if (!$createUser)
            {
               $this->Session->setFlash('Opp! Cannot Create New User ! Please try again!');  
            }
            //send active email
           $this->_send_activate_mail($createUser['User']);
            $this->Session->setFlash('Succesfully registed! Please check your email to finish activation!');
            return $this->redirect(array('action'=>'index'));
            
       }
       
       private function _send_activate_mail($data)
       {
           $Email = new CakeEmail('gmail');
           $Email->to($data['email']);
           $Email->subject('Activation Mail');
         //  $Email->from('Money Lover Development Team');
           $Email->template('activate');
           $Email->viewVars(array('user' => $data));
           $Email->send();
       }
       private function _send_password_reset_email($data)
        {
           $Email = new CakeEmail('gmail');
           $Email->to($data['email']);
           $Email->subject('Reset Password Mail');
         //  $Email->from('Money Lover Development Team');
           $Email->template('reset_password');
           $Email->viewVars(array('user' => $data));
           $Email->send();
        }

    }
?>