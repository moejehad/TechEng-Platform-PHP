<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'Attend People';
    
include "init.php"; 
    
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

if($do == 'Manage'){ 

$stmt = $con->prepare("SELECT * FROM form ORDER BY id DESC");
                        
$stmt->execute();
                        
$rows = $stmt->fetchAll();
 
?>



<div class="card attend">
    <div class="card-header">
        <?php echo $pageTitle ;?>
    </div>
    <div class="card-body">
        <table style="width:100%">
          <tr class="bg-light">
            <td>First Name</td>
            <td>Last Name</td>
            <td>Email</td>
            <td>Phone</td>
            <td>Number of People to attend</td>
            <td>Delete</td>
          </tr>
            <?php foreach($rows as $row){?>
          <tr>
            <td><?php echo $row['First'];?></td>
            <td><?php echo $row['Last'];?></td>
            <td><?php echo $row['email'];?></td>
            <td>+<?php echo $row['country'] . $row['phone'];?></td>
            <td><?php echo $row['number'];?></td>
            <td><a href="<?php echo $_SERVER['PHP_SELF'] . "?do=Delete&ID=" . $row['id']?>" class="btn btn-danger">Delete</a></td>
          </tr>
            <?php } ?>
        </table>
    </div>
    
</div>


    

<?php
}elseif($do = 'Delete'){ 
            
                
    $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
    $stmt = $con->prepare("SELECT * FROM form WHERE id = ? LIMIT 1");
    $stmt->execute(array($userid));
    $count = $stmt->rowCount();
        
    if($stmt->rowCount() > 0){ 
            
        $stmt = $con->prepare("DELETE FROM form WHERE id = :zuser");
        $stmt->bindParam(":zuser", $userid);
        $stmt->execute();
              
        header('Location:  '. $_SERVER['PHP_SELF'] . '?do=Manage');
    
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