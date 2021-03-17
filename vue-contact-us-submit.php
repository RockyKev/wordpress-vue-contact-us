<?php 

echo "It worked!";


if( isset($_POST['firstName']) && isset($_POST['lastName'])) {
    echo $_POST['firstName'];
    echo $_POST['lastName'];      
 } else {  
    echo 'Data not received';
 }
 
die;


