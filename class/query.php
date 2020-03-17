<?php
include ('sql.class.php');
include ('../config/my_sql.php');
include ('../class/thaidate.class.php');

$mysqli = connect();
$op = $_REQUEST['op'];

if($op=='add'){
    $tracker_place = mysqli_real_escape_string($mysqli,$_REQUEST['tracker_place']);
    $tracker_detail = mysqli_real_escape_string($mysqli,$_REQUEST['tracker_detail']);
    $tracker_note = mysqli_real_escape_string($mysqli,$_REQUEST['tracker_note']);
    $tracker_lat = mysqli_real_escape_string($mysqli,$_REQUEST['tracker_lat']);
    $tracker_lng = mysqli_real_escape_string($mysqli,$_REQUEST['tracker_lng']);
    
    $data = array(
        "tracker_place"=>$tracker_place,
        "tracker_detail"=>$tracker_detail,
        "tracker_note"=>$tracker_note,
        "tracker_lat"=>$tracker_lat,
        "tracker_lng"=>$tracker_lng
    );
    insertSQL("tb_tracker",$data);
}

if($op=='update'){
    $id = $_REQUEST['id'];
    $confine = mysqli_real_escape_string($mysqli,$_REQUEST['confine']);
    $stats = mysqli_real_escape_string($mysqli,$_REQUEST['status']);
    $strStartDate = Date2DBDate($_REQUEST['dstart']);
    $strEndDate = Date2DBDate($_REQUEST['dend']);
    $save = date("Y-m-d h:i:s");
    $data = array(
        "tracker_confine"=>$confine,
        "tracker_status"=>$stats,
        "confine_start"=>$strStartDate,
        "confine_end"=>$strEndDate,
        "tracker_save"=>$save,
    );
    updateSQL("tb_tracker",$data,"tracker_id=$id");
}
?>