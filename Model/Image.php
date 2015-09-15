<?php

class Image extends AppModel
{

    /**
     * add image url to database
     */
    public function upload($imgInfo)
    {
        //    var_dump($imgInfo);
        $this->create();
        return $this->save($imgInfo);
    }

}
