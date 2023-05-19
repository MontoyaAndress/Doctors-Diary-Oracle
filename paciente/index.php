<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animaciones.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Panel</title>
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table,.anime{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
    
    
</head>
<body>
<?php

session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }

}else{
    header("location: ../login.php");
}


$connection = oci_connect("Admindoc", "doc2023", "//localhost/XEPDB1");

$sqlmain = "select * from patient where pemail=:email";
$stmt = oci_parse($connection, $sqlmain);
oci_bind_by_name($stmt, ":email", $useremail);
oci_execute($stmt);
$userrow = oci_fetch_assoc($stmt);

$userid = $userrow["PID"];
$username = $userrow["PNAME"];

?>

    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <center>
                                    <img src="../img/logo-doctors-diary.svg" alt="" width="180px">
                                </center>
                            </tr>
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Cerrar sesión" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home menu-active menu-icon-home-active" >
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Inicio</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctores.php" class="non-style-link-menu"><div><p class="menu-text">Doctores</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="cronograma.php" class="non-style-link-menu"><div><p class="menu-text">Reservaciones</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="citas.php" class="non-style-link-menu"><div><p class="menu-text">Mis citas</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="ajustes.php" class="non-style-link-menu"><div><p class="menu-text">Ajustes</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                        
                        <tr >
                            
                            <td colspan="1" class="nav-bar" >
                            <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Inicio</p>
                          
                            </td>
                            <td width="25%">

                            </td>
                            <td width="15%">
                                <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                                    Fecha:
                                </p>
                                <p class="heading-sub12" style="padding: 0;margin: 0;">
                                <?php
date_default_timezone_set('America/Mexico_City');

$today = date('d-m-Y');
echo $today;

$connection = oci_connect("Admindoc", "doc2023", "//localhost/XEPDB1");

$patientQuery = "SELECT * FROM patient";
$patientStmt = oci_parse($connection, $patientQuery);
oci_execute($patientStmt);

$doctorQuery = "SELECT * FROM doctor";
$doctorStmt = oci_parse($connection, $doctorQuery);
oci_execute($doctorStmt);

$appointmentQuery = "SELECT * FROM appointment WHERE appodate >= TO_DATE(:today, 'DD-MM-YYYY')";
$appointmentStmt = oci_parse($connection, $appointmentQuery);
oci_bind_by_name($appointmentStmt, ":today", $today);
oci_execute($appointmentStmt);

$scheduleQuery = "SELECT * FROM schedule WHERE scheduledate = TO_DATE(:today, 'DD-MM-YYYY')";
$scheduleStmt = oci_parse($connection, $scheduleQuery);
oci_bind_by_name($scheduleStmt, ":today", $today);
oci_execute($scheduleStmt);

?>

                                </p>
                            </td>
                            <td width="10%">
                                <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                            </td>
        
        
                        </tr>
                <tr>
                    <td colspan="4" >
                        
                    <center>
                    <table class="filter-container doctor-header patient-header" style="border: none;width:95%" border="0" >
                    <tr>
                        <td >
                            <h3>¡Bienvenido!</h3>
                            <h1><?php echo $username  ?></h1>
                        
                                Haga un seguimiento de su historial de citas pasadas y futuras.<br>Infórmese también de la hora prevista de llegada de su médico.<br><br>
                            </p>
                            
                            <h4>Busca a un médico aquí</h4>
                            <form action="cronograma.php" method="post" style="display: flex">

                                <input type="search" name="search" class="input-text " placeholder="Busca a un doctor con su nombre" list="Doctores" style="width:45%;">&nbsp;&nbsp;
                                
                        <?php
                        echo '<datalist id="doctors">';
                        $connection = oci_connect("Admindoc", "doc2023", "//localhost/XEPDB1");

                        $doctorQuery = "SELECT docname, docemail FROM doctor";
                        $doctorStmt = oci_parse($connection, $doctorQuery);
                        oci_execute($doctorStmt);

                        while ($row = oci_fetch_assoc($doctorStmt)) {
                            $d = $row["DOCNAME"];
                            echo "<option value='$d'><br/>";
                        }

                        echo '</datalist>';
                        ?>

                                
                           
                                <input type="Submit" value="Buscar" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                            
                            <br>
                            <br>
                            
                        </td>
                    </tr>
                    </table>
                    </center>
                    
                </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table border="0" width="100%"">
                            <tr>
                                <td width="50%">

                                    




                                    <center>
                                        <table class="filter-container" style="border: none;" border="0">
                                            <tr>
                                                <td colspan="4">
                                                    <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Estado</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%;">
                                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex">
                                                        <div>
                                                                <div class="h1-dashboard">
                                                                <?php
                                                                $doctorCount = oci_fetch_all($doctorStmt, $doctorResults);
                                                                echo $doctorCount;
                                                                ?>

                                                                </div><br>
                                                                <div class="h3-dashboard">
                                                                    Doctores &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </div>
                                                        </div>
                                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/doctors-hover.svg');"></div>
                                                    </div>
                                                </td>
                                                <td style="width: 25%;">
                                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                                        <div>
                                                                <div class="h1-dashboard">
                                                                <?php
$patientCount = oci_fetch_all($patientStmt, $patientResults);
echo $patientCount;
?>

                                                                </div><br>
                                                                <div class="h3-dashboard">
                                                                    Pacientes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </div>
                                                        </div>
                                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/patients-hover.svg');"></div>
                                                    </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td style="width: 25%;">
                                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex; ">
                                                        <div>
                                                                <div class="h1-dashboard" >
                                                                <?php
$appointmentCount = oci_fetch_all($appointmentStmt, $appointmentResults);
echo $appointmentCount;
?>

                                                                </div><br>
                                                                <div class="h3-dashboard" >
                                                                    Citas &nbsp;&nbsp;
                                                                </div>
                                                        </div>
                                                                <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('../img/icons/book-hover.svg');"></div>
                                                    </div>
                                                    
                                                </td>

                                                <td style="width: 25%;">
                                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;padding-top:21px;padding-bottom:21px;">
                                                        <div>
                                                                <div class="h1-dashboard">
                                                                <?php
$scheduleCount = oci_fetch_all($scheduleStmt, $scheduleResults);
echo $scheduleCount;
?>

                                                                </div><br>
                                                                <div class="h3-dashboard" style="font-size: 15px">
                                                                    Citas de hoy
                                                                </div>
                                                        </div>
                                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/session-iceblue.svg');"></div>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </center>








                                </td>
                                <td>


                            
                                    <p style="font-size: 20px;font-weight:600;padding-left: 40px;" class="anime">Tu próxima cita</p>
                                    <center>
                                        <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                                        <table width="85%" class="sub-table scrolldown" border="0" >
                                        <thead>
                                            
                                        <tr>
                                        <th class="table-headin">
                                                    
                                                
                                                    Número
                                                    
                                                    </th>
                                                <th class="table-headin">
                                                    
                                                
                                                Cita
                                                
                                                </th>
                                                
                                                <th class="table-headin">
                                                    Doctor
                                                </th>
                                                <th class="table-headin">
                                                    
                                                    Fecha y hora
                                                    
                                                </th>
                                                    
                                                </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php
$nextweek = date("d-m-Y", strtotime("+1 week"));
$sqlmain = "SELECT * FROM schedule
            INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid
            INNER JOIN patient ON patient.pid = appointment.pid
            INNER JOIN doctor ON schedule.docid = doctor.docid
            WHERE patient.pid = :userid AND schedule.scheduledate >= TO_DATE(:today, 'YYYY-MM-DD')
            ORDER BY schedule.scheduledate ASC";
$statement = oci_parse($connection, $sqlmain);
oci_bind_by_name($statement, ":userid", $userid);
oci_bind_by_name($statement, ":today", $today);
oci_execute($statement);

if (!oci_fetch($statement)) {
    echo '<tr>
            <td colspan="4">
                <br><br><br><br>
                <center>
                    <img src="../img/notfound.svg" width="25%">
                    <br>
                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No hay nada que mostrar aquí!</p>
                    <a class="non-style-link" href="cronograma.php">
                        <button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Contactar a un doctor &nbsp;</font></button>
                    </a>
                </center>
                <br><br><br><br>
            </td>
        </tr>';
} else {
    do {
        $scheduleid = oci_result($statement, "SCHEDULEID");
        $title = oci_result($statement, "TITLE");
        $apponum = oci_result($statement, "APPONUM");
        $docname = oci_result($statement, "DOCNAME");
        $scheduledate = oci_result($statement, "SCHEDULEDATE");
        $scheduletime = oci_result($statement, "SCHEDULETIME");

        echo '<tr>
                <td style="padding:30px;font-size:25px;font-weight:700;"> &nbsp;'
                    . $apponum .
                '</td>
                <td style="padding:20px;"> &nbsp;'
                    . substr($title, 0, 30) .
                '</td>
                <td>'
                    . substr($docname, 0, 20) .
                '</td>
                <td style="text-align:center;">
                    ' . substr($scheduledate, 0, 10) . ' ' . substr($scheduletime, 0, 5) . '
                </td>
            </tr>';
    } while (oci_fetch($statement));
}
?>


                 
                                            </tbody>
                
                                        </table>
                                        </div>
                                        </center>







                                </td>
                            </tr>
                        </table>
                    </td>
                <tr>
            </table>
        </div>
    </div>


</body>
</html>