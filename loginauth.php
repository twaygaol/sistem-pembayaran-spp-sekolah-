<?php
session_start();

include 'koneksi.php';
if(isset($_POST['login'])) {
    $user = htmlentities(strip_tags($_POST['user']));
    $pass = htmlentities(strip_tags($_POST['pass']));

    $query = "SELECT * FROM admin WHERE user_admin = '$user'";
    $exec = mysqli_query($conn,$query);
    if(mysqli_num_rows($exec) !== 0) {
        $query = "SELECT * FROM admin WHERE pass_admin = '$pass'";
        $exec = mysqli_query($conn,$query);
            if(mysqli_num_rows($exec) !== 0) {
            $res = mysqli_fetch_assoc($exec);
            $_SESSION['admin'] = $res['id_admin'];
            $_SESSION['nama_admin'] = $res['nama_admin'];
            header('location: beranda.php');

    }else {
        echo "<script>alert('Password Salah');
        document.location ='loginauth.php';
        </script>";
    }
    }else{
        echo "<script>alert('User Admin Tidak Tersedia')
        document.location ='loginauth.php';
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Admin</title>

    <link href="img/logo.jpeg" rel="shortcut icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<style class="text/css">
body{
    background: url(img/background.jpeg) no-repeat;
    width: 100%;
    height: 100vh;
    background-size: cover;
}
</style>

<body>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="img/logo.jpeg" width="200" height="200">
                                        <p></p>
                                        <h1 class="h4 text-gray-900 mb-4"><span style="color:green;font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">MA DARUL AZHAR</span> </h1>
                                       
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" required name="user" class="form-control form-control-user" id="user" aria-describedby="emailHelp" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" autocomplete="off" required name="pass" class="form-control form-control-user"
                                                id="pass" placeholder="Password">
                                        </div>
                                        
                                        <button type="submit" name="login" class="btn btn-success btn-user btn-block">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>