<h4 class="text-center"><i class="fa fa-map-marked-alt"></i>
    ตารางข้อมูลการติดตาม Covid-19 : อำเภอกัลยาณิวัฒนา
</h4>
<div class="table-responsive">
    <table id="reportTable" class="display compact table table-bordered nowrap" style="width:100%;font-size:14px;">
        <thead class="thead-dark">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">วันที่</th>
                <th>สถานที่</th>
                <th>รายละเอียด</th>
                <th>หมายเหตุ</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($res as $rs){ ?>
            <tr>
                <td class="text-center">
                    <a href="#trackerEdit" class="ajaxModal" data-toggle="modal"
                        data-id="<?=$rs['tracker_id']?>"><?=$rs['tracker_id']?>
                    </a>
                </td>
                <td class="text-center"><?=DBThaiShortDate($rs['tracker_date'])?></td>
                <td><?=$rs['tracker_place']?></td>
                <td><?=$rs['tracker_detail']?></td>
                <td><?=$rs['tracker_note']?></td>
                <td><span class="badge badge-info"><?=$rs['status_name']?></span></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>