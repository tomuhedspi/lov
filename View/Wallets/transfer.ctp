<div class="container">
    <div class="row">
        <div class="col-md-3 " style="background-color:lavender;">
            <?php
                echo $this->Form->input('from', array(
                   // 'options' => array(1, 2, 3, 3, 5),
                    'options'=>$walletList,
                    'empty' => '(choose one)'
                ));
            ?>    
        </div>

        <div class="col-md-3 " style="background-color:lavenderblush;">
            <?php
                echo $this->Form->input('to', array(
                    'options'=>$walletList,
                    'empty' => '(choose one)'
                ));
            ?> 
        </div>

        <div class=" col-md-3 "  style="background-color:lavender;" >
            <?php 
            echo $this->Form->input('amount',array(
            'label'=>"Transfer Amount : ",
            'type' =>'double'
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <?php
        echo $this->Form->end('Transfer Now');
       ?>
    </div>
</div>