<!--* Add wallet
* Update wallet info
* Set current wallet
* Transfer money between wallets-->
<?php
    class WalletsController extends AppController
    {
       public $helpers = array('Html','Form','Session');
       public $components = array('Session','Auth');
        
       function index()
       {
           
       }
       
       function  addWallet()
       {
           
       }
       
       public function beforeFilter() 
        {
            parent::beforeFilter();
            // Allow users to register and logout.
            $this->Auth->allow('index','addWallet');
         }

       
    }

?>
