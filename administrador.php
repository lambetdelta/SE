<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
if(login_check_adm($mysqli)==1){
    echo'1';
}  else {
    
echo "no";}

