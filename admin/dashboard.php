<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'لوحة التحكم';
    
include "init.php"; 
    
?>

        


<?php

    include $tpl . 'footer.php';
    
} else {
    
    header('Location: index');
    
    exit();
}

ob_end_flush();

?>