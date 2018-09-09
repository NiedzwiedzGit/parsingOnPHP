<!DOCTYPE html>
<?php
include "src/phpParser.php";
include "src/db.php";
include "src/convertXLSX.php";

 ?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="src/css/style.css" type="text/css" rel="stylesheet"/>
    <script src="jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="src/js/ajaxLoader.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
 
    <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Pars</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Analysis and presentation of data from mySQL</a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Development of data visualization</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
  <div id="firstTask">
        <h1>Parsing</h1><br>
        <form id="parsingForm" method='post' action="src/phpParser.php">
            <input type="text" name="parsingTarget" value="http://www.smartbay.pl/15-monitory_lcd/">
            <button id="parsing" class="btn btn-dark" type="submit">pars</button>
        </form>
    <img id="loadImg" src="src/img/load.gif" />
    </div>
  </div>
  
  <div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <form id="createDBForm" method='post' action="src/db.php">
            <input type="text" id="createDB" name="createDB" value="create">
        </form>

  </div>

  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">333
  <form id="createDBFormDate" method='post' action="src/developmentOfData.php">
            <input type="text" id="createDB" name="createDB" value="create">
        </form>
  </div>
</div>


<script>
    $('#nav-tab a').on('click', function (e) {
  e.preventDefault()
  $('div').removeClass('show active');
  $('a').removeClass('active');
  
  $(this).addClass('active');
  if($('#nav-home-tab').hasClass('active')){
    $('#nav-home').addClass('show active');
  }else if($('#nav-profile-tab').hasClass('active')){
    $('#nav-profile').addClass('show active');
  }else if($('#nav-contact-tab').hasClass('active')){
    $('#nav-contact').addClass('show active');
  }
})

</script>

</body>

</html>