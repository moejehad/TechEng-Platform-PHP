<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'الحضور';
    
include "init.php"; 
    
?>
    

<div class="card general">
    <div class="card-header">
        <?php echo $pageTitle ;?>
    </div>
    <div class="card-body">
        
<?php        
        
    $user = $_GET['ID'];

    $stmt = $con->prepare("SELECT * FROM attend WHERE event LIKE '%$user%' ORDER BY id DESC");
                        
    $stmt->execute(array($user));
                        
    $rows = $stmt->fetchAll();
        
    $count = $stmt->rowCount();  
    
    if($count > 0){
        
?>


        <table class="main-table manage-members text-center table table-bordered">
        <tr class="head">
            <td>الاسم</td>
            <td>البريد الإلكتروني </td>
            <td>رقم الهاتف</td>
            <td>التاريخ</td>
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>

 
<?php
    
    echo '</div>';
    echo '</div>';
    
    include $tpl . 'footer.php';

} else {
    
    header('Location: index');
    
    exit();
}
}
ob_end_flush();

?>