<!-- Modal -->
<div class="modal fade" id="addTrack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="addNewTrack" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลการเฝ้าระวัง Covid-19</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">สถานที่</label>
                        <div class="col-md-12">
                            <input id="tracker_place" name="tracker_place" type="text" placeholder="ระบุสถานที่"
                                class="form-control input-md" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">รายละเอียด</label>
                        <div class="col-md-12">
                            <input id="tracker_detail" name="tracker_detail" type="text"
                                placeholder="ตย.ชาวไทย เพศชาย 1 ราย กลับจากประเทศกลุ่มเสี่ยง"
                                class="form-control input-md" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">หมายเหตุ</label>
                        <div class="col-md-12">
                            <input id="tracker_note" name="tracker_note" type="text"
                                placeholder="มีไข้ x วัน มีอาการไอร่วม" class="form-control input-md" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">พิกัดละติจูด</label>
                        <div class="col-md-12">
                            <input id="tracker_lat" name="tracker_lat" type="text" placeholder="พิกัด - ละติจูด"
                                class="form-control input-md" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">พิกัดลองจิจูด</label>
                        <div class="col-md-12">
                            <input id="tracker_lng" name="tracker_lng" type="text" placeholder="พิกัด - ลองจิจูด"
                                class="form-control input-md" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิดหน้าต่าง</button>
                    <button id="btnSave" type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-save"></i> บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Travel -->
<div class="modal fade" id="trackerEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div id="ajaxTracker">
            <!-- เรียกใช้งานผ่าน ajax -->
        </div>
    </div>
</div>

<script>
$('.ajaxModal').click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
        url: "pages/modal_popup.php?id=" + id,
        cache: false,
        success: function(result) {
            $('#ajaxTracker').html(result);
        }
    });
});

$('#addNewTrack').on("submit", function(event) {
    event.preventDefault();
    swal({
            title: "ยืนยันการเพิ่มรายการใหม่ ?",
            icon: "warning",
            dangerMode: true,
            buttons: true,
        })
        .then((createCnf) => {
            if (createCnf) {
                document.getElementById("btnSave").disabled = true;
                $.ajax({
                    url: "class/query.php?op=add",
                    method: "POST",
                    data: $('#addNewTrack').serialize(),
                    success: function(data) {
                        swal('บันทึกข้อมูลแล้ว',
                            'Success',
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