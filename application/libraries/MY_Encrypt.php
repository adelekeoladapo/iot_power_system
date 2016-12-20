<?php

class MY_Encrypt extends CI_Encrypt {
    
    function do_encode($str){
        return str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encode($str));
    }
    
    function do_decode($cipher){
        return $this->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $cipher));
    }
    
    function encode_password($password){
        return md5($password);
    }
    
}
