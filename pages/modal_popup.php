<?php 
$id = $_REQUEST['id'];
include ('../config/my_sql.php');
include ('../class/data.class.php');
include ('../class/thaidate.class.php');
$mysqli = connect();
$fnc = new covid();
$res = $fnc->editDataTracker($id);
$stat = $fnc->getStatus();
?>
<form id="updateTrack" class="form-horizontal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-clipboard-list"></i>
                ข้อมูลการเฝ้าระวัง Covid-19 : <?=$id?>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="col-md-12">
                    <label for=""><i class="fa fa-home"></i> สถานที่ :</label>
                    <?=$res['tracker_place']?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for=""><i class="fa fa-file-alt"></i> รายละเอียด :</label>
                    <?=$res['tracker_detail']?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for=""><i class="fa fa-tag"></i> หมายเหตุ :</label>
                    <?=$res['tracker_note']?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for=""><i class="fa fa-map-marker-alt"></i> พิกัดละติจูด-ลองจิจูด :</label>
                    <?=$res['tracker_lat'].",".$res['tracker_lng']?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for=""><i class="fa fa-user-clock"></i> สถานะ :</label>
                    <span class="badge badge-info"><?=$res['status_name']?></span>
                </div>
            </div>
            <?php if(isset($res['tracker_confine'])){ ?>
            <div class="form-group">
                <div class="col-md-12">
                    <label for=""><i class="fa fa-user-clock"></i> การกักตัวเพื่อดูอาการ :</label>
                    <?php if($res['tracker_confine']=='Y'){
                        $count_confine = DateDiff($res['confine_start'],$res['confine_end']);
                        echo 'ทำการกักตัว '.DBThaiShortDate($res['confine_start'])." - ".DBThaiShortDate($res['confine_end'])." (".ceil($count_confine)." วัน)";}
                    ?>
                    <?php if($res['tracker_confine']=='N'){ echo 'ไม่มีการกักตัว'; } ?>
                    <?php if($res['tracker_confine']=='n/a'){ echo 'ไม่ระบุ'; } ?>
                </div>
            </div>
            <?php }else{ ?>
            <div class="form-group">
                <label for="">การกักตัวเพื่อดูอาการ</label>
                <div class="col-md-12">
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="radio" name="confine" id="radioSuccess1" value="n/a" checked>
                            <label for="radioSuccess1" style="color:#007bff;">
                                <i class="fa fa-times-circle"></i> ไม่ระบุ
                            </label>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="icheck-success d-inline">
                            <input type="radio" name="confine" id="radioSuccess2" value="Y">
                            <label for="radioSuccess2" style="color:#28a745;">
                                <i class="fa fa-user-shield"></i> ทำการกักตัว
                            </label>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="icheck-danger d-inline">
                            <input type="radio" name="confine" id="radioSuccess3" value="N">
                            <label for="radioSuccess3" style="color:#dc3545;">
                                <i class="fa fa-user-times"></i> ไม่มีการกักตัว
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div id="showCalendar">
                <label for=""><i class="fa fa-calendar-check"></i> วันที่เริ่มการกักตัว</label>
                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="dateStr" name="dstart" type="text" class="form-control input-md"
                            placeholder="วันที่เริ่ม" readonly>
                    </div>
                    <div class="col-md-6">
                        <input id="dateEnd" name="dend" type="text" class="form-control input-md"
                            placeholder="วันที่สิ้นสุด" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label for=""><i class="fa fa-user-clock"></i> สถานะการรักษา :</label>
                    <select name="status" class="form-control input-md" required>
                        <?php foreach ($stat AS $st){ ?>
                        <option value="<?=$st['status_symbol']?>"
                            <?php if ($res['tracker_status']==$st['status_symbol']){ echo 'SELECTED'; } ?>>
                            - <?=$st['status_name']?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิดหน้าต่าง</button>
            <button id="btnSave" type="submit" class="btn btn-success btn-sm">
                <i class="fa fa-edit"></i> บันทึกข้อมูล
            </button>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#showCalendar').hide();
    $('input[type="radio"]').click(function() {
        if ($(this).attr('id') == 'radioSuccess2') {
            $('#showCalendar').fadeIn();
        } else {
            $('#showCalendar').fadeOut();
        }
    });
});

$(function() {
    $.datetimepicker.setLocale('th');
    var dt = new Date();
    dt.setDate(dt.getDate());
    $("#dateStr").datetimepicker({
        format: 'Y/m/d',
        timepicker: false,
        lang: 'th',
    });
    $("#dateEnd").datetimepicker({
        format: 'Y/m/d',
        timepicker: false,
        lang: 'th',
        onShow: function(ct) {
            this.setOptions({
                minDate: jQuery('#dateStr').val() ? jQuery('#dateStr').val() : false
            })
        }
    });
});

$('#updateTrack').on("submit", function(event) {
    event.preventDefault();
    swal({
            title: "ยืนยันการอัพเดตข้อมูล ?",
            icon: "warning",
            dangerMode: true,
            buttons: true,
        })
        .then((createCnf) => {
            if (createCnf) {
                document.getElementById("btnSave").disabled = true;
                $.ajax({
                    url: "class/query.php?op=update&id=<?=$id?>",
                    method: "POST",
                    data: $('#updateTrack').serialize(),
                    success: function(data) {
                        swal('อัพเดตข้อมูลแล้ว',
                            'Update Success',
                            'success', {
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                                buttons: false,
                                timer: 1000,
                            });
                        window.setTimeout(function() {
                            location.replace('')
                        }, 1500);
                    }
                });
            }
        });
});
</script>