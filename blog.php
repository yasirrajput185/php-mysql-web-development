<?php
include('require/header.php');
if(isset($_GET['blog_id'])){
  $blog_id=$_GET['blog_id'];
  $blog_title=$_GET['blog_title'];
  isset($_GET['user_id'])?$user_id=$_GET['user_id']:"";
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
          <h1 align="center"> <b><?php echo $blog_title ?></b></h1>
          <hr>
<?php
include('database/connection.php');
//print_r($_SESSION);
$query= "SELECT * FROM blog WHERE blog_id=$blog_id";
$result=mysqli_query($connect , $query);
$row=mysqli_fetch_assoc($result);
$post_per_page=$row['post_per_page'];
isset($row['user_id'])?$blog_admin_id=$row['user_id']:"";
if(isset($_SESSION['role_id']) && $_SESSION['role_id']==2 && $_SESSION['user_id']==$blog_admin_id){  

  if(isset($_POST['post'])){

    extract($_POST);

    $image_tmp = $_FILES['featured_image']['tmp_name'];
    $image_name = $_FILES['featured_image']['name'];
    $target_dir = "images/post/";
    $target_file = $target_dir.$image_name;
    if(move_uploaded_file($image_tmp, $target_file)){

    }else header('location:home.php');


    $query = "INSERT INTO post (blog_id, post_title , post_summary , post_description , featured_image) 
              VALUES ('$blog_id','$post_title' , '$post_summary' , '$post_description' , '$image_name')";
              
$result = mysqli_query($connect, $query);

if ($result) {
  $query = "SELECT MAX(post_id) AS last_post_id FROM post";
  $result = mysqli_query($connect, $query);
  $row = mysqli_fetch_assoc($result);
  $last_id=$row['last_post_id'];

  $categories = $_POST['category_id'];


  foreach ($categories as $value) {
    $query = "INSERT INTO post_category (post_id, category_id) VALUES ($last_id, $value)";
    $return = mysqli_query($connect, $query);
  }

  foreach ($_FILES['post_attachment']['name'] as $key => $value) {
    $originalname = $_FILES['post_attachment']['name'][$key];
    $filename = rand() . "_" . $_FILES['post_attachment']['name'][$key];
    $temp_name = $_FILES['post_attachment']['tmp_name'][$key];
    $target_dir = "images/post/attachment";
    $file_path = $target_dir . "/" . $filename; 
  
    if (move_uploaded_file($temp_name, $file_path)) {
      $query = "INSERT INTO post_attachment (post_id, post_attachment_title, post_attachment_path) VALUES ($last_id, '".$originalname."', '".$file_path."')";
      $return = mysqli_query($connect, $query);
      if ($return) {
    //    echo "success";
      }
    }else header('location:home.php');
  }
  



    echo "Post Created Successfully..";
    
} else {
    echo "Error ";
}

  }

?>
<a href="blog.php?msg=add_post&blog_id=<?php echo $_GET['blog_id']?>&blog_title=<?php echo $_GET['blog_title']?>&user_id=<?php echo $_GET['user_id']?>"><button class="btn btn-primary">Add Post</button></a>

<?php
if(isset($_GET['msg']) && $_GET['msg']=='add_post'){
?>

<a href="blog.php?msg=cancel_post&blog_id=<?php echo $_GET['blog_id']?>&blog_title=<?php echo $_GET['blog_title']?>&user_id=<?php echo $_GET['user_id']?>"><button class="btn btn-primary">Cancel</button></a>

<div class="card my-5">
  <div class="card-header bg-dark text-white">
    <h2>Add Post (Admin)</h2>
  </div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label name="post_title" class="form-label">Post Title</label>
        <input type="text" class="form-control" id="post_title" name="post_title" required>
      </div>
      <div class="mb-3">
        <label name="post_summary" class="form-label">Post Summary</label>
        <input type="text" class="form-control" id="post_summary" name="post_summary" required>
      </div>
      <div class="mb-3">
        <label name="post_description" class="form-label">Post Description</label>
        <textarea name="post_description" id="post_description" cols="80" rows="10"></textarea>
      </div>
      <div class="mb-3">
        <label name="category_id" class="form-label">Category</label>
        <select class="form-control" id="category_id" name="category_id[]" multiple required>
      <?php

          $query = "SELECT * FROM category";
          $result = mysqli_query($connect, $query);

          while ($row = mysqli_fetch_assoc($result)) {
              echo '<option value="' . $row['category_id'] . '">' . $row['category_title'] . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label name="featured_image" class="form-label">Featured Image (Max size allowed 1Mb)</label>
        <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*" required>
      </div>
      <div class="mb-3">
        <label name="post_attachment" class="form-label">Files Attachments</label>
        <input type="file" class="form-control" id="post_attachment" name="post_attachment[]" multiple>
      </div>
      <div class="d-grid">
        <button type="submit" name="post" class="btn btn-primary">Post</button>
      </div>
    </form>
  </div>
</div>

<?php
}}else if(isset($_SESSION['user_id'])) {          //<!---- Follow Button ---->

  $query = "SELECT * FROM following_blog WHERE blog_following_id=$blog_id AND follower_id=".$_SESSION['user_id'];
  //$query="SELECT * FROM following_blog WHERE blog_following_id=$blog_id AND follower_id=".$_SESSION['user_id']."";
  $result=mysqli_query($connect, $query);
  
  if($row=mysqli_fetch_assoc($result)){
   // print_r($row); 
    if($row['status']=='Unfollowed'){
    ?>
    <div class="col-md-3 float-end">
      <a href="all_admin_features.php?msg=follow&blog_title=<?php echo $blog_title?>&user_id=<?php echo $row['follower_id']?>&blog_following_id=<?php echo $blog_id?>">
      <button class="btn btn-primary text-white float-end">Follow</button></a>
    </div>
    <?php
  }else{
    ?>
    <div class="col-md-3 float-end">
      <a href="all_admin_features.php?msg=unfollow&blog_title=<?php echo $blog_title?>&user_id=<?php echo $row['follower_id']?>&blog_following_id=<?php echo $row['blog_following_id']?>">
      <button class="btn btn-primary text-white float-end">Unfollow</button></a>
    </div>
<!----End Follow Button ---->

    <?php
  }}else{
    ?>
    <a href="all_admin_features.php?msg=follow&blog_title=<?php echo $blog_title?>&user_id=<?php echo $_SESSION['user_id']?>&blog_following_id=<?php echo $blog_id?>">
      <button class="btn btn-primary text-white float-end">Follow</button></a>
    <?php
  } 
}
 ?>

<?php

$query = "SELECT COUNT(post_id) AS total_post FROM post WHERE blog_id = '".$blog_id."' AND post_status='Active'";

                $result = mysqli_query($connect, $query);
                $row = mysqli_fetch_assoc($result);

                $total_post = $row['total_post'];
                $total_page = ceil($total_post/$post_per_page);
//blog_id=3&blog_title=shakir &user_id=2
                echo "<h3 align=center> Page : ";
                for($i=1; $i<=$total_page; $i++){
                    ?>

                    <a href="blog.php?start=<?php echo $post_per_page*($i-1);?>&blog_id=<?php echo $_GET['blog_id']?>&blog_title=<?php echo $_GET['blog_title']?>&user_id=<?php echo $user_id?>">
                      <?php echo $i?></a>
                    
                    <?php
                }echo "</h3>";

                isset($_GET['start']) ? $start = $_GET['start'] : $start=0 ;




$query = "SELECT p.*, b.blog_title, b.blog_background_image, u.user_image
FROM post p
JOIN blog b ON p.blog_id = b.blog_id
JOIN user u ON b.user_id = u.user_id
WHERE p.post_status='Active' AND b.blog_id = $blog_id
ORDER BY p.created_at DESC LIMIT $start, $post_per_page;";

$result = mysqli_query($connect, $query);
$count = 1;

while($row = mysqli_fetch_assoc($result)){
  extract($row);
  // $post_id = $row['post_id'];
  // $blog_title = $row['blog_title'];
  // $post_title = $row['post_title'];
  // $post_summary = $row['post_summary'];
  // $post_description = $row['post_description'];
  // $featured_image = $row['featured_image'];
  // $is_comment_allowed = $row['is_comment_allowed'];
  // $created_at = $row['created_at'];
  // $blog_background_image = $row['blog_background_image'];
?>

<div class="card mb-3">
  <div class="card-header">
    <div class="d-flex align-items-center">
      <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px;">
        <img src="images/dp/<?php echo $blog_background_image; ?>" alt="Blog Background Image" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
      <div class="ms-3">
        <h5 class="mb-0"><?php echo $blog_title; ?></h5>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="d-flex align-items-center">
      <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px;">
        <img src="images/dp/<?php echo $row['user_image']; ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
      <div class="ms-3">
        <h5 class="mb-0"><?php echo $post_title; ?></h5>
        <p class="mb-0"><?php echo $post_summary; ?></p>
      </div>
    </div>
    <?php if (isset($featured_image)) { ?>
      <img src="images/post/<?php echo $featured_image; ?>" class="card-img-top" alt="Featured Image">
    <?php } ?>
    <p class="card-text"><?php echo $post_description; ?></p>
    

    <?php 

    $query="SELECT * FROM post_attachment WHERE $post_id=post_id AND is_active='Active'";
    $execute=mysqli_query($connect , $query);
    while ($attachment=mysqli_fetch_assoc($execute)) {
     ?>
      <a href="<?php echo $attachment['post_attachment_path']; ?>" class="btn btn-link"><?php echo $attachment['post_attachment_title']; ?></a>
    <?php } ?>
    
<div class="col text-end">
        <p class="text-muted">Posted on <?php echo $created_at; ?></p>
      </div>
    <hr>
    
    <?php
    if(isset($_SESSION['user_id'])&& $row['is_comment_allowed']==1){
    ?>

    <div class="row">
      <form method="post">
        <div class="form-floating col-md-9">
          <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="text_comment" style="height: 100px"></textarea>
          <label for="floatingTextarea2">Comments</label>
        </div>
        <div class="col">
          <button type="submit" name="post_comment<?php echo $post_id;?>" class="btn btn-primary text-white float-end">Post Comment</button>
        </div>
      </form>
    </div>

    <?php } ?>

  </div>
  <hr>

  <?php

  if(isset($_POST["post_comment$post_id"]) && $_POST["text_comment"]!=""){

    $text_comment=$_POST['text_comment'];
    $query = "INSERT INTO post_comment (post_id , user_id , comment) 
              VALUES ('$post_id' , '".$_SESSION['user_id']."' , '$text_comment')";
    $result1 = mysqli_query($connect, $query);

    if ($result1) {
     // echo "Commented Successfully..";

      // unset($_POST['post_comment']);
    } else {
      echo "Error ";
    }
  }

  $query = "SELECT c.comment,c.created_at, u.first_name, u.last_name,u.user_image
  FROM post_comment AS c
  JOIN user AS u ON c.user_id = u.user_id
  WHERE c.post_id = $post_id  AND c.is_active = 'Active'
  ORDER BY c.post_comment_id DESC";

  $result2 = mysqli_query($connect, $query);

  while($row = mysqli_fetch_assoc($result2)){
  ?>

    <!--show comment Div -->
    <div class="d-flex">
      <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px;">
        <img src="images/dp/<?php echo $row['user_image'] ?>" alt="Profile Image" style="width: 100%; height: 100%; object-fit: cover;"> 
      </div>
      <h4><b>&nbsp;
        <?php 
        echo $row['first_name']." ".$row['last_name'];
        ?>
      </b></h4>
    </div>
    <div class="card-header rounded bg-dark text-white m-2 p-1">
      <p><?php echo $row['comment']; ?></p>
    </div>
    <p> Time : <?php echo $row['created_at']; ?></p>
    <hr>
  


<?php } echo "</div>"; } ?>




  </div>
<?php
include('require/sidebar.php');
?>
</div>
</div>


</div>

<?php
include('require/footer.php');
?>

