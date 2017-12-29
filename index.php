<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>External Google Sheet JSON Streaming Data Example</title>
  <meta name="description" content="External Google Sheet JSON Streaming Data Example">
 	<meta name="author" content="Jeff Hargarten - StarTribune">
	<meta name="generator" content="BBEdit 10.5" />

  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" /> 

<style type="text/css">
@font-face {
	font-family: Popular;
	src: url("http://apps.startribune.com/fonts/Thepopular/regular/851caebd-2961-4fd9-a500-2b38452b1ec9-2.eot?") format("embedded-opentype"),
		 url("http://apps.startribune.com/fonts/popular/regular/851caebd-2961-4fd9-a500-2b38452b1ec9-3.woff") format("woff"),
		 url("http://apps.startribune.com/fonts/popular/regular/851caebd-2961-4fd9-a500-2b38452b1ec9-1.ttf") format("truetype"),
		 url("http://apps.startribune.com/fonts/popular/regular/851caebd-2961-4fd9-a500-2b38452b1ec9-4.svg#web") format("svg");
	font-style: normal;
	font-weight: normal;
}

@font-face {
	font-family: Popular-medium;
	src: url("http://apps.startribune.com/fonts/popular/medium/96c3bd87-fed5-419d-a1cf-d947b17d6ab7-2.eot?") format("embedded-opentype"),
		 url("http://apps.startribune.com/fonts/popular/medium/96c3bd87-fed5-419d-a1cf-d947b17d6ab7-3.woff") format("woff"),
		 url("http://apps.startribune.com/fonts/popular/medium/96c3bd87-fed5-419d-a1cf-d947b17d6ab7-1.ttf") format("truetype"),
		 url("http://apps.startribune.com/fonts/popular/medium/96c3bd87-fed5-419d-a1cf-d947b17d6ab7-4.svg#web") format("svg");
	font-style: normal;
	font-weight: normal;
}

@font-face {
	font-family: Popular-bold;
	src: url("http://apps.startribune.com/fonts/popular/bold/9a23c9ca-82fe-417a-9070-5f5daeaf6214-2.eot?") format("embedded-opentype"),
	url("http://apps.startribune.com/fonts/popular/bold/9a23c9ca-82fe-417a-9070-5f5daeaf6214-3.woff") format("woff"),
	url("http://apps.startribune.com/fonts/popular/bold/9a23c9ca-82fe-417a-9070-5f5daeaf6214-1.ttf") format("truetype"),
	url("http://apps.startribune.com/fonts/popular/bold/9a23c9ca-82fe-417a-9070-5f5daeaf6214-4.svg#web") format("svg");
	font-style: normal;
	font-weight: bold;
}
</style>
	
	
<style type="text/css">
	body { overflow-x:hidden; }
  td{ padding: 8.88px !important; font-family:Arial; }
  tr.odd td.sorting_1 { background-color: #efefef; }
  tr.even td.sorting_1 { background-color: #efefef; }
  tr.even { background-color: #fff !important; }
  tr.odd { background-color: #fff !important; }
  .dataTables_length{ display:none; }
  .dataTable{ margin-bottom:18px; }
  .dataTables_filter{ margin:10px; visibility:hidden;}
  .dataTables_length, .dataTables_info { display:none; }
  .dataTables_info { display:none;}
  .dataTables_scrollHead { display:none;}
  th { background: #ccc !important; }
  table.dataTable.no-footer{ margin-bottom:0 !important; }
  table { font-size:12px; }
  .dataTables_scrollBody thead{ visibility:hidden;height:0 !important; }
  th.sorting_asc, th.sorting_desc { background:#333 !important; font-weight:bold; color:#fff;}
  th { display: table-cell;vertical-align: initial; }
  th { padding:5px !important; }
</style>	
</head>

<body> 

<div id="wrapper">

<div class="title">Datatable of Live Google Sheet JSON data</div>
<table width="95%" id="donations"><thead><tr><th>Date</th><th>Recipient</th><th>Party</th><th>Amount</th></thead></table>

<div class="title">Live Google Sheet JSON Strings</div>
<div id="json"></div>

</div>

</body>

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src='//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js'></script>


<script>
//LIVE JSON MAGIC

//https://script.google.com/macros/s/AKfycbwG7mX6qPZaIhkwY2AJ2lU7kNarbm6OWIkWVfnmYZGYruIl40cu/exec?id=18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4&sheet=rixmannLobby
//https://script.google.com/macros/s/AKfycbwG7mX6qPZaIhkwY2AJ2lU7kNarbm6OWIkWVfnmYZGYruIl40cu/exec?id=18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4&sheet=paydayLoans
//https://script.google.com/macros/s/AKfycbwG7mX6qPZaIhkwY2AJ2lU7kNarbm6OWIkWVfnmYZGYruIl40cu/exec?id=18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4&sheet=paydayAvg
//https://script.google.com/macros/s/AKfycbwG7mX6qPZaIhkwY2AJ2lU7kNarbm6OWIkWVfnmYZGYruIl40cu/exec?id=18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4&sheet=paydayRegion

//THESE LOAD DIFFERENT TABS OF THE GOOGLE SHEET INTO SEPERATE JSON STRINGS, USING THE ACTUAL URLS
<?php

$jsonData = file_get_contents("https://script.googleusercontent.com/macros/echo?user_content_key=wjJENlbMu9FoKhNWwjMxSJsPr9Sb4Q8P051KRgyOujvwQzbWTp580dX3-rMBDYPZGU7dXetAt1Y1UNreOMpEIGCODbsW-eXwOJmA1Yb3SEsKFZqtv3DaNYcMrmhZHmUMWojr9NvTBuBLhyHCd5hHaxCoMjMSmZWLp6XAShvjQj50JtCfh4yP7n1RnEoDeOH7XqmOXgX8RYIyMAhIAtjnF9UDzNXGLr6Tnn87HQrfADBbhUq8CSx6Q4Y-drJvUreg9bCE7x4xP_CRgbcJqOwcXV6H-3QHYFWuxcG-w52aeuRwE8JqBw131QbEaztF8hJx&lib=MVcLnEUipyThKZcpmQKyqT_CoSfd4egCX");
$jsonData2 = file_get_contents("https://script.googleusercontent.com/macros/echo?user_content_key=TRZGI7Hy5roNaTVihJFAQiFRxlakl3T8NIyuYkeXnXX7c0i76zEhZeGNaDv5OKa-0XSpCUz9KdJ0BG7HPOKRlUG8MXWXdleqOJmA1Yb3SEsKFZqtv3DaNYcMrmhZHmUMWojr9NvTBuBLhyHCd5hHaxCoMjMSmZWLp6XAShvjQj50JtCfh4yP7n1RnEoDeOH7XqmOXgX8RYIyMAhIAtjnF9UDzNXGLr6Tnn87HQrfADBbhUq8CSx6Q4Y-drJvUreg9bCE7x4xP_CRgbcJqOwcXV6H-3QHYFWuvl7IGsXAM8k-ioDTrUGqnIdHSGJJvqmb&lib=MVcLnEUipyThKZcpmQKyqT_CoSfd4egCX");
$jsonData3 = file_get_contents("https://script.googleusercontent.com/macros/echo?user_content_key=8JLyE0ZalPuzKmaTpyTrjPLNaIAPBc1LAzfhq1ETtwaC0L1Ko7wBmfBYl5nasUSZpp5ioEPdvD10BG7HPOKRlWKjsuWkWOJBOJmA1Yb3SEsKFZqtv3DaNYcMrmhZHmUMWojr9NvTBuBLhyHCd5hHaxCoMjMSmZWLp6XAShvjQj50JtCfh4yP7n1RnEoDeOH7XqmOXgX8RYIyMAhIAtjnF9UDzNXGLr6Tnn87HQrfADBbhUq8CSx6Q4Y-drJvUreg9bCE7x4xP_CRgbcJqOwcXV6H-3QHYFWuvl7IGsXAM8mofs_zjXHYDQ&lib=MVcLnEUipyThKZcpmQKyqT_CoSfd4egCX");
$jsonData4 = file_get_contents("https://script.googleusercontent.com/macros/echo?user_content_key=cUFarJYg4_zdbsW7kB_-cfCBZjE3bI4vrH0KjYZ0o62TzT84-QhcUU8uUkgTlwggRe2AMx4HeYDSBMt56pzhd3k4CE8lvNClOJmA1Yb3SEsKFZqtv3DaNYcMrmhZHmUMWojr9NvTBuBLhyHCd5hHaxCoMjMSmZWLp6XAShvjQj50JtCfh4yP7n1RnEoDeOH7XqmOXgX8RYIyMAhIAtjnF9UDzNXGLr6Tnn87HQrfADBbhUq8CSx6Q4Y-drJvUreg9bCE7x4xP_CRgbcJqOwcXV6H-3QHYFWuvl7IGsXAM8kpDO0OyrPPWa3pD3igMEfz&lib=MVcLnEUipyThKZcpmQKyqT_CoSfd4egCX");

?>

//THESE ADD THEM TO JAVASCRIPT VARIABLES WE CAN ACCESS THROUGHOUT THE DOCUMENT
var dataLobby = <?php echo $jsonData; ?>;
var dataLoans = <?php echo $jsonData2; ?>;
var dataAvg = <?php echo $jsonData3; ?>;
var dataRegion = <?php echo $jsonData4; ?>;

$("#json").html(dataLobby + " " + dataLoans + " " + dataAvg + " " + dataRegion)

//HERE'S HOW TO LOAD JSONP INTO A DATATABLE, AS AN ALTERNATIVE METHOD
        $(document).ready(function() {
            donationTable = $('#donations').dataTable( {
                "bServerSide":false,
                "bProcessing":true,
                "sAjaxDataProp": "feed.entry",
                "oLanguage": {"sSearch": ""},
                "sAjaxSource": "https://spreadsheets.google.com/feeds/list/18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4/od6/public/values?&alt=json",
                "aoColumns": [                 
                    { "mDataProp": "gsx$date.$t" },
                    { "mDataProp": "gsx$recipientcommittee.$t" },
                    { "mDataProp": "gsx$party.$t" },
                    { "mDataProp": "gsx$amount.$t" },
                            ]
            } );
        } );
</script>
</html>