<?php
session_start();
$db = mysqli_connect("localhost","root","42091i","parsdb");
mysqli_query($db,"SET NAMES 'UTF8'");
if ( $_SESSION['fieldDB']=true) {
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
    $array2=array();  
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
   $day=array();
   for($i=0;$i<$days[0]+1;$i++){
       $day[]=date("Y-m-d",mktime(0, 0, 0, 03, 28+$i, 2017));
       $prodSelectorUniqDate=mysqli_query($db,"SELECT COUNT(producer_id) FROM products WHERE product_date='$day[$i]'");
       $rowSelectorUniqDate =mysqli_fetch_array($prodSelectorUniqDate);
       $array2[]=$rowSelectorUniqDate;
    $table.='<th>'.$day[$i].'</th>';  
   }
   $table.='</tr>';
   $array=array();   
   while($rowSelectorUniqId =mysqli_fetch_array($prodSelectorUniqId)){
       $array[]=$rowSelectorUniqId[0];
   }
   $array[]= array_shift($array);
   foreach($array as $key => $r){
    $localCount=array();
         for($z=0;$z<3;$z++){
         $counyUniqId=mysqli_query($db,"SELECT COUNT(producer_id)  FROM products WHERE producer_id='$r' AND product_date='$day[$z]'");
            $rowCounyUniqId = mysqli_fetch_array($counyUniqId);
            $localCount[]=$rowCounyUniqId;
        }    
       $table.='<tr>';
       $x=0;
       if($key!=4){
       $table.='<td>Produser '.$alphabet[$key].'</td>';
       }else{
        $table.='<td>Other</td>';
       }
       for($i=0;$i<$days[0]+1;$i++){
          
        $productShare=100*$localCount[$i][0]/$array2[$i][0];
        $x++;
           $table.='<td>'.round($productShare).'%</td>';
       } 
       $table.='</tr>';
   }
    $table.= '</table>';
    echo $table;
     }else{
        
     }

?>