<?php
include('require/header.php');
include('database/connection.php');
if(isset($_SESSION['user_id'])){
    ?>
<div class="container">
  <div class="row">
    <div class="col-md-9">

    <?php

    $user_id=$_SESSION['user_id'];
    if(isset($_GET['user_id'])){
        $user_id=$_GET['user_id'];
    }
    if(isset($_POST['update'])){
    extract($_POST);
    $image_tmp = $_FILES['user_image']['tmp_name'];
    $image_name = $_FILES['user_image']['name'];
    $target_dir = "images/dp/";
    $target_file = $target_dir.$image_name;
    move_uploaded_file($image_tmp, $target_file);

    if($image_name==''){
        $image_name=$_GET['user_image'];
    }

        $query = "UPDATE user SET first_name='$first_name' , last_name='$last_name', gender='$gender' , date_of_birth='$date_of_birth', user_image='$image_name' , address = '$address' WHERE user_id = $user_id";
        $result = mysqli_query($connect, $query);
    
         // if(isset($_GET['user_id'])){
         //     header('location:manage_user.php?msg=Updated Successfully');
         // }else header('location:view_profile.php?msg=Profile Updated Successfully');
        

}

       $query = "SELECT * FROM `user` WHERE user_id=$user_id";
       $result= mysqli_query($connect,$query);
      
       if ($row = mysqli_fetch_assoc($result)) {

      ?>

      <div class="card my-5">
        <div class="card-header bg-dark text-white">
            <h2>Edit Profile</h2>
        </div>
        <div class="card-body">
        <form method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $row['first_name']?>" required>
                    </div>
                    <div class="col">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $row['last_name']?>" required>
                    </div>
                </div>

        
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <?php 
                        if($row['gender']=='Male'){
                        ?>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <?php   
                        }else{ 
                        ?>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        <?php
                        }
                        ?>
                        
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo $row['date_of_birth']?>" required>
                </div>

                <div class="mb-3">
                
                <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px;">
                    <img src="images/dp/<?php echo $row['user_image'] ?>" alt="Profile Image" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                    <label name="user_image" class="form-label">Change Profile Image (Max size allowed 1Mb)</label>
                   <input type="file" class="form-control" id="user_image" name="user_image" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']?>" required>
                </div>

                <div class="d-grid">
                    <button type="submit" name="update" class="btn btn-primary">Update Profile</button>

    </div>
    </form>
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
}else header('location:home.php');

 
?>




