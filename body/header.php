<?php
 if (!isset($_SESSION['admin_id'])) {
    $errormsg = base64_encode("Sign in first");
    header("Location:index.php?errormsg=$errormsg");
    exit;
  }


  $sel_user = $conn->query("SELECT * FROM admins WHERE admin_id = '".$_SESSION['admin_id']."'");
  $row      = $sel_user->fetch(PDO::FETCH_ASSOC); 
 

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"
        ><i class="fas fa-bars"></i
      ></a>
    </li>
    
  </ul>
  <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
  
        <li class="nav-item">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                Profile
            </button>
            <div class="dropdown-menu">
              <a href="profile_page.php" class="dropdown-item" style="color:black;">View profile</a>
              <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')" class="dropdown-item" style="color:black;">Logout</a>

            </div>
            
            
        </div>
        </li>
       
      </ul>

  


</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img
      src="docs\assets\img\logo1.png"
      alt="Logo"
      class="brand-image img-circle"
      width="100%"
      
    />
    <span class="brand-text font-weight-light">Ghani Hospital</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3">
      <!-- <div class="image">
        <img
          src="dist/img/user2-160x160.jpg"
          class="img-circle elevation-2"
          alt="User Image"
        />
      </div> -->
      
       <center>
       <a href="#" class="d-block "><?php echo ucfirst($row['admin_name'])?></a>
       </center>
      
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input
          class="form-control form-control-sidebar"
          type="search"
          placeholder="Search"
          aria-label="Search"
        />
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul
        class="nav nav-pills nav-sidebar flex-column"
        data-widget="treeview"
        role="menu"
        data-accordion="false"
      >
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

               
               <?php
               $sel_access = $conn->query('SELECT * FROM pages WHERE role = "'.$row['role'].'"');

               while ($acc_row = $sel_access->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <li class="nav-item">
                  <a href="<?php echo $acc_row['page_name']?>" class="nav-link">
                    <i class="<?php echo $acc_row['page_icon']?>"></i>
                    <p>
                    <?php echo $acc_row['page_title']?>
                    </p>
                  </a>
                </li>
                <?php
               }
               
               ?>
      
 
       
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<script>

const activePage = window.location;
const navlinks   = document.querySelectorAll('nav a').forEach(link => {
 if(link.href.includes(`${activePage}`))
 {
   link.classList.add('active');
 }
});




</script>