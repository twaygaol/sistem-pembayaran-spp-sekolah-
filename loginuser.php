<?php
session_start();

include 'koneksi.php';
if(isset($_POST['login'])) {
    $nama = htmlentities(strip_tags($_POST['nama']));
    $nisn = htmlentities(strip_tags($_POST['nisn']));

    $query = "SELECT * FROM siswa WHERE nama = '$nama' AND nisn = '$nisn'";

    $exec = mysqli_query($conn,$query);
    if(mysqli_num_rows($exec) === 0) {
        echo "<script>alert('Nim atau Nama Siswa Tidak Sesuai'); document.location ='loginuser.php'; </script>";
    } else {
        $res = mysqli_fetch_assoc($exec);
        $_SESSION['siswa'] = $res['id_siswa'];
        $_SESSION['nama'] = $res['nama'];
        $_SESSION['nisn'] = $res['nisn'];
        header('location: index_user.php');
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

    <title>Login User</title>

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
                        <!-- Nested Row within Card Body -->
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
                                            <input type="text" autocomplete="off" required name="nama" class="form-control form-control-user" id="nama" aria-describedby="emailHelp" placeholder="Nama Siswa">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" required name="nisn" class="form-control form-control-user"
                                                id="nisn" placeholder="NISN">
                                        </div>
                                        
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
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