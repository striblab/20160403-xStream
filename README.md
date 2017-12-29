# xStream

by [Frey Hargarten](https://github.com/jeffhargarten)

Here are three ways to stream live Google Sheet data via JSON into webpage.

1.) Via JSONP

Grab the Google-generated JSONP URL and call it using any JSONP parser, like the one included with DataTables

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


2.) Via SheetsAsJSON

See the Google Sheets folder for details on setting this up. Once the sheet is generating a JSON string, you can grab the URL with PHP, one for each tab of the sheet.

Note that there are two URLs being used for each tab. One is the URL you input to access the JSON strings, the second is the one that Google redirects to. You'll want to save the first one for future access and then use the second one in your actual calls, like so:

//ORIGINAL URLS SAVES FOR FUTURE ACCESS:
//https://script.google.com/macros/s/AKfycbwG7mX6qPZaIhkwY2AJ2lU7kNarbm6OWIkWVfnmYZGYruIl40cu/exec?id=18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4&sheet=rixmannLobby
//https://script.google.com/macros/s/AKfycbwG7mX6qPZaIhkwY2AJ2lU7kNarbm6OWIkWVfnmYZGYruIl40cu/exec?id=18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4&sheet=paydayLoans
//https://script.google.com/macros/s/AKfycbwG7mX6qPZaIhkwY2AJ2lU7kNarbm6OWIkWVfnmYZGYruIl40cu/exec?id=18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4&sheet=paydayAvg
//https://script.google.com/macros/s/AKfycbwG7mX6qPZaIhkwY2AJ2lU7kNarbm6OWIkWVfnmYZGYruIl40cu/exec?id=18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4&sheet=paydayRegion

//ACTUAL REDIRECTED URLS TO PULL THE DATA
//THESE LOAD DIFFERENT TABS OF THE GOOGLE SHEET INTO SEPERATE JSON STRINGS
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


3.) As GeoJSON

//ORIGINAL URLS SAVES FOR FUTURE ACCESS:
//https://script.google.com/macros/s/AKfycbwG7mX6qPZaIhkwY2AJ2lU7kNarbm6OWIkWVfnmYZGYruIl40cu/exec?id=18hUwmsYrcVGJkFM7dGYNyfUzvCX6QBk0HkWIZnLF_d4&sheet=rixmannLobby

//PHP routine to turn JSON string into GEOJSON for mapping. You will have to modify the properties data and field names for each dataset most likely
<?php
$jsonData = file_get_contents("https://script.googleusercontent.com/macros/echo?user_content_key=wjJENlbMu9FoKhNWwjMxSJsPr9Sb4Q8P051KRgyOujvwQzbWTp580dX3-rMBDYPZGU7dXetAt1Y1UNreOMpEIGCODbsW-eXwOJmA1Yb3SEsKFZqtv3DaNYcMrmhZHmUMWojr9NvTBuBLhyHCd5hHaxCoMjMSmZWLp6XAShvjQj50JtCfh4yP7n1RnEoDeOH7XqmOXgX8RYIyMAhIAtjnF9UDzNXGLr6Tnn87HQrfADBbhUq8CSx6Q4Y-drJvUreg9bCE7x4xP_CRgbcJqOwcXV6H-3QHYFWuxcG-w52aeuRwE8JqBw131QbEaztF8hJx&lib=MVcLnEUipyThKZcpmQKyqT_CoSfd4egCX");

$geojsonData = geoJson($jsonData);

function geoJson($locales) 
    {
        $original_data = json_decode($locales, true);
        $features = array();

        foreach($original_data as $key => $value) { 
            $features[] = array(
                    'type' => 'Feature',
                    'geometry' => array('type' => 'Point', 'coordinates' => array((float)$value['lat'],(float)$value['lon'])),
                    'properties' => array('name' => $value['name'], 'id' => $value['id']),
                    );
            };   

        $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
        return json_encode($allfeatures, JSON_PRETTY_PRINT);

    }
?>

//THESE ADD THEM TO JAVASCRIPT VARIABLES WE CAN ACCESS THROUGHOUT THE DOCUMENT
var data = <?php echo $geojsonData; ?>;

