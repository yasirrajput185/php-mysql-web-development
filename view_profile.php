<?php
include('require/header.php');
include('database/connection.php');
?>
<div class="container">
  <div class="row">
    <div class="col-md-9">
<h1>  View Profile </h1>
<hr>  
    <?php 

       $user_id=$_SESSION['user_id'];
       $query = "SELECT * FROM `user` WHERE user_id=$user_id";
       $result= mysqli_query($connect,$query);
      
       if ($row = mysqli_fetch_assoc($result)) {

      ?>

      <div class="card " style="width: 40%; align-items: center;">
  <img src="images/dp/<?php echo $row['user_image']?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo "Username : ".$row['first_name']." ".$row['last_name'];?></h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><b>Gender :  </b><?php echo $row['gender']?> </li>
    <li class="list-group-item"><b>Date of Birth :  </b><?php echo $row['date_of_birth']?> </li>
    <li class="list-group-item"><b>Email : </b> <?php echo $row['email']?> </li>
    <li class="list-group-item"><b>Address : </b> <?php echo $row['address']?> </li>
  </ul>
  <div class="card-body">
    <a href="edit_profile.php?user_image=<?php echo $_SESSION['user_image']?>" class="card-link"><button type="button" class="btn btn-primary">Edit Profile</button></a>
  </div>
</div>

<?php } ?>






    </div>
    <div class="col-md-3">

    <?php
include('require/sidebar.php');
?>

    </div>

    
  </div>
</div>






<?php
include('require/footer.php');
?>
