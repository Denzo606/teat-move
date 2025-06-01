<style>
  /* .logo {
    margin: auto;
    font-size: 20px;
    background: white;
    padding: 7px 11px;
    border-radius: 50% 50%;
    color: #000000b3;
  } */
  body {
    font-family: 'Metal', serif;
    font-size: 18px;
  }

  @import url('https://fonts.googleapis.com/css2?family=Metal&display=swap');

  .navbar {
    background-color: #2c2c2c !important;
    height: 60px !important;
    display: flex !important;
    align-items: center !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 1000 !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
  }

  .navbar .container-fluid {
    padding: 0 15px !important;
    height: 100% !important;
    display: flex !important;
    align-items: center !important;
    background-color: #2c2c2c !important;
  }

  .navbar a {
    color: #ffffff !important;
    height: 60px !important;
    display: flex !important;
    align-items: center !important;
    padding: 0 15px !important;
    background-color: transparent !important;
  }

  .navbar .dropdown-item {
    color: #ffffff !important;
    padding: 8px 15px !important;
    line-height: 1.2 !important;
    height: auto !important;
    background-color: #2c2c2c !important;
  }

  .navbar .dropdown-item:hover {
    background-color: #3a3a3a !important;
  }

  .navbar .dropdown-menu {
    background-color: #2c2c2c !important;
    margin-top: 0 !important;
    display: none !important;
    min-width: 160px !important;
    border: none !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
  }

  .dropdown-toggle {
    padding: 0 10px !important;
    font-size: 16px !important;
    height: 60px !important;
    display: flex !important;
    align-items: center !important;
    background-color: transparent !important;
  }

  .dropdown:hover .dropdown-menu {
    display: block !important;
  }

  /* Ensure modal backdrop doesn't affect navbar */
  .modal-backdrop {
    z-index: 1040 !important;
  }

  .modal {
    z-index: 1050 !important;
  }

  /* Remove any conflicting styles */
  #circle {
    display: none !important;
  }

  /* Ensure navbar maintains its style when modal is open */
  .modal-open .navbar {
    background-color: #2c2c2c !important;
  }

  .modal-open .navbar .container-fluid {
    background-color: #2c2c2c !important;
  }

  /* Further ensure navbar elements maintain appearance when modal is open */
  .modal-open .navbar a {
      color: #ffffff !important; /* Ensure link text color remains white */
      filter: none !important; /* Remove any potential color filters */
      mix-blend-mode: normal !important; /* Prevent blend mode issues */
  }

  .modal-open .navbar .dropdown-item {
      color: #ffffff !important; /* Ensure dropdown item text color remains white */
      filter: none !important;
      mix-blend-mode: normal !important;
  }

  .modal-open .navbar .dropdown-item:hover {
      background-color: #3a3a3a !important; /* Re-apply hover background */
  }
</style>
<div class="row">
  <nav class="navbar navbar-light fixed-top">
    <div class="container-fluid">
      <div class="ml-auto" style="margin-left: auto !important; height: 15px !important; display: flex !important; align-items: center !important; margin-top: 15px !important;">
        <div class="dropdown" style="margin-top: 10px !important;">
          <a href="#" class="dropdown-toggle" id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top: 15px !important;"><?php echo $_SESSION['login_full_name'] ?> </a>
          <div class="dropdown-menu" aria-labelledby="account_settings">
            <!-- <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a> -->
            <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i>&nbsp; ចាកចេញ</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</div>

<script>
  $('#manage_my_account').click(function() {
    uni_modal("Manage Account", "manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own")
  })
</script>