<?php
include ("../config/my_sql.php");
$mysqli = connect();

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

$query = "SELECT * FROM tb_tracker LEFT JOIN tb_status ON tb_status.status_symbol = tb_tracker.tracker_status";
$result = mysqli_query($mysqli,$query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
    $ind=0;
    // Iterate through the rows, printing XML nodes for each
    while ($row = @mysqli_fetch_assoc($result)){
    // Add to XML document node
    echo '
    <marker ';
  echo ' tracker_id="' . $row['tracker_id'] . '" ';
  echo ' tracker_date="' . parseToXML($row['tracker_date']) . '" ';
  echo ' tracker_place="' . parseToXML($row['tracker_place']) . '" ';
  echo ' tracker_detail="' . parseToXML($row['tracker_detail']) . '" ';
  echo ' tracker_note="' . parseToXML($row['tracker_note']) . '" ';
  echo ' tracker_status="' . parseToXML($row['status_name']) . '" ';
  echo ' tracker_lat="' . $row['tracker_lat'] . '" ';
  echo ' tracker_lng="' . $row['tracker_lng'] . '" ';
  echo ' />';
    $ind = $ind + 1;
    }

    // End XML file
    echo '</markers>';

?>