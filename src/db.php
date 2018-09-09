<?php
session_start();
ini_set('display_errors','Off');
$db = mysqli_connect("localhost","root","42091i","parsdb");
mysqli_query($db,"SET NAMES 'UTF8'");
if (!empty($_POST['createDB'])&&$_POST['createDB']=="create") {
    $table_list = mysqli_query($db,"SHOW TABLES FROM parsdb");
    $tablename="products";
    $tableExist=false;
    while ($row2 = mysqli_fetch_row($table_list)) {
        if ($tablename==$row2[0]) {
            $tableExist=true;
        }
    }

    if($tableExist!=true){
    $result = "CREATE TABLE products (
        product_id INT(11) NOT NULL AUTO_INCREMENT, 
        product_date DATE NOT NULL,
        producer_id INT(11) NULL, 
        product_url VARCHAR(300) NOT NULL, 
        product_name VARCHAR(300) NOT NULL,
        product_price DECIMAL(11,2) NULL DEFAULT NULL, 
        product_price_old DECIMAL(11,2) NULL DEFAULT NULL, 
        product_reviews INT(11) NULL DEFAULT NULL, 
        product_rating FLOAT NULL DEFAULT NULL,
        PRIMARY KEY (`product_id`), 
        INDEX  (producer_id, product_date) )
        CHARACTER SET utf8 
        COLLATE utf8_general_ci 
        ENGINE=InnoDB
       ";
       $result2 = "CREATE TABLE producers (
            producer_id INT(11) NOT NULL AUTO_INCREMENT, 
             producer_name VARCHAR(64) NOT NULL, 
             PRIMARY KEY (producer_id) )
            CHARACTER SET utf8 
            COLLATE utf8_general_ci 
            ENGINE=InnoDB
        ";
    
            if(mysqli_query($db, $result)&&mysqli_query($db, $result2)){
                echo '<button id="parsing" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span><br>Data Base Created</button>';

            } else{
                echo "ERROR: Could not able to execute $result. " . mysqli_error($db);
                echo '<button id="parsingDB" class="btn btn-dark"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br>Data Base is empty</button>';
                }
     }else{
         echo '<div class="buttonDBgroup">';
         echo '<button id="parsingDB" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span><br>Data Base Created</button>';
         if($_SESSION['fieldDB']==true){
         echo '<button id="parsingDB" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span><br>Table allready full</button>';
         }else{
            echo '<button id="parsingDB" class="btn btn-dark"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br>Table is empty</button>';
         }
         echo '</div>';

         $prodSelector=mysqli_query($db,"SELECT product_date,producer_id  FROM products");
         $prodSelectorUniqId=mysqli_query($db,"SELECT DISTINCT producer_id FROM products");
         $prodDaysSelector=mysqli_query($db," SELECT TO_DAYS('2017-03-30') - TO_DAYS('2017-03-28') AS days");

         $days=mysqli_fetch_array($prodDaysSelector);
         $alphabet = range('A', 'Z');
         
         $countRow=0;
         while($rowSelector = mysqli_fetch_array($prodSelector)){
            $countRow=$countRow+1;
         }

         $table= '<table border="1">';
        $table.='<tr>';
        $table.='<th>Produser</th>';
        $table.='<th>% products share</th>';
        $table.='<th>Avg products </th>';
        $table.='</tr>';
        $rowSelectorUniqId2=array(1,2,3);;
        $array=array();
        while($rowSelectorUniqId =mysqli_fetch_array($prodSelectorUniqId)){
            $array[]=$rowSelectorUniqId[0];
        }
        $array[]= array_shift($array);
        foreach($array as $key => $r){
              if($r==0)break;
                $counyUniqId=mysqli_query($db,"SELECT COUNT(producer_id)  FROM products WHERE producer_id='$r[0]'");
                $rowCounyUniqId = mysqli_fetch_array($counyUniqId);
            $productShare=100*$rowCounyUniqId[0]/$countRow;
            $table.='<tr>';
                $table.='<td>Produser '.$alphabet[$key].'</td>';
                $table.='<td>'.round($productShare).'%</td>';
                $table.='<td>'.round($rowCounyUniqId[0]/($days[0]+1)).'</td>';
            $table.='</tr>';
            //var_export ($r);
        }
        $counyUniqIdOther=mysqli_query($db,"SELECT COUNT(producer_id)  FROM products WHERE producer_id='end($array)'");
                $rowCounyUniqIdOther = mysqli_fetch_array($counyUniqIdOther);
            $productShareOther=100*$rowCounyUniqIdOther[0]/$countRow;
            $table.='<tr>';
                $table.='<td>Other</td>';
                $table.='<td>'.round($productShareOther).'%</td>';
                $table.='<td>'.round($rowCounyUniqIdOther[0]/($days[0]+1)).'</td>';
            $table.='</tr>';
         $table.= '</table>';
         echo $table;
     }
    }

?>