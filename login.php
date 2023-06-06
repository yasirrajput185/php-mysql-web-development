<?php 

include("require/header.php");
include('database/connection.php');

$msg='';
if(isset($_GET['msg'])){
  $msg=$_GET['msg'];
}
if (isset($_POST['login'])) {
extract($_POST);
$_SESSION['email']=$email;

$query = "SELECT * FROM `user` WHERE email = '$email' AND `user`.`password` = '$password'";
    
    $result= mysqli_query($connect,$query);
    
    if ($row = mysqli_fetch_assoc($result)) {
      if($row['is_approved']=='Approved'){

        if($row['is_active']=='Active'){
            $_SESSION['user_id']=$row['user_id'];
            $_SESSION['user_name']=$row['first_name']." ".$row['last_name'];
            $_SESSION['role_id']=$row['role_id'];
            //print_r($_SESSION);
            header('location:home.php');
        }elseif($row['is_active']=='InActive'){
          $msg = 'Your Account is Inactive';
        }
      }elseif($row['is_approved']=='Rejected'){
        $msg='Sorry..!! Your Account Request is Rejected';
      }elseif($row['is_approved']=='Pending'){
        $msg='Please Wait..!! Your Account request is pending';
      }
  } else {
      $msg='Wrong email or password';
  }
}


?>


<div class="container">

<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
  <div class="card my-5">
      <div class="card-body p-4 bg-dark">
      
        <h3 class="card-title mb-4 text-center text-white">Login</h3>
        <?php if(isset($msg)){ ?>
        <h4 class="card-title mb-4 text-center text-white"><?php echo $msg ?></h4>
      <?php } ?>
      <form method="post">
      
        <div class="mb-3">
          <label class="form-label text-white">Email address</label>
      
          <input type="email" class="form-control"  aria-describedby="emailHelp" name="email" required>

          <div id="emailHelp" class="form-text text-white">We'll never share your email with anyone else.</div>
        </div>
      
          <div class="mb-3">
        <label class="form-label text-white">Password</label>
        <input type="password" class="form-control"  name="password" required>
        </div>
        <div class="mb-3 form-check">
             <input type="checkbox" class="form-check-input text-white" id="exampleCheck1">
          <label class="form-check-label text-white">Remember me</label>
      </div>
    <div class="d-grid">
          <button type="submit" name="login" class="btn btn-primary text-white">Login</button>
          </div>
      </form>
        <div class="text-center mt-3">
        <a href="forgot_password.php" class="text-white">Forgot Password?</a>
      <span class="text-white mx-2">|</span>
        <a href="register.php" class="text-white">Create New Account</a>
        </div>
    
    </div>
  </div>
  </div>

</div>
</div>
<script type="text/javascript" src="require/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
