<?php 
include 'header.php'; 
include 'koneksi.php';

if(isset($_GET['id_admin'])) {
	$id			= $_GET['id_admin'];
	$query		= "SELECT * FROM admin WHERE id_admin = '$id'";
	$exec		= mysqli_query($conn, $query);
	$res		= mysqli_fetch_assoc($exec);
	
}

if(isset($_POST['simpan'])) {
	$nama_admin = htmlentities(strip_tags(ucwords($_POST['nama_admin'])));
	$user_admin = htmlentities(strip_tags($_POST['user_admin']));
	$pass_admin = htmlentities(strip_tags($_POST['pass_admin']));
    $id_admin   = $_POST['id_admin'];

	$query      = "UPDATE admin SET nama_admin = '$nama_admin', user_admin = '$user_admin', pass_admin = '$pass_admin' WHERE id_admin = '$id_admin'";
	$exec		= mysqli_query($conn, $query);
	if($exec) {
		echo "<script>alert('Data Admin berhasil diedit') 
		document.location = 'index.php';
		</script>";
	}else {
		echo "<script>alert('Data Admin gagal diedit') 
		document.location = 'index.php';
		</script>";
	}

}
?>



<body class="bg-gradient-primary">

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
                                        <h1 class="h4 text-gray-900 mb-4">Edit Profil</h1>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                        	<input type="hidden" name="id_admin" value="<?= $res['id_admin'] ?>" >
                                            <input type="text" autocomplete="off" required name="nama_admin" class="form-control form-control-user" id="user" aria-describedby="emailHelp" placeholder="Masukkan Nama" value="<?= $res['nama_admin'] ?>" >
                                        </div>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" required name="user_admin" class="form-control form-control-user" id="user" aria-describedby="emailHelp" placeholder="Masukkan Username" value="<?= $res['user_admin'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" autocomplete="off" required name="pass_admin" class="form-control form-control-user"
                                                id="pass" placeholder="Masukkan Password" value="<?= $res['pass_admin'] ?>">
                                        </div>
                                        
                                        <button type="submit" name="simpan" class="btn btn-primary btn-user btn-block">Simpan</button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

<?php include 'footer.php'; ?>