<?php 
include ('class/data.class.php'); 
include ('config/my_sql.php'); 
include ('class/thaidate.class.php'); 
$mysqli = connect(); 
$fnc = new covid(); 
$res = $fnc->getDataTracker();
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>แผนที่ข่าว Covid-19 : อำเภอกัลยาณิวัฒนา</title>
    <style>
    #map {
        height: 100%;
        width: 100%;
    }

    html,
    body {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
    }
    </style>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Kanit:300&display=swap" rel="stylesheet">
    <!-- Custom Css -->
    <link href="dist/css/custom.css">
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert -->
    <script src="plugin/sweetalert/sweetalert.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- DatePicker -->
    <link rel="stylesheet" href="plugin/datepicker/jquery.datetimepicker.css">
    <script type="text/javascript" charset="utf8" src="plugin/datepicker/jquery.datetimepicker.full.js"></script>
    <link href="plugin/select2/select2.min.css" rel="stylesheet" />
    <script src="plugin/select2/select2.min.js"></script>
    <!-- DataTable -->
    <link rel="stylesheet" type="text/css" href="plugin/datatable/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="plugin/datatable/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="plugin/datatable/dataTables.responsive.min.js"></script>
    <script type="text/javascript" charset="utf8" src="plugin/datatable/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script>
    $(document).ready(function() {
        var table = $('#reportTable').DataTable({
            responsive: true,
        });
    });
    </script>
</head>

<html>

<body class="row">
    <div id="map" class="col-md-7"></div>
    <div class="col-md-5"><br>
        <?php include ('pages/dataTable.php');?>
        <?php include ('pages/chart.php');?>
    </div>
    <?php include ('pages/modal.php');?>
    <script>
    var customLabel = {
        รอตรวจสอบ: {
            label: 'A'
        },
        กำลังรักษา: {
            label: 'B'
        },
        หายแล้ว: {
            label: 'C'
        },
        เสียชีวิต: {
            label: 'D'
        }
    };

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(19.0780781, 98.3119017),
            zoom: 13
        });
        var infoWindow = new google.maps.InfoWindow;

        // Change this depending on the name of your PHP or XML file
        downloadUrl('http://localhost/watchan19/class/tracker.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
                var tracker_id = markerElem.getAttribute('tracker_id');
                var tracker_date = markerElem.getAttribute('tracker_date');
                var tracker_place = markerElem.getAttribute('tracker_place');
                var tracker_detail = markerElem.getAttribute('tracker_detail');
                var tracker_note = markerElem.getAttribute('tracker_note');
                var tracker_status = markerElem.getAttribute('tracker_status');
                var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('tracker_lat')),
                    parseFloat(markerElem.getAttribute('tracker_lng')));

                var infowincontent = document.createElement('div');
                var text = document.createElement('text');
                text.textContent = "รหัส :" + " " + tracker_id;
                infowincontent.appendChild(text);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = "พิกัด :" + " " + tracker_place;
                infowincontent.appendChild(text);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = "รายละเอียด :" + " " + tracker_detail;
                infowincontent.appendChild(text);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = "หมายเหตุ :" + " " + tracker_note;
                infowincontent.appendChild(text);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = "สถานะ :" + " " + tracker_status;
                infowincontent.appendChild(text);
                infowincontent.appendChild(document.createElement('br'));

                var icon = customLabel[tracker_status] || {};
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    label: icon.label
                });
                marker.addListener('click', function() {
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
                });
                google.maps.event.addListener(map, 'click', function(event) {
                    var vlat = event.latLng.lat();
                    var vlng = event.latLng.lng();
                    document.getElementById('tracker_lat').value = vlat;
                    document.getElementById('tracker_lng').value = vlng;
                    $('#addTrack').modal('toggle');
                    console.log(vlat + "," + vlng);
                });
                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        infoWindow.setPosition(pos);
                        infoWindow.setContent("พิกัดของคุณ " + position.coords.latitude + "," +
                            position.coords
                            .longitude);
                        infoWindow.open(map);
                        map.setCenter(pos);
                    }, function() {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }
            });
        });
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API&callback=initMap">
    </script>
</body>

</html>