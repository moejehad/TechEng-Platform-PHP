<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'Edit Event';
    
include "init.php"; 


    $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
    $stmt = $con->prepare("SELECT * FROM events WHERE id = ? LIMIT 1");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();  
    
    if($stmt->rowCount() > 0){ 
    
        $formErrors = array();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
            $title      = $_POST['tit'];
            $titleAr    = $_POST['titAr'];
            $time       = $_POST['ti'];
            
            if(empty($formErros)){                       

                    $stmt = $con->prepare("UPDATE events SET title = ?, titleAr = ?, time = ? WHERE id = ?");
            
                    $stmt->execute(array($title, $titleAr, $time, $id));
                                                    
                    header('Location: events.php ');

                    exit();
                    
                }
            
            
            }else {

                header('Location: events.php ');

                exit();


            }        
                    
} 
        
include $tpl . 'footer.php';

} else {
    
    header('Location: index.php');
    
    exit();
}

ob_end_flush();

?>