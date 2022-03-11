<?php 

  function getAllfrom($tableName, $orderBy, $where = NULL){
    

    global $con; 
    
    $sql = $where == NULL ? '' : $where;
      
    $getAll = $con->prepare("SELECT * FROM $tableName $sql ORDER BY $orderBy DESC");
    
    $getAll->execute();
    
    $all = $getAll->fetchAll();
    
    return $all;
    
    
}

function getTitle(){
    
    global $pageTitle ; 
    
    if(isset($pageTitle)){
        
        echo $pageTitle;
        
    }else {
        
        echo 'Default';
    }
}



function countItems($item, $table){
    
    
        global $con; 
    
        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
        $stmt2->execute();

        return $stmt2->fetchColumn();
    
    
}

    
    
?>

