<?php
session_start();
include_once '../assets/conn/dbconnect.php';


if(!isset($_SESSION['receptionistSession']))
{
header("Location: ../index.php");
}
$usersession = $_SESSION['receptionistSession'];
$res=mysqli_query($con,"SELECT * FROM receptionist WHERE receptionistEmail= '$usersession'");
$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Welcome Reciptionist <?php echo $userRow['receptionistFirstName'];?> <?php echo $userRow['receptionistLastName'];?></title>
        <!-- Bootstrap Core CSS -->
        <link href="assets/css/material.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="assets/css/sb-admin.css" rel="stylesheet">
        <!-- Custom Fonts -->
    </head>
    <body>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="dashboard.php">Welcome Receptionist <?php echo $userRow['receptionistFirstName'];?> <?php echo $userRow['receptionistLastName'];?></a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['receptionistFirstName']; ?> <?php echo $userRow['receptionistLastName']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                           
                            <li class="divider"></li>
                            <li>
                                <a href="logout.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="active">
                            <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="addschedule.php"><i class="fa fa-fw fa-table"></i> Doctor Schedule</a>
                        </li>
                        <li>
                            <a href="patientlist.php"><i class="fa fa-fw fa-edit"></i> Patient List</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <!-- navigation end -->

            <!-- Page Heading -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    
            <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">
                            Dashboard
                            </h2>
                            <form action="<?php $_PHP_SELF ?>" method="post" >
				<div style="text-align:center">
				<!-- maintaining dropdown state -->
				<?php
    $quer = "SELECT * from doctor order by doctorLastName ";

    $result=mysqli_query($con,$quer);

    $appStatus='';
    $sortby='';
    if (isset($_POST))
        if (is_array($_POST)){
            if (isset($_POST['appointmentStatus'])){
                $appStatus = $_POST['appointmentStatus'];
                $sortby =$_POST['sort'];
            }
            if(isset($_POST['appdate'])){
                $appdat=date($_POST['appdate']);
                $appdat1=date($_POST['appdate1']);
            }else {
                $appdat = date('Y-m-d');
                $appdat1 = date('Y-m-t');

            }
        }     
				?>
                For &nbsp;&nbsp;&nbsp;
								<select name="doctor" >
									<option value="%">All Doctors</option>
									<?php
									while ($doctors=mysqli_fetch_array($result)) {
                                    ?><option value="<?php echo $doctors["doctor_id"]?>">Dr <?php echo substr($doctors["doctorFirstName"],0,1)." " .$doctors["doctorLastName"]?> </option>;<?php
									}
                                    echo"</select>";?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Show :
			<select name="appointmentStatus">
				
				<option value="%">All Appointments</option>
				<option value="Attended" <?php if($appStatus=='Attended') echo ' selected="selected"'; ?>>All Attended Appointments</option>
				<option value="Pending" <?php if($appStatus=='Pending') echo ' selected="selected"'; ?>>All Pending Appointments</option>
				<option value="Missed" <?php if($appStatus=='Missed') echo ' selected="selected"'; ?>>All Missed Appointments</option>
				<option value="Cancelled" <?php if($appStatus=='Cancelled') echo ' selected="selected"'; ?>>All Canceled Appointments</option>
				
			</select>
			Sort By: <select  name='sort'>
			<option disabled >Ascending</option>
                         <option value='schedule_status ASC' <?php if($sortby=='schedule_status ASC') echo ' selected="selected"'; ?>>Schedule Status  </option>
					   <option value='schedule_date ,schedule_startTime ASC' <?php if($sortby=='schedule_date ,schedule_startTime ASC') echo ' selected="selected"'; ?>>Schedule Date  &nbsp;&nbsp;&nbsp;&nbsp;</option>
					   <option disabled >----------</option>
					   <option disabled >Descending</option>
					   <option value='schedule_status DESC' <?php if($sortby=='schedule_status DESC') echo ' selected="selected"'; ?>>Schedule Status  </option>
					   
                       <option value='schedule_date,schedule_startTime DESC' <?php if($sortby=='schedule_date,schedule_startTime DESC') echo ' selected="selected"'; ?>>Schedule Date  &nbsp;&nbsp;&nbsp;&nbsp;</option>
                                
                                 </select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			show from : <input type="date" id="date" name="appdate" value="<?php echo date("Y-m-d")?>"/>
			&nbsp;&nbsp;&nbsp;to &nbsp;&nbsp;&nbsp; <input type="date" id="date" name="appdate1" value="<?php echo date('Y-m-t')?>">
			&nbsp;&nbsp;&nbsp;<button class='btn btn-primary' type='submit' value='submit2' name='submit2'>Show Only</button>
		</div>
		</form><br>
</div>
                    </div>
                    <!-- Page Heading end-->

                   
                    <!-- panel start -->
                    <div class="panel panel-primary filterable">
                        <!-- Default panel contents -->
                       <div class="panel-heading">
                        <h3 class="panel-title">Appointment List</h3>
                        <div class="pull-right">
                            <button class="btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filter</button>
                        </div>
                        </div>
                        <div class="panel-body">
                        <!-- Table -->
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="patient ID" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Patient Name" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Doctor" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Date" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Appointment time" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Status" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Attended" disabled></th>
                                </tr>
                            </thead>
                            
                            <?php 
                            if(!isset($_POST['submit2'])){
                            $res1=mysqli_query($con,"SELECT a.*, b.*,c.*,d.*
                                                    FROM patient a
                                                    JOIN appointment b
                                                    On a.patient_id = b.patient_id
                                                    JOIN schedule c
                                                    On b.schedule_id=c.schedule_id
                                                    JOIN doctor d
                                                    ON c.doctor_id=d.doctor_id
                                                    ");

                            }else{
                            $doctor=$_POST['doctor'];
                            $appStatus=$_POST['appointmentStatus'];
                            $sortby=$_POST['sort'];
                            $date1 = $_POST['appdate1'];
	                        $date = $_POST['appdate'];
                            $res1=mysqli_query($con,"SELECT a.*, b.*,c.*,d.*
                            FROM patient a
                            JOIN appointment b
                            On a.patient_id = b.patient_id
                            JOIN schedule c
                            On b.schedule_id=c.schedule_id
                            JOIN doctor d
                            ON c.doctor_id=d.doctor_id
                            WHERE b.doctor_id LIKE '$doctor'
                            AND appointment_status LIKE '$appStatus'
                            AND schedule_date BETWEEN '$date' AND '$date1'");
                            }
                                  if (!$res1) {
                                    printf("Error: %s\n", mysqli_error($con));
                                    exit();
                                }
                            while ($appointment=mysqli_fetch_array($res1)) {
                                
                                if (strtolower($appointment['appointment_status'])=='pending') {
                                    $status="danger";
                                    $icon='minus-o';
                                    $checked='';

                                } else {
                                    $status="success";
                                    $icon='check-o';
                                    $checked = 'disabled';
                                }   

                                echo "<tbody>";
                                echo "<tr class='$status'>";
                                    echo "<td>" . $appointment['patient_id'] . "</td>";
                                    echo "<td>". $appointment['patientFirstName'] ."  ". $appointment['patientLastName'] . "</td>";
                                    echo "<td> Dr " . $appointment['doctorLastName'] . "</td>";
                                    echo "<td>" . $appointment['schedule_date'] . "</td>";
                                    echo "<td>" . $appointment['schedule_startTime'] . " to " . $appointment['schedule_endTime'] . "</td>";
                                    echo "<td><span class='fa fa-calendar-".$icon."' aria-hidden='true'></span>".' '."". $appointment['appointment_status'] . "</td>";
                                    echo "<form method='POST'>";
                                    echo "<td class='text-center'><input type='checkbox' name='enable' id='enable' value='".$appointment['appointment_ID']."' onclick='chkit(".$appointment['appointment_ID'].",this.checked);' ".$checked."></td>";
                               
                            } 
                                echo "</tr>";
                                    echo "</tbody>"; 
                                echo "</table>";
                                
                      
                       
                      
              
                   echo "<div class='panel panel-default'>";
                   echo "<div class='col-md-offset-3 pull-right'>";
                       echo "<button class='btn btn-primary' type='submit' value='Submit' name='submit'>Update</button>";
                        echo "</div>";
                        echo "</div>";
                        ?>
                    </div>
                </div>
                    <!-- panel end -->
 
<script type="text/javascript">
function chkit(uid, chk) {
   chk = (chk==true ? "1" : "0");
   var url = "checkdb.php?userid="+uid+"&chkYesNo="+chk;
   if(window.XMLHttpRequest) {
      req = new XMLHttpRequest();
   } else if(window.ActiveXObject) {
      req = new ActiveXObject("Microsoft.XMLHTTP");
   }
   // Use get instead of post.
   req.open("GET", url, true);
   req.send(null);
}
</script>


 
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->


       
        <!-- jQuery -->
        <script src="../patient/assets/js/jquery.js"></script>
        <script type="text/javascript">
$(function() {
$(".delete").click(function(){
var element = $(this);
var appointment_ID = element.attr("id");
var info = 'id=' + appointment_ID;
if(confirm("Are you sure you want to delete this?"))
{
 $.ajax({
   type: "POST",
   url: "deleteappointment.php",
   data: info,
   success: function(){
 }
});
  $(this).parent().parent().fadeOut(300, function(){ $(this).remove();});
 }
return false;
});
});
</script>
        <!-- Bootstrap Core JavaScript -->
        <script src="../patient/assets/js/bootstrap.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
         <!-- script for jquery datatable start-->
        <script type="text/javascript">
            /*
            Please consider that the JS part isn't production ready at all, I just code it to show the concept of merging filters and titles together !
            */
            $(document).ready(function(){
                $('.filterable .btn-filter').click(function(){
                    var $panel = $(this).parents('.filterable'),
                    $filters = $panel.find('.filters input'),
                    $tbody = $panel.find('.table tbody');
                    if ($filters.prop('disabled') == true) {
                        $filters.prop('disabled', false);
                        $filters.first().focus();
                    } else {
                        $filters.val('').prop('disabled', true);
                        $tbody.find('.no-result').remove();
                        $tbody.find('tr').show();
                    }
                });

                $('.filterable .filters input').keyup(function(e){
                    /* Ignore tab key */
                    var code = e.keyCode || e.which;
                    if (code == '9') return;
                    /* Useful DOM data and selectors */
                    var $input = $(this),
                    inputContent = $input.val().toLowerCase(),
                    $panel = $input.parents('.filterable'),
                    column = $panel.find('.filters th').index($input.parents('th')),
                    $table = $panel.find('.table'),
                    $rows = $table.find('tbody tr');
                    /* Dirtiest filter function ever ;) */
                    var $filteredRows = $rows.filter(function(){
                        var value = $(this).find('td').eq(column).text().toLowerCase();
                        return value.indexOf(inputContent) === -1;
                    });
                    /* Clean previous no-result if exist */
                    $table.find('tbody .no-result').remove();
                    /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
                    $rows.show();
                    $filteredRows.hide();
                    /* Prepend no-result row if all rows are filtered */
                    if ($filteredRows.length === $rows.length) {
                        $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
                    }}
                });
            });
        </script>
        <!-- script for jquery datatable end-->

    </body>
</html>