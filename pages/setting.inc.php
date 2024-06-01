<?php
		require_once("business/utilities.php");
?>
  <div class="container shadow-lg p-0 mb-3">
    <h3 class="p-4 text-white bg-purple" style="background-color: #9a57f2;">Change Passowrd</h3>
    <div class="container">
      <form action="?pageName=setting" class="w-75 m-auto py-5" method="post" onsubmit="return getAdminPassValidation()">
    <div class="form-group">
      <label for="oldpwd">Old Password:</label>
      <input type="password" class="form-control" placeholder="Enter password" id="oldpwd" name="oldpass" required>
    </div>
    <div class="form-group">
      <label for="newpwd">New Password:</label>
      <input type="password" class="form-control" placeholder="Enter password" id="newpwd" name="newpass" required>
    </div>

    <button type="submit" class="btn btn-primary" name="submit" value="changeadminpass"><i class="fad fa-check"></i> Confirm</button>
  </form>
    </div>
  </div>
  <?php
    if(isset($_POST['submit'])){
      if ($_POST['submit']=="changeadminpass") {
        changeAdminPass();
      }

    }
  ?>
