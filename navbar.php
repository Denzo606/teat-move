<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

<style>
  .collapse a {
    text-indent: 10px;
  }

  #sidebar {
    background-color: #2c2c2c !important;
    margin-top: -35px !important;
    position: relative;
    z-index: 9999 !important;
  }

  .sidebar-list a {
    background-color: #2c2c2c !important;
    color: #ffffff;
    text-align: left !important;
    padding-left: 10px !important;
    display: flex !important;
    align-items: center !important;
    gap: 15px !important;
    transition: all 0.3s ease !important;
    position: relative;
    margin: 0 8px;
    border-radius: 6px;
  }

  #circle {
    padding: 5px 20px;
  }

  #circle img {
    width: 50px;
  }

  #sidebar p.khmer-text {
    margin: 2px 0 5px 10px;
    font-size: 17px;
    position: relative;
    z-index: 9999 !important;
  }

  .sidebar-list {
    padding: 0;
    position: relative;
    z-index: 9999 !important;
  }

  /* Add styles for main content area */
  .main-content {
    margin-top: -35px !important;
    padding-top: 2px !important;
    position: relative;
    z-index: 1;
  }

  /* Adjust content container */
  .container-fluid {
    margin-top: -35px !important;
    padding-top: 0 !important;
  }

  /* Adjust table spacing */
  .table-responsive {
    margin-top: 2px !important;
  }

  /* Adjust card spacing in dashboard */
  .card {
    margin-bottom: 8px !important;
  }

  /* Adjust row spacing */
  .row {
    margin-top: -35px !important;
  }

  .khmer-text {
    font-family: 'Kantumruy Pro', sans-serif !important;
  }

  .icon-field {
    width: 25px;
    text-align: center;
  }

  .icon-field i {
    margin-right: 0 !important;
  }

  .sidebar-list a:hover {
    background-color: #4a4a4a !important;
    color: #ffffff !important;
    transform: translateX(5px);
    border-radius: 6px;
  }

  .sidebar-list a.active {
    background-color: #4a4a4a !important;
    color: #ffffff !important;
    border-left: 4px solid #007bff !important;
    padding-left: 6px !important;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .sidebar-list a.active:hover {
    background-color: #4a4a4a !important;
    transform: none;
    border-radius: 6px;
  }

  /* Add loading overlay styles */
  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    z-index: 99999;
    display: none;
  }
</style>

<div class="loading-overlay"></div>
<div class="row">
  <nav id="sidebar" class='mx-lt-5 col-lg-5'>

    <img src="./assets/uploads/brand3.png" width="100px" style="margin-left: 50px; margin-top: -30px;">

    <p style="padding-left: 10px; color: white; font-size: 22px; margin-top: 5px;" class="khmer-text">ភោជនីយដ្ឋានមរកត​</p>
    <div class="sidebar-list khmer-text" style="font-size: 18px;">
	<?php if ($_SESSION['login_type'] == 1) : ?>
        <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home mr-3"></i></span> ផ្ទាំងគ្រប់គ្រង</a>
        <a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-tags mr-3"></i></span>ប្រភេទទំនិញ</a>
        <a href="index.php?page=sub_cate" class="nav-item nav-sub_cate"><span class='icon-field'><i class="fa fa-layer-group mr-3"></i></span>ប្រភេទទំនិញរង</a>
        <a href="index.php?page=product" class="nav-item nav-product"><span class='icon-field'><i class="fa fa-box mr-3"></i></span>ទំនិញ</a>
        <a href="index.php?page=customers" class="nav-item nav-customers"><span class='icon-field'><i class="fa fa-users mr-3"></i></span>អតិថិជន</a>
        <a href="billing/index.php" class="nav-item nav-billing"><span class='icon-field'><i class="fa fa-shopping-cart mr-3"></i></span>បញ្ជាទិញ</a>
        <a href="index.php?page=sales_report" class="nav-item nav-sales_report"><span class='icon-field'><i class="fa fa-chart-bar mr-3"></i></span>របាយការណ៍</a>
        <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-user-cog mr-3"></i></span>អ្នកប្រើប្រាស់</a>
      <?php endif; ?>
      <?php if ($_SESSION['login_type'] == 2) : ?>
        <a href="billing/index.php" class="nav-item nav-billing"><span class='icon-field'><i class="fa fa-shopping-cart mr-3"></i></span>បញ្ជាទិញ</a>
        <a href="index.php?page=customers" class="nav-item nav-customers"><span class='icon-field'><i class="fa fa-users mr-3"></i></span>អតិថិជន</a>
      <?php endif; ?>
    </div>

  </nav>

</div>

<script>
  // Add loading overlay function
  function showLoading() {
    $('.loading-overlay').fadeIn();
  }

  function hideLoading() {
    $('.loading-overlay').fadeOut();
  }

  $('.nav_collapse').click(function() {
    console.log($(this).attr('href'))
    $($(this).attr('href')).collapse()
  })

  // Function to set active state based on current URL
  function setActiveMenu() {
    // Get current URL path and page
    let currentPath = window.location.pathname;
    let currentPage = new URLSearchParams(window.location.search).get('page');

    // Remove all active classes first
    $('.sidebar-list a').removeClass('active');

    // Handle billing page
    if (currentPath.includes('billing/index.php')) {
      $('.nav-billing').addClass('active');
      return;
    }

    // Handle regular pages
    if (currentPage) {
      // Add active class to the matching nav item
      $('.nav-' + currentPage).addClass('active');
    } else {
      // If no page parameter, check if we're on home
      if (currentPath.endsWith('index.php') || currentPath.endsWith('/')) {
        $('.nav-home').addClass('active');
      }
    }

    // Debug log
    console.log('Current Path:', currentPath);
    console.log('Current Page:', currentPage);
    console.log('Active Element:', $('.sidebar-list a.active').length);
  }

  // Call the function when page loads
  $(document).ready(function() {
    <?php if ($_SESSION['login_type'] == 2): ?>
      showLoading();
      let currentPath = window.location.pathname;
      let currentPage = new URLSearchParams(window.location.search).get('page');
      
      // Allow access to billing and customers pages
      if (!currentPath.includes('billing/index.php') && currentPage !== 'customers') {
        window.location.href = 'billing/index.php';
      } else {
        hideLoading();
      }
    <?php else: ?>
      setActiveMenu();
    <?php endif; ?>
  });

  // Also update active state when clicking menu items
  $('.sidebar-list a').click(function() {
    $('.sidebar-list a').removeClass('active');
    $(this).addClass('active');
  });
</script>