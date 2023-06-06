<?php
include('require/header.php');
 include('database/connection.php');
//print_r($_SESSION);die;
if(isset($_SESSION['user_id']) && $_SESSION['role_id']==2){
?>
<div class="container">
  <div class="row">
    <div class="col-md-9">


<?php
isset($_GET['post_id'])?$post_id=$_GET['post_id']:header('location:home.php');

  if(isset($_POST['update'])){
    extract($_POST);
    $image_tmp = $_FILES['featured_image']['tmp_name'];
    $image_name = $_FILES['featured_image']['name'];
    $target_dir = "images/post/";
    $target_file = $target_dir.$image_name;
    if(move_uploaded_file($image_tmp, $target_file)){
          $query = "UPDATE post SET post_title='$post_title' , post_summary='$post_summary' , post_description='$post_description' , featured_image='$image_name' WHERE post_id=$post_id;";
    }else{
        $query = "UPDATE post SET post_title='$post_title' , post_summary='$post_summary' , post_description='$post_description' 
        WHERE post_id=$post_id;";
    }

$result = mysqli_query($connect, $query);

if(isset($_POST['category_id'])){
  $categories = $_POST['category_id'];
  
    $query="DELETE FROM post_category WHERE post_id=$post_id";
    $delete=mysqli_query($connect , $query);
  
  foreach ($categories as $value) {
    $query = "INSERT INTO post_category (post_id, category_id) VALUES ($post_id, $value)";
    $return = mysqli_query($connect, $query);
  }}

  foreach ($_FILES['post_attachment']['name'] as $key => $value) {
    $originalname = $_FILES['post_attachment']['name'][$key];
    $filename = rand() . "_" . $_FILES['post_attachment']['name'][$key];
    $temp_name = $_FILES['post_attachment']['tmp_name'][$key];
    $target_dir = "images/post/attachment";
    $file_path = $target_dir . "/" . $filename;   
    if (move_uploaded_file($temp_name, $file_path)) {
      $query = "INSERT INTO post_attachment (post_id, post_attachment_title, post_attachment_path) VALUES ($post_id, '".$originalname."', '".$file_path."')";
      $return = mysqli_query($connect, $query);
      if ($return) {
    //    echo "success";
      }
    }//else //header('location:home.php');
  }
  
    $msg="Post Edited Successfully..";
    
    //header("location:manage_post.php?msg=$msg");
    

  }
    
    if(isset($_GET['post_id'])){
        $post_id = $_GET['post_id'];
        $query = "SELECT * FROM post WHERE post_id = $post_id";
        $result = mysqli_query($connect, $query);
        while($row = mysqli_fetch_assoc($result)){
?>

<div class="card my-5">
  <div class="card-header bg-dark text-white">
    <h2>Edit Post (Admin)</h2>
  </div>
  <div class="card-body">
    <form method="post" action="manage_post.php?msg=Edited Successfully" enctype="multipart/form-data">
      <div class="mb-3">
        <label name="post_title" class="form-label">Post Title</label>
        <input type="text" class="form-control" id="post_title" name="post_title" value="<?php echo $row['post_title'] ?>">
      </div>
      <div class="mb-3">
        <label name="post_summary" class="form-label">Post Summary</label>
        <input type="text" class="form-control" id="post_summary" name="post_summary" value="<?php echo $row['post_summary'] ?>">
      </div>
      <div class="mb-3">
        <label name="post_description" class="form-label">Post Description</label>
        <textarea name="post_description" id="post_description" cols="80" rows="10"><?php echo $row['post_description'] ?></textarea>
      </div>
      <div class="mb-3">
        <label name="category_id" class="form-label">Category (if you don't choose any it will be in old categories)</label>
        <select class="form-control" id="category_id" name="category_id[]" multiple>
      <?php

          $query = "SELECT * FROM category WHERE category_status='Active'";
          $result = mysqli_query($connect, $query);
          while ($row = mysqli_fetch_assoc($result)) {
          ?>
          <option value="<?php echo $row['category_id']?>"><?php echo $row['category_title']?></option>
        <?php } ?>
        </select>
      </div>
      <div class="mb-3">
        <label name="featured_image" class="form-label">Featured Image (Max size allowed 1Mb)</label>
        <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*" >
      </div>

            <div class="mb-3">
        <label name="show_attachment" class="form-label">Remove Attachments </label>
        <ul class="form-control" id="show_attachment" name="show_attachment[]" multiple>
      <?php
          $query = "SELECT * FROM post_attachment WHERE post_id=$post_id AND is_active='Active'";
          $result = mysqli_query($connect, $query);
          while ($row = mysqli_fetch_assoc($result)) {
          ?>
          <li><?php echo $row['post_attachment_title']?> <a href="all_admin_features.php?msg=remove_post_attachment&post_id=<?php echo $post_id ?>&post_attachment_id=<?php echo $row['post_attachment_id'] ?>">Remove</a></li>
        <?php } ?>
        </ul>
      </div>





      <div class="mb-3">
        <label name="post_attachment" class="form-label">Add Files Attachments</label>
        <input type="file" class="form-control" id="post_attachment" name="post_attachment[]" multiple>
      </div>
      <div class="d-grid">
        <button type="submit" name="update" class="btn btn-primary">Update Post</button>
      </div>
    </form>
  </div>
</div>   

<?php
}}
echo "</div>";
include('require/sidebar.php');
?>

    </div></div>

<?php
include('require/footer.php');
}else header('location:home.php');


?>