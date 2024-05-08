<?php
session_start();

include 'koneksi.php';
if(isset($_POST['login'])) {
    $nama = htmlentities(strip_tags($_POST['nama']));
    $nisn = htmlentities(strip_tags($_POST['nisn']));

    $query = "SELECT * FROM siswa WHERE nama = '$nama' AND nisn = '$nisn'";

    $exec = mysqli_query($conn,$query);
    if(mysqli_num_rows($exec) === 0) {
        echo "<script>alert('Nim atau Nama Siswa Tidak Sesuai'); document.location ='index.php'; </script>";
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

    <title>MA Darul Azhar</title>

    <link href="img/logo.jpeg" rel="shortcut icon">

    
    <!-- tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

</head>
<style class="text/css">
body{
    background: url(img/gambar.jpeg) no-repeat;
    width: 100%;
    height: 100vh;
    background-color:gray;
    background-blend-mode:multiply;
    background-size: cover;
}
</style>

<body >

<nav style="margin-top:40px;margin:20px;">
        <div class="mx-auto w-full max-w-screen-xl  lg:py-2 container flex flex-wrap items-center justify-between mx-auto">
            <a href="/" class="flex items-center">
            <img src="<?php echo "img/logoMA.png"?>" class="h-12 mr-1" alt="masjid" />
                <span class="mx-auto self-center text-xl font-semibold whitespace-nowrap text-gray-00">MA DARUL AZHAR</span>
            </a>
        </div>
    </nav>

<div class="mx-auto">
    <section class="">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-8 lg:gap-16">
        <div class="flex flex-col justify-center">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-400 md:text-5xl lg:text-6xl dark:text-white">Portal Pembayaran SPP</h1>
            <p class="mb-6 text-lg font-normal text-gray-400 lg:text-xl dark:text-gray-400">Sumbangan Pembinaan Pendidikan (SPP) adalah iuran rutin setiap sekolah yang mewajibkan siswa-siswinya untuk membayar iuran tersebut setiap sebulan sekali.</p>
           
        </div>
        <div data-aos="flip-left"
     data-aos-easing="ease-out-cubic"
     data-aos-duration="2000" style="shadow:5px 5px;">
            <div class="shadow-20xl lg:max-w-xl p-6 space-y-8 sm:p-8 bg-gray-50 rounded-lg shadow-xl dark:bg-gray-800">
                <p class="text-2xl  font-bold text-gray-900 dark:text-gray">
                    Login Portal  <p style="margin-top:-1px;" class="text-xs text-gray-900 dark:text-white">Siswa/i diharapkan masuk menggunakan nisn masing masing <br> yang telah terdaftar di sekolah</p>
                </p>
                <form class="mt-8 space-y-6" action="#" method="post">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
                        <input type="text" autocomplete="off" required name="nama" class="bg-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="nama" aria-describedby="emailHelp" placeholder="Nama Siswa">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nisn Siswa</label>
                        <input type="text" autocomplete="off" required name="nisn" class="bg-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="nisn" placeholder="Masukkan nisn kamu">
                    </div>
                    <button type="submit" name="login" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:ring-blue-300 sm:w-auto dark:bg-green-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Masuk</button>
                    
                </form>
            </div>
        </div>
    </div>
    </section>
    

    <section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 z-10 relative">
        <div class="inline-flex justify-between items-center py-1 px-1 pr-4 mb-7 text-sm text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800">
            <span class="text-xs bg-blue-600 rounded-full text-white px-4 py-1.5 mr-3">profile</span> <span class="text-sm font-medium">Indentitas sekolah</span> 
            <svg aria-hidden="true" class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        </div>
        <h1 data-aos="fade-up" class="mb-4 text-4xl text-center font-extrabold tracking-tight leading-none text-gray-400 font-mono md:text-5xl lg:text-6xl dark:text-white">MA DARUL AZHAR <hr style="width:50%; margin:0 auto;font-size:10px;background-color:green;" ></h1>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-yellow-400 dark:bg-gray-800 border border-yellow-200 dark:border-gray-700 rounded-lg p-8 md:p-12">
                <a href="#" class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 mb-2">
                <svg aria-hidden="true" class="w-3 h-3 text-blue-800 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                    Npsn
                </a>
                <h2 class="text-gray-900 dark:text-white text-2xl font-extrabold mb-2">Nomor Pokok Sekolah Nasional (NPSN)</h2>
                <p class="text-lg font-normal text-gray-900 dark:text-gray-400 mb-4">10113697</p>
                
            </div>
            <div class="bg-green-400 dark:bg-gray-800 border border-green-700 dark:border-green-700 rounded-lg p-8 md:p-12">
                <a href="#" class="bg-purple-100 text-purple-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-purple-400 mb-2">
                <svg aria-hidden="true" class="w-3 h-3 text-blue-800 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                    Nss
                </a>
                <h2 class="text-gray-900 dark:text-white text-2xl font-extrabold mb-2">Nomor Statistik Sekolah (NSS)</h2>
                <p class="text-lg font-normal text-gray-900 dark:text-gray-400 mb-4">131211020010</p>
                
            </div>
        </div>
    </div>
        <div class="py-8 lg:py-16 mx-auto max-w-screen-xl px-4">
            <h2 class="mb-8 lg:mb-16 text-3xl font-extrabold tracking-tight leading-tight text-gray-900 dark:text-white md:text-4xl">Langkah penggunaan & <br> Pembayaran spp</h2>
            
<ol class="items-center sm:flex">
    <li class="relative mb-6 sm:mb-0">
        <div data-aos="flip-left" class="flex items-center">
            <div class="z-10 flex items-center justify-center w-6 h-6 bg-green-400 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                <svg aria-hidden="true" class="w-3 h-3 text-blue-800 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
        </div>
        <div class="mt-3 sm:pr-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Login</h3>
            <p class="text-base font-normal text-gray-500 dark:text-gray-400">untuk login diharapkan siswa/i menggunakan nisn yang terdaftar di sekolah</p>
        </div>
    </li>
    <li class="relative mb-6 sm:mb-0">
        <div data-aos="flip-left" class="flex items-center">
            <div class="z-10 flex items-center justify-center w-6 h-6 bg-green-400 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                <svg aria-hidden="true" class="w-3 h-3 text-blue-800 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
        </div>
        <div class="mt-3 sm:pr-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Bayar</h3>
            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Click Button bayar dan isi form dengan benar</p>
        </div>
    </li>
    <li class="relative mb-6 sm:mb-0">
        <div data-aos="flip-left" class="flex items-center">
            <div class="z-10 flex items-center justify-center w-6 h-6 bg-green-400 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                <svg aria-hidden="true" class="w-3 h-3 text-blue-800 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
        </div>
        <div class="mt-3 sm:pr-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Verifikasi</h3>
            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Setelah melakukan pembayaran harap tunggu sampai petugas memvalidasi pembayaran anda</p>
        </div>
    </li>
</ol>

        </div>
    </section>

    <section class="bg-white dark:bg-gray-900">
        <div class="gap-16 items-center py-8 px-4 mx-auto max-w-screen-xl lg:grid lg:grid-cols-2 lg:py-16 lg:px-6">
            <div class="grid grid-cols-2 gap-4 mt-8">
                <img data-aos="flip-up" class="w-full rounded-lg" src="img/gambar.jpeg" height="1000">
                <img data-aos="flip-up" class="mt-4 w-full lg:mt-10 rounded-lg" src="img/log.jpg" alt="office content 2">
            </div>
            <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
                <h2 style="width:35%;" data-aos="fade-up"class="mb-4 text-4xl text-xl w-25 font-extrabold border bg-green-400 border-green-400 rounded-xl text-center text-gray-900 dark:text-white">KAMI ADALAH</h2>
                <p class="mb-4">Berada di lingkungan SMA Negeri dewa medan yang beralamat di JL. Diponegoro 152, Ardirejo, Kec. Kepanjen, Kab. Malang. Gedung Perpustakaan terletak di lantai 2, diatas Ruang Guru, UKS, dan Kesiswaan. Gedung ini bersebelahan dengan Lab. komputer. Perpustakaan SMA Islam Kepanjen memiliki Luas gedung 16m x 8m. juga dilengkapi dengan sarana dan prasarana yang memadai. Sebagai penunjang kegiatan pembelajaran di sekolah. Sarana prasaran di perpustakaan SMA negeri dewa medan diantaranya sebagai berikut, a) LCD Proyektor, Televisi (TV), Komputer dan Wifi.</p>
            </div>
            
        </div>
    </section>
    

<!-- <hr style="color:red;">
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-8 lg:gap-16">
        <div class="flex flex-col justify-center">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Informasi Kontak </h1>
            <hr> <br>
            <p>Email : assalam@gmail.com</p><br>
            <p>No.Hp : 0877474747</p><br>
            <p>Alamar : Martubung, Medan, Sumatera Utara</p>
        </div> 
        <div>
        <iframe data-aos="fade-up"
     data-aos-duration="3000" class="w-full h-64 rounded-lg sm:h-96 shadow-xl" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=%C4%B0zmir+(My%20Business%20Name)&ie=UTF8&t=&z=14&iwloc=B&output=embed" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</section> -->

</div>


<footer class="bg-gray-200 ">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://flowbite.com/" class="hover:underline">ma darul azhar</a>. All Rights Reserved.</span>
    </div>
</footer>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
  AOS.init();
</script>

</body>

</html>