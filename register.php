<?php 
include('require/header.php'); 
include('database/connection.php');

if (isset($_POST['signup'])) {
    extract($_POST);

    $image_tmp = $_FILES['user_image']['tmp_name'];
    $image_name = $_FILES['user_image']['name'];
    $target_dir = "images/dp/";
    $target_file = $target_dir.$image_name;
    move_uploaded_file($image_tmp, $target_file);

    if(isset($_SESSION['role_id']) && $_SESSION['role_id']==2){
    $query = "INSERT INTO user (first_name, last_name, email, `user`.`password`, gender, date_of_birth, user_image, `user`.`address` , is_approved) 
              VALUES ('$first_name', '$last_name', '$email', '$password', '$gender', '$date_of_birth', '$image_name', '$address' , 'Approved')";
    
    } else $query = "INSERT INTO user (first_name, last_name, email, `user`.`password`, gender, date_of_birth, user_image, `user`.`address`) 
        VALUES ('$first_name', '$last_name', '$email', '$password', '$gender', '$date_of_birth', '$image_name', '$address')";
              
$result = mysqli_query($connect, $query);

if ($result) {
    echo "Account Created Successfully..";
    echo "<a href='login.php'>Login</a>";
} else {
    echo "Error ";
}
}
?>
<div class="container">
    <div class="card my-5">
        <div class="card-header bg-dark text-white">
            <h2>Create New Account</h2>
        </div>
        <div class="card-body">
        <form method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="col">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                </div>

                <div class="mb-3">
                <label name="user_image" class="form-label">Profile Image (Max size allowed 1Mb)</label>
                       <input type="file" class="form-control" id="user_image" name="user_image" accept="image/*" required>
</div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>

                <div class="d-grid">
                    <button type="submit" name="signup" class="btn btn-primary">Create Account</button>

    </div>
    </form>
  </div>
</div>
</div>

<script type="text/javascript" src="require/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
