<?php
include('require/header.php');
?>

<div class="container">
  <h1>Pages</h1>
  <hr>
  <div class="row">

    <div class="col-md-9">
    <div class="row row-cols-1 row-cols-md-3 g-4 p-5">
<?php 
if(isset($_SESSION['user_id']) && $_SESSION['role_id']==2){
  $user_id=$_SESSION['user_id'];
  
?>
        <div class=" d-grid bg-dark text-white p-2 text-center" style="width: 100%">
        <h3>Your Pages</h3>
        </div>
  
        <?php
        $query = "SELECT * FROM blog WHERE user_id=$user_id";

        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($result);

        while ($row = mysqli_fetch_assoc($result)) {

        ?>
          <a style="text-decoration: none;" href="blog.php?blog_id=<?php echo $row['blog_id']; ?>&blog_title=<?php echo $row['blog_title']; ?> &user_id=<?php echo $row['user_id']; ?>">
            <div class="col" style="position: relative; overflow: hidden; width: 100%; height: 300px;">
              <div class="card">
                <img style="position: relative; overflow: hidden; width: 100%; height: 250px;" src="images/post/<?php echo $row['blog_background_image'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title fw-bold"><?php echo $row['blog_title']; //$blog_title 
                                                  ?></h5>
                  <p class="card-text"><?php //echo $row['blog_summary']; //$blog_summary 
                                        ?></p>
                </div>
              </div>
            </div>
          </a>

        <?php
        }}
        ?>


        <?php
        if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 2) {
        ?>
          <div class="col">
            <a style="text-decoration: none;" href="create_page.php">
              <div class="card" style="position: relative; overflow: hidden; width: 100%; height: 300px;">
                <img src="images/blank.png" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title fw-bold">Create New Page</h5>
                  <p class="card-text">
            </a></p>
          </div>
      </div>
    </div>
  <?php } ?>

 <div class=" d-grid bg-dark text-white p-2 text-center" style="width: 100%">
        <h3>All Pages</h3>
  </div>
  
  <?php
  if (isset($user_id))$query = "SELECT * FROM blog WHERE user_id!=$user_id";
  else $query = "SELECT * FROM blog";

    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);

    while ($row = mysqli_fetch_assoc($result)) {

  ?>
      <a style="text-decoration: none;" href="blog.php?blog_id=<?php echo $row['blog_id']; ?>&blog_title=<?php echo $row['blog_title']; ?>&user_id=<?php echo $row['user_id']; ?>">
        <div class="col">
          <div class="card" style="position: relative; overflow: hidden; width: 100%; height: 300px;">
            <img style="position: relative; overflow: hidden; width: 100%; height: 200px;" src="images/post/<?php echo $row['blog_background_image'] ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title fw-bold"><?php echo $row['blog_title']; //$blog_title 
                                              ?></h5>
              <p class="card-text"><?php //echo $row['blog_summary']; //$blog_summary 
                                    ?></p>
            </div>
          </div>
        </div>
      </a>

  <?php
    }
  
  ?>

  </div>
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