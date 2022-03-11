<?php 

ob_start();

session_start();

$pageTitle = 'الصفحة المطلوبة غير موجودة' ;

include "init.php"; 
    
    
?>

<div class="container error text-center">
    <div class="col-md-12 alert alert-danger">
    <p style="margin: 20px 0;"> 404 Page not Found</p>
    <a href="index.php"><span class="btn btn-danger">Home </span></a>
    </div>
</div>


<?php

include $tpl . 'footer.php'; 
ob_end_flush();

?>
