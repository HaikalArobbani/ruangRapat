<!-- ========== Left Sidebar Start ========== -->


<?php
use Illuminate\Support\Facades\Auth;

$roleadmin = Auth::user()->role ?? 'No role';
$userhalo = Auth::user()->email ?? 'No email';
$roleUser = Auth::user()->divisiRapat ?? 'No email';
$adminRuangan = Auth::user()->adminRuangan ?? 'No role';

 

// dd($userhalo);
// dd($roleadmin);
// PHP end tag omitted on purpose because the rest of the code is HTML/JavaScript
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cetak variabel PHP ke konsol browser
    console.log(<?php echo json_encode("ah: " . $userhalo); ?>);
    console.log(<?php echo json_encode("nama saya adalah: " . $roleadmin); ?>);

});
</script>
<head>
<meta name="csrf-token" content="<?php echo csrf_token(); ?>">
<div class="leftside-menu">
  <!-- Brand Logo Light -->
  <a href="/home" class="logo logo-light">
    <span class="logo-lg">
      <img src="images/logopt.png" alt="logopt" height="100px" width="75px" />
    </span>
    <span class="logo-sm">
      <img src="images/logopt.png" alt="small logo pt" />
    </span>
  </a>

  <!-- Brand Logo Dark -->
  <a href="/home" class="logo logo-dark">
    <span class="logo-lg">
      <img src="images/logopt.png" alt="dark logo" />
    </span>
    <span class="logo-sm">
      <img src="images/logo-sm.png" alt="small logo" />
    </span>
  </a>
  <!-- <center>          <h6 class="text-white">Hai, <?php echo htmlspecialchars($userhalo); ?></h6>
</center> -->
  <!-- Sidebar Hover Menu Toggle Button -->
  <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
    <i class="ri-checkbox-blank-circle-line align-middle"></i>
  </div>
  <!-- Full Sidebar Menu Close Button -->
  <div class="button-close-fullsidebar">
    <i class="ri-close-fill align-middle"></i>
  </div>
  <!-- Sidebar -left -->
  <div class="h-100" id="leftside-menu-container" data-simplebar>
    <!-- Leftbar User -->
    <div class="leftbar-user">
      <a href="pages-profile.php">
        <img src="images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow-sm" />
        <span class="leftbar-user-name mt-2">Tosha Minner</span>
      </a>
    </div>

    <!--- Sidemenu -->
    <ul class="side-nav">
      <li class="side-nav-title">Navigation</li>

      <li class="side-nav-item">
        <a href="/home" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
          <i class="ri-home-4-line"></i>
          <span> Dashboards </span>
         
        </a>
      <li class="side-nav-title">Navigation</li>



      </li>
      
      <li class="side-nav-item">
      <?php

// Mengambil data user
$userhalo = Auth::user()->email ?? 'No email';

// Tampilkan pesan 'Hai' dengan email user
echo "<center><h6 class='text-white'>Hai, $userhalo</h6></center>";

?>


        <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false" aria-controls="sidebarEmail" class="side-nav-link">
        <i class="ri-database-line"></i>
                  <span> Data Master </span>
          <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="sidebarEmail">
          <ul class="side-nav-second-level">
 

          
            <!-- <a href="/ruangRapat" class="side-nav-link">
              <span> Ruang Rapat </span>
            </a> -->
            <?php
if ($roleUser > 0) {
    echo '<a href="/daftar_rapat_peserta" class="side-nav-link"> <span> Rapat Di ikuti </span></a>';
} else {
    echo '<a href="/pegawai" class="side-nav-link"><span> Admin </span></a>';
    echo '<a href="/ruangRapat" class="side-nav-link"><span> ruangRapat </span></a>';
    echo '<a href="/fasilitas" class="side-nav-link"><span> Fasilitas </span></a>';
    echo '<a href="/fasilitas_baru" class="side-nav-link"><span> Fasilitas Ruangan </span></a>';
    echo '<a href="/divisi" class="side-nav-link"><span> Divisi </span></a>';
}
?>

            <!-- <a href="/pegawai" class="side-nav-link">
              <span> Admin </span>
            </a>
            <a href="/fasilitas" class="side-nav-link">
              <span> Fasilitas </span>
            </a>
            <a href="/fasilitas_baru" class="side-nav-link">
              <span> Fasilitas Ruangan </span>
            </a>
            <a href="/divisi" class="side-nav-link">
              <span> Divisi </span>
            </a> -->
            <!-- <a href="/daftar_rapat_peserta" class="side-nav-link">
              <span>  Rapat Di ikuti</span>
            </a> -->
            <!-- <a href="/dataPegawai" class="side-nav-link">
              <span> Pegawai </span>
            </a> -->
          </ul>
        </div>
      </li>

      <?php
if ($roleadmin < 3) {
    echo '<a href="/permohonan_rapat" class="side-nav-link">
    <i class="ri-calendar-todo-line"></i>
                      <span> Permohonan </span>
    </a>';
    echo '<a href="/agenda" class="side-nav-link">
    <i class="ri-task-line"></i>
                      <span> Agenda </span>
    </a>';
} else {
}
?>



      <!-- <li class="side-nav-item">
        <a href="/permohonan_rapat" class="side-nav-link">
        <i class="ri-calendar-todo-line"></i>
                          <span> Permohonan </span>
        </a>
      </li> -->

       <!-- <li class="side-nav-item">
        <a href="/agenda" class="side-nav-link">
        <i class="ri-task-line"></i>
                          <span> Agenda </span>
        </a>
      </li> -->
      <li class="side-nav-item">
        <a href="/riwayat" class="side-nav-link">
          <i class="ri-history-line"></i>
          <span> Riwayat </span>
        </a>
      </li>
      
      <!-- <li>
          <a href="" class="waves-effect"><i class="fa fa-calendar-plus-o"></i><span> Permohonan Rapat </span></a>
        </li> -->
        
        <li class="side-nav-item">
    <a data-bs-toggle="collapse" href="#sidebarProfil" aria-expanded="false" aria-controls="sidebarEmail" class="side-nav-link">
    <i class="ri-user-line"></i>
            <span>Manajemen Profil</span>
        <span class="menu-arrow"></span>
    </a>
    <div class="collapse" id="sidebarProfil">
        <ul class="side-nav-second-level">
                <a href="javascript:void(0)" class="side-nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>

                </form>
                <?php
if ($adminRuangan < 1){
  echo '<a href="/register" class="side-nav-link">
  <span>Register</span>
</a>';
}

      ?>
                
           
        </ul>
    </div>
</li>


    <!--- End Sidemenu -->

    <div class="clearfix"></div>
  </div>
</div>
</head>

<!-- ========== Left Sidebar End ========== -->