<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animaciones.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
        
    <title>Inicio de sesión</title>

    
    
</head>
<body>
<?php
    session_start();

    $_SESSION["user"] = "";
    $_SESSION["usertype"] = "";

    date_default_timezone_set('america/mexico_city');
    $date = date('Y-m-d');

    $_SESSION["date"] = $date;

    $connection = oci_connect("Admindoc", "doc2023", "//localhost/XEPDB1");

    if ($_POST) {
        $email = $_POST['useremail'];
        $password = $_POST['userpassword'];

        $error = '<label for="promter" class="form-label"></label>';

        $query = "SELECT * FROM webuser WHERE email=:email";
        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ":email", $email);
        oci_execute($statement);

        if (oci_fetch($statement)) {
            $utype = oci_result($statement, "USERTYPE");
            if ($utype == 'p') {
                $query = "SELECT * FROM patient WHERE pemail=:email AND ppassword=:password";
                $statement = oci_parse($connection, $query);
                oci_bind_by_name($statement, ":email", $email);
                oci_bind_by_name($statement, ":password", $password);
                oci_execute($statement);

                if (oci_fetch($statement)) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'p';
                    header('location: paciente/index.php');
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Correo o contraseña invalidos</label>';
                }
            }elseif ($utype == 'a') {
                $query = "SELECT * FROM admin WHERE aemail=:email AND apassword=:password";
                $statement = oci_parse($connection, $query);
                oci_bind_by_name($statement, ":email", $email);
                oci_bind_by_name($statement, ":password", $password);
                oci_execute($statement);
            
                if (oci_fetch($statement)) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'a';
                    header('location: admin/index.php');
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Correo o contraseña invalidos</label>';
                }
            } elseif ($utype == 'd') {
                $query = "SELECT * FROM doctor WHERE docemail=:email AND docpassword=:password";
                $statement = oci_parse($connection, $query);
                oci_bind_by_name($statement, ":email", $email);
                oci_bind_by_name($statement, ":password", $password);
                oci_execute($statement);
            
                if (oci_fetch($statement)) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'd';
                    header('location: doctor/index.php');
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Correo o contraseña invalidos</label>';
                }
            }
        }
        oci_close($connection);
    }
    ?>





    <center>
    <div class="container">
        <table border="0" style="margin: 0;padding: 0;width: 60%;">
            <tr>
                <td>
                    <p class="header-text">Bienvenido</p>
                </td>
            </tr>
        <div class="form-body">
            <tr>
                <td>
                    <p class="sub-text">Ingresa tus datos para continuar</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td">
                    <label for="useremail" class="form-label">Correo electrónico: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="email" name="useremail" class="input-text" placeholder="Correo electrónico" required>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <label for="userpassword" class="form-label">Contraseña: </label>
                </td>
            </tr>

            <tr>
                <td class="label-td">
                    <input type="Password" name="userpassword" class="input-text" placeholder="Contraseña" required>
                </td>
            </tr>


            <tr>
                <td><br>
        
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" value="Inicia sesión" class="login-btn btn-primary btn">
                </td>
            </tr>
        </div>
            <tr>
                <td>
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">¿No tienes una cuenta&#63; </label>
                    <a href="signup.php" class="hover-link1 non-style-link">Regístrate</a>
                    <br><br><br>
                </td>
            </tr>
                        
                        
    
                        
                    </form>
        </table>

    </div>
</center>
</body>
</html>