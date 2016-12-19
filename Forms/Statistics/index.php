<?php
//for admin use only
include '../../Library/SessionManager.php';
$session = new SessionManager();
    require('../../Library/DBHelper.php');
    $DB = new DBHelper();
require('../../Library/ControlsRender.php');
$Render = new ControlsRender();

$collections = $DB->GET_COLLECTION_TABLE();

//Disk space management
function foldersize($path) {
    $total_size = 0;
    $files = scandir($path);
    $cleanPath = rtrim($path, '/'). '/';

    foreach($files as $t) {
        if ($t<>"." && $t<>"..") {
            $currentFile = $cleanPath . $t;
            if (is_dir($currentFile)) {
                $size = foldersize($currentFile);
                $total_size += $size;
            }
            else {
                $size = filesize($currentFile);
                $total_size += $size;
            }
        }
    }

    return $total_size;
}

$units = explode(' ', 'B KB MB GB TB PB');
function format_size($size) {
    global $units;

    $mod = 1024;

    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }

    $endIndex = strpos($size, ".")+3;

    return substr( $size, 0, $endIndex).' '.$units[$i];
}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Statistics</title>
    <link rel = "stylesheet" type = "text/css" href = "../../Master/master.css" >
    <script type="text/javascript" src="../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="../../ExtLibrary/DataTables-1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../ExtLibrary/Chart.js"></script>
    <style>
        .graph-legend li span{
            display: inline-block;
            width: 1em;
            height: 1.2em;
            font-size: 1.2em;
            margin-right: 5px;
        }

        .graph-legend li{list-style-type: none;}

    </style>
</head>
<body>
<div id="wrap">
    <div id="main">
        <div id="divleft">
                    <?php include '../../Master/header.php';
                    include '../../Master/sidemenu.php' ?>
            </div>
        <div id="divright">
                    <h2 id="page_title">Statistics</h2>
                        <div id="table-header_right">Select Year: <select id="ddlYear" name="ddlYear"">
                            <?php
                            echo "<option value=''>Select</option>";
                            for($i = date("Y");$i >= 2015;$i--) {
                                if($i == date("Y")) echo "<option selected value='$i'>$i</option>";
                                else
                                    echo "<option value='$i'>$i</option>";
                            }
                            ?>
                            </select>
                        </div>
                    <div id="divscroller">
                        <table><tr>
                                <td style="vertical-align: top">
                                    <h3>Monthly Performance <span class="spanYear"></span></h3>
                                    <canvas id="chartMonthlyReport" height="400" width="500"></canvas>
                                    <div class="graph-legend" id="legendMonthlyReport"></div>
                                </td>
                                <td style="padding-left:80px;vertical-align: top">
                                        <h3 id="titleDocumentCount">Total Maps/Documents per Collection </h3>
                                            <canvas id="chartDocumentCount" height="300" width="300"></canvas>
                                            <div class="graph-legend" id="legendDocumentCount"></div>
                                    <div id="storage_capacity">
                                        <h3>Storage Capacity</h3>
                                        <?php
                                        $total_storage = 0;
                                        foreach($collections as $col)
                                        {
                                            $temp = foldersize($col['storagedir']);
                                            $total_storage += $temp;
                                            echo "<div class='storagecap'>$col[displayname]: " . format_size($temp) . "</div>";
                                        }
                                        echo "<div class='storagecap'><b>All Collections:" . format_size($total_storage) . "</b></div>";
                                        echo "<div class='storagecap'>Disk Free Space: " . format_size(disk_free_space($collections[0]['storagedir'])) . "</div>";
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h3>Weekly Performance <span class="spanYear"></span></h3>
                                    <canvas id="chartWeeklyReport" height="400" width="1000"></canvas>
                                    <div class="graph-legend" id="legendWeeklyReport"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
            </div>


    </div>
</div>
<?php include '../../Master/footer.php'; ?>
</body>
<script>
    var collections = <?php echo json_encode($collections); ?>;
    var collection_color = ['#0067C5','#00BC65','#FFAA2A','#FFFF00','#787878','#00000'];
    var collection_highlight = ['#FF5A5E','#7FFF55','#007FFF','#244400','#D4D4FF'];
    function getCollectionCount() {
        $('#divDocumentCount').show();
        $.ajax({
            type: "POST",
            url: "./collectioncount_processing.php",
            success: function (data) {
                var JSONdata = JSON.parse(data);
                //generate total chart
                var pieData = [];
                for (var i = 0; i < JSONdata.length; i++) {
                    var array = {
                        value: JSONdata[i].count,
                        color: collection_color[i],
                        highlight: collection_highlight[i],
                        label: JSONdata[i].collection
                    };

                    pieData.push(array);
                }
                var ctx1 = document.getElementById("chartDocumentCount").getContext("2d");
                window.MyPieChart = new Chart(ctx1).Pie(pieData);
                document.getElementById("legendDocumentCount").innerHTML = MyPieChart.generateLegend();
            }
        });
    }
    //weekly
        $("#ddlYear").change(function()
            {
                var year = $("#ddlYear").val();
                if(year != "") {
                    $(".spanYear").text(year);
                    $.ajax({
                        type: "POST",
                        url: "./weeklyreports_processing.php?year=" + year,
                        success: function (data) {
                            var JSONdata = JSON.parse(data);
                            //generate total chart
                            var weeklyData = [];
                            for (var i = 0; i < collections.length; i++) {
                                var array = {
                                    label: collections[i].displayname,
                                    fillColor: "transparent",
                                    strokeColor: collection_color[i],
                                    pointColor: collection_color[i],
                                    pointStrokeColor: collection_color[i],
                                    pointHighlightFill: collection_highlight[i],
                                    pointHighlightStroke: "rgba(151,187,205,1)",
                                    data: JSONdata.datasets[i]
                                };
                                weeklyData.push(array);
                                array = null;
                            }
                            //generate weekly input chart
                            var dat = {
                                labels: JSONdata.labels,
                                datasets: weeklyData,
                                options: {
                                    responsive: false
                                }
                            };
                            var ctx = new Chart(document.getElementById("chartWeeklyReport").getContext("2d")).Line(dat);
//                            document.getElementById("legendWeeklyreport").innerHTML = ctx.generateLegend();
                        }
                    });
                }

            });
        //monthly
            $("#ddlYear").change(function()
            {
                var year = $("#ddlYear").val();
                if(year != "") {
                    $.ajax({
                        type: "POST",
                        url: "./monthlyreports_processing.php?year=" + year,
                        success: function (data) {
                            var JSONdata = JSON.parse(data);
                            //generate total chart
                            var monthlyData = [];
                            for (var i = 0; i < collections.length; i++) {
                                var array = {
                                    label: collections[i].displayname,
                                    fillColor: "transparent",
                                    strokeColor: collection_color[i],
                                    pointColor: collection_color[i],
                                    pointStrokeColor: collection_color[i],
                                    pointHighlightFill: collection_highlight[i],
                                    pointHighlightStroke: "rgba(151,187,205,1)",
                                    data: JSONdata[i][0]
                                };
                                monthlyData.push(array);
                                array = null;
                            }
                            //generate weekly input chart
                            var dat = {
                                labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                                datasets: monthlyData,
                                options: {
                                    responsive: false
                                }
                            };
                            var ctx = new Chart(document.getElementById("chartMonthlyReport").getContext("2d")).Line(dat);
                            document.getElementById("legendMonthlyReport").innerHTML = ctx.generateLegend();
                        }
                    });
                }
                //resize height of the scroller
                $("#divscroller").height($(window).outerHeight() - $(footer).outerHeight() - $("#table-header_right").outerHeight() - $("#page_title").outerHeight() - 55);
            });

    $(document).ready(function() {
        //$("#ddlYear").change();
        getCollectionCount();
        $("#ddlYear").change();

    });



</script>
</html>
