<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class ImagesController extends AppController
{

    public function upload()
    {
        //check valid input method
        if (!$this->request->is(array('post', 'put'))) {
            return;
        }
        $username = $this->Auth->user('username');
        if (!$username) {
            $this->_setAlertMessage(__('Please Login First !'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $img = $this->request->data['Image']['img'];
        //check if upload file does not get any error
        if ($img['error'] > 0) {
            $this->Session->setFlash('Upload Error! Please Try Later!');
            return;
        }
        //if upload successfully, move upload file to upload folder
        $uploadFolder = WWW_ROOT . 'img' . DS . 'uploads' . DS;
        $newName      = $username . $img['name'];
        $fileUrl      = $uploadFolder . $newName;
        $moveResult   = move_uploaded_file($img['tmp_name'], $fileUrl);

        if (!$moveResult) {
            $this->_setAlertMessage(__('Failed Uploading Image'));
            return;
        }
        //if upload file success, save file url to database
        $imgInfo = array(
            'name' => $newName,
            'url'  => $fileUrl,
            'size' => $img['size']
        );

        $uploadResult = $this->Image->upload($imgInfo);
        if (!$uploadResult) {
            $this->_setAlertMessage(__('Save Image URL To Database Failed'));
            return;
        }
        $this->Session->setFlash(__('Upload  Successfully !'), 'alert_box', array('class' => 'alert-success'));
    }

}
