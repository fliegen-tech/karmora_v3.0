<?php 
if (isset($this->session->userdata['front_data']['id'])) {
          echo  $userId = $this->session->userdata['front_data']['id'];
        }else{
            echo 123;
        }
?>