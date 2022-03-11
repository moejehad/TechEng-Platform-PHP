<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'Gallery';
    
include "init.php"; 

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

if($do == 'Manage'){ 
             
$stmt = $con->prepare("SELECT * FROM imags");
                        
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
            <td>Media</td>
            <td>Download</td>
            <td>Delete</td>
          </tr>
            <?php foreach($rows as $row){ 
                if($row['type'] != 'index'){
            ?>
          <tr>
            <td>
                
                <?php if(strpos($row['name'], 'mp4' ) !== false){ ?>
                    <video width="200" controls>
                      <source src="../Images/<?php echo $row['name'] ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php } else {
                            ?>
                <img width="200" src="../images/<?php echo $row['name'];?>"/>
                <?php }  ?>
              </td>
            <td><a href="../images/<?php echo $row['name'];?>" class="btn btn-info" download>Download</a></td>
            <td><a href="<?php echo $_SERVER['PHP_SELF'] . "?do=Delete&ID=" . $row['id']?>" class="btn btn-danger">Delete</a></td>
          </tr>
            <?php } } ?>
        </table>
    </div>
    
</div>


    

<?php
}elseif($do = 'Delete'){ 
            
        
    $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
    $stmt = $con->prepare("SELECT * FROM imags WHERE id = ? LIMIT 1");
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
        
    if($stmt->rowCount() > 0){ 
            
        $stmt = $con->prepare("DELETE FROM imags WHERE id = :zuser");
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