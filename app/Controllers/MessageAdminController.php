<?php
$this->viewType = 'admin';
        if($this->view === 'messageAdmin'){
            $contactModel = new ContactModel();
            $messages = $contactModel->getMessages();
            $this->data['messages'] = $messages;
            var_dump($data['messages']);
        }
        
            
?>