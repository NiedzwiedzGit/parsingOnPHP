<?php

include 'lib/simplexlsx.class.php'; 
session_start();
$db = mysqli_connect("localhost","root","42091i","parsdb");
mysqli_query($db,"SET NAMES 'UTF8'");

$table_list = mysqli_query($db,"SELECT * FROM products");
$table_content=mysqli_num_rows($table_list);
if($table_content==0){
if ( $xlsx = SimpleXLSX::parse('src/PHP_ Dane do zadania rekrutacyjnego.xlsx') ) {
    echo '<table border="1">';
    $test=array();
    $i=0;
	foreach($xlsx->rows() as $r) {
        for($i=1;$i<=9;$i++){
            if($r[$i]==null|| $r[$i]=="")$r[$i]=0;
        }
        

        $result2 = mysqli_query ($db,"INSERT INTO products 
            (product_date,
             producer_id,
             product_url,
             product_name,
             product_price,
             product_price_old,
             product_reviews,
             product_rating) 
                VALUES(
                    '$r[1]',
                    '$r[2]',
                    '$r[3]',
                    '$r[4]',
                    '$r[5]',
                    '$r[6]',
                    '$r[7]',
                    '$r[8]')
                    ");
    }
    echo '</table>';
    
} else {
	echo SimpleXLSX::parse_error();
}
}else{
    $_SESSION['fieldDB']=true;
}
  ?>