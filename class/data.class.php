<?php

Class covid {

    public function getDataTracker(){
        $sql = "SELECT * FROM tb_tracker 
                LEFT JOIN tb_status ON tb_status.status_symbol = tb_tracker.tracker_status
                WHERE tb_tracker.tracker_id != '0'";
        global $mysqli; $obj = array();
        $res = $mysqli->query($sql);
        while($data = $res->fetch_assoc()) {
            $obj[] = $data;
        }
    return $obj;
    }

    public function editDataTracker($id){
        $sql = "SELECT * 
                FROM tb_tracker
                LEFT JOIN tb_status ON tb_status.status_symbol = tb_tracker.tracker_status
                WHERE tb_tracker.tracker_id = '{$id}'";
        global $mysqli;
        $res = $mysqli->query($sql);
        $data = $res->fetch_assoc();
    return $data;
    }

    public function getStatus(){
        $sql = "SELECT * FROM tb_status";
        global $mysqli; $obj = array();
        $res = $mysqli->query($sql);
        while($data = $res->fetch_assoc()) {
            $obj[] = $data;
        }
    return $obj;
    }

    function getChart(){
        $sql = "SELECT
            (SELECT COUNT(tracker_id) FROM tb_tracker WHERE tracker_status = 'A') AS count_a,
            (SELECT COUNT(tracker_id) FROM tb_tracker WHERE tracker_status = 'B') AS count_b,
            (SELECT COUNT(tracker_id) FROM tb_tracker WHERE tracker_status = 'C') AS count_c,
            (SELECT COUNT(tracker_id) FROM tb_tracker WHERE tracker_status = 'D') AS count_d";
        global $mysqli;
        $res = $mysqli->query($sql) or die("SQL Error: <br>".$sql."<br>".$mysqli->error);
        $data = $res->fetch_assoc();
    return $data;
    }

}

?>