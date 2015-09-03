<div class="container">
  <div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6" style="background-color:lavender;">
                 <div class ="text-center">
                    <?php
                        echo $this->Form->input('from', array(
                           // 'options' => array(1, 2, 3, 4, 5),
                            'options'=>$walletList,
                            'empty' => '(choose one)'
                        ));
                    ?>
                </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6" style="background-color:lavenderblush;">
                 <div class="text-center">
                    <?php
                        echo $this->Form->input('to', array(
                            //'options' => array(1, 2, 3, 4, 5),
                            'options'=>$walletList,
                            'empty' => '(choose one)'
                        ));
                    ?> 
                </div>
            </div>
    </div>
    
    <div class ="row">
         <div class="col-sm-6 col-md-6 col-lg-6 ">
                <div class ='text-center'>
                    <?php 
                    echo $this->Form->input('amount',array(
                    'label'=>"Transfer Amount : ",
                    'type' =>'double'
                    ));
                    ?>
                </div>
        </div>
         
        <div class="col-sm-6 col-md-6 col-lg-6">
                <div class ='text-center'>
                     <?php
                     echo $this->Form->end('Transfer Now');
                    ?>
               </div>
        </div>
   </div>
</div>