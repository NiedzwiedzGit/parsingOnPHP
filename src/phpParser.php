<?php
include 'lib/simple_html_dom.php'; 
ini_set('display_errors','Off');
if (!empty($_POST['parsingTarget'])) {
    $url = $_POST['parsingTarget'];

    $context = stream_context_create(array('http' => array('header' => 'User-Agent: Mozilla compatible')));
    $responseMainePage = file_get_contents($url, false, $context);
    $html = str_get_html($responseMainePage);

$table= '<table border="1">';
    $table.='<tr>';
        $table.='<th>Nazwa priduktu</th>';
        $table.='<th>Cena od</th>';
        $table.='<th>Liczba sklepow</th>';
        $table.='<th>URl</th>';
    $table.='</tr>';

    $createData = array();
    $increment=-1;

    foreach($html->find('content-container>li>a.product-image') as $element) {
        $increment++;
        $eachItemURLPart=$element->href;
        $eachItemURL="http://www.smartbay.pl/".$eachItemURLPart;
        $responseEachItem = file_get_contents($eachItemURL, false);
        $htmlEachItem = str_get_html($responseEachItem);
        $countMarket= array();
    
            foreach($htmlEachItem->find('ol.product-offers>li.visible') as $elementEachItem) {
                $countMarket[]=$elementEachItem;
            }
            
        $numOfMarket=count($countMarket);
        $lowestPrice=$htmlEachItem->find('h3>li.offer-price>big');
        $nameOfProduct=$htmlEachItem->find('h1');

    $table.='<tr>';
        $table.='<td>'.strip_tags($nameOfProduct[0]).'</td>';
        $table.='<td>'.strip_tags($lowestPrice[0]).'</td>';
        $table.='<td>'.$numOfMarket.'</td>';
        $table.='<td>'.$eachItemURL.'</td>';
    $table.='</tr>';
        $createData[$increment][0]= strip_tags($nameOfProduct[0]);
        $createData[$increment][1]= strip_tags($lowestPrice[0]);
        $createData[$increment][2]=$numOfMarket;
        $createData[$increment][3]=$eachItemURL;
    }
$table.= '</table>';

    function createCSVfile( $createData, $file = null, $colDelimiter = ';', $rowDelimiter = "\r\n" ){

    	if( ! is_array($createData) )
    		return false;

    	if( $file && ! is_dir( dirname($file) ) )
    		return false;

    	$CSVstr = '';

    	foreach( $createData as $row ){
    		$cols = array();

    		foreach( $row as $colVal ){

    			if( $colVal && preg_match('/[",;\r\n]/', $colVal) ){
    				// поправим перенос строки
    				if( $rowDelimiter === "\r\n" ){
    					$colVal = str_replace( "\r\n", '\n', $colVal );
    					$colVal = str_replace( "\r", '', $colVal );
    				}
    				elseif( $rowDelimiter === "\n" ){
    					$colVal = str_replace( "\n", '\r', $colVal );
    					$colVal = str_replace( "\r\r", '\r', $colVal );
    				}

    				$colVal = str_replace( '"', '""', $colVal );
    				$colVal = '"'. $colVal .'"'; 
    			}

    			$cols[] = $colVal; 
    		}

    		$CSVstr .= implode( $colDelimiter, $cols ) . $rowDelimiter;
    	}

    	$CSVstr = rtrim( $CSVstr, $rowDelimiter );
    	if( $file ){
    		$CSVstr = iconv( "UTF-8", "cp1251",  $CSVstr );
    		$done = file_put_contents( $file, $CSVstr );
    	}
echo "<div class='createMessage'>File <big>csvFile.csv</big> has been created in /<big>src</big> directory</div>";
    }
     echo $table;
    echo createCSVfile( $createData, 'csvFile.csv' );
    }else{
    }
?>