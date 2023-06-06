<?php 
    include("require/header.php");
?>

<link rel="stylesheet" href="require/bootstrap/css/bootstrap.min.css">
<div class="container">
  <div class="row justify-content-center">
  
    <div class="col-md-6 col-lg-5">
  
      <div class="card my-5">
        <div class="card-body p-4 bg-dark text-white">
      <h3 class="card-title mb-4 text-center text-white">Change Password</h3>
            
            <?php 
              if(isset($_GET['msg'])){
                echo "<h5 class='text-center text-white'>".$_GET['msg']."</h5>"; 
              }
              if(!isset($_GET['mail_sent'])){
            ?>

          <form method="post" action="all_admin_features.php">
            <div class="mb-3">
            <label class="form-label text-white">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" name="change_password_email" aria-describedby="emailHelp" required>
            </div>
            <div class="d-grid">
              <button type="submit" name='send_email' class="btn btn-primary text-white">Send Email</button>
            </div>
          </form>
          
          <?php 
          } else {
            $user_id=$_GET['user_id']; 
            ?>
          <form method="post" action="all_admin_features.php?user_id=<?php echo $user_id?>"> 
            <div class="mb-3">
            <label class="form-label text-white">Code</label>
              <input type="text" class="form-control" id="exampleInputEmail1" name="pin_code" aria-describedby="emailHelp" required>
              <div id="emailHelp" class="form-text text-white">Check your email and enter code.</div>
            </div>

            <div class="d-grid">
              <button type="submit" name='send_code' class="btn btn-primary text-white">Send Code</button>
            </div>
  
            </div>
          </form>
        <?php } ?>
      </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="require/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>