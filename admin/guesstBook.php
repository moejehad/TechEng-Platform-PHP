<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'Guesst Book';
    
include "init.php"; 

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

if($do == 'Manage'){ 
             
$stmt = $con->prepare("SELECT * FROM gbook");
                        
$stmt->execute();
                        
$rows = $stmt->fetchAll();
    
        
?>



<div class="card attend">
    <div class="card-header">
        <?php echo $pageTitle ;?>
    </div>
    <div class="card-body text">
        <table style="width:100%">
          <tr class="bg-light">
            <td>Image</td>
            <td>Post</td>
            <td>Delete</td>
          </tr>
            <?php foreach($rows as $row){?>
          <tr>
            <td>
                <img width="150" src="../images/<?php echo $row['img'];?>"/>
              </td>
            <td><?php echo $row['post']?></td>
            <td><a href="<?php echo $_SERVER['PHP_SELF'] . "?do=Delete&ID=" . $row['id']?>" class="btn btn-danger">Delete</a></td>
          </tr>
            <?php } ?>
        </table>
    </div>
    
</div>


    

<?php
}elseif($do = 'Delete'){ 
            
        
    $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
    $stmt = $con->prepare("SELECT * FROM gbook WHERE id = ? LIMIT 1");
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
        
    if($stmt->rowCount() > 0){ 
            
        $stmt = $con->prepare("DELETE FROM gbook WHERE id = :zuser");
        $stmt->bindParam(":zuser", $id);
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