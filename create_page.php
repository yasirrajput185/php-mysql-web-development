<?php
include('require/header.php');

if(isset($_POST['create_blog'])){

    $image_tmp = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    $target_dir = "images/post/";
    $target_file = $target_dir.$image_name;
    move_uploaded_file($image_tmp, $target_file);

    extract($_POST);
    $user_id=$_SESSION['user_id'];




    $query = "INSERT INTO blog (user_id , blog_title , post_per_page , blog_background_image) 
              VALUES ('$user_id' ,'$title', '$post_per_page', '$image_name')";
              
$result = mysqli_query($connect, $query);

if ($result) {
    header("location:page.php?msg=Page Created Successfully..");
    
} else {
    echo "Error ";
}



}


?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
          <h1>Create Page</h1>
          <hr>

        <div class="card my-5">
    <div class="card-header bg-dark text-white">
      <h2>Create New Page (Admin)</h2>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">

        <div class="mb-3">
          <label name="title" class="form-label">Blog Title</label>
          <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
          <label name="post_per_page" class="form-label"> Post per Page</label>
          <input type="text" class="form-control" id="post_per_page" name="post_per_page" required>
        </div>

        <div class="mb-3">
          <label name="image" class="form-label">Background Image(Max size allowed 1Mb)</label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>

        <div class="d-grid">
          <button type="submit" name="create_blog" class="btn btn-primary">Create Blog/Page </button>
        </div>
      </form>
    </div>
  </div>



        <!-- End comment Div -->
          


        </div>
        
        


        <?php
include('require/sidebar.php');
?>

</div>
</div>


<?php
include('require/footer.php');
?>
