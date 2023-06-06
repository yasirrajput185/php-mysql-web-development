<?php
include('require/header.php');
include('database/connection.php');
?>

<div class=" container">
  <div class=" row">
    <div class=" col-md-9">

<?php 

if (isset($_GET['search'])) {
 $post_name=$_GET['search'];
 $query="SELECT * from post WHERE post_title='$post_name'";
 $result=mysqli_query($connect , $query);
?>

<br>
      <div class=" d-grid bg-dark text-white p-2">
        <h3>Search Result</h3>
      </div>
<br>

        <div class=" row">
        <div class=" p-3">
          <div class=" row row-cols-1 row-cols-md-4 g-3">


<?php
 while ($row=mysqli_fetch_assoc($result)) {

 ?>

 <a style="text-decoration: none" href="single_post.php?post_id=<?php echo $row['post_id'] ?>">
                <div class=" col">
                  <div class=" card" style="position: relative; overflow: hidden; width: 100%; height: 300px;">
                    <img style="position: relative; overflow: hidden; width: 100%; height: 300px;" src="images/post/<?php echo $row['featured_image'] ?>" class=" card-img-top" alt="...">
                    <div class=" card-body">
                      <h5 class=" card-title fw-bold"><?php echo $row['post_title'] ?></h5>
                      <p class=" card-text"><?php echo $row['post_summary'] ?></p>
                    </div>
                  </div>
                </div>
              </a>

    <?php } echo "</div></div></div>"; } $_GET['search']="" ?>



      <h2>Trending Post</h2>
      <hr>
      <div id="carouselExampleSlidesOnly" class=" carousel slide" data-bs-ride="carousel" style="width: 100%;">
        <div class=" carousel-inner">
          <?php
          $query = "SELECT * FROM post "; // WHERE match category
          $result = mysqli_query($connect, $query);
          $active = 1;
          //  print_r($row);
          while ($row = mysqli_fetch_assoc($result)) {
            $post_id = $row['post_id'];
          ?>

            <!-- news 1 -->
            <div class=" carousel-item <?php if ($active == 1) echo "active";
                                      $active--; ?>">
              <a href="single_post.php?post_id=<?php echo $row['post_id'] ?>" style="display: block; width: 100%; height: 100%;">
                <div class=" card h-100">
                  <div style="position: relative; overflow: hidden; width: 100%; height: 300px;"> 
                    <img src="images/post/<?php echo $row['featured_image'] ?>" class=" card-img-top h-100 w-100" alt="..." style="object-fit: cover;">
                  </div>
                  <div class=" card-body"></a>
                    <h5 class=" card-title"><?php echo $row['post_title'] ?></h5>
                    <p class=" card-text"><?php echo $row['post_summary'] ?> <a href="#">Read More..</a></p>
                    <p class=" lead"><?php echo $row['created_at'] ?></p>
                  </div>
                </div>
              </a>
            </div>

            <!--end slider News -->

          <?php } ?>
        </div>
      </div>
      <!-- slider End -->

<?php 
$query = "SELECT * FROM category WHERE category_status='Active' "; 
$result = mysqli_query($connect, $query);

while ($categories = mysqli_fetch_assoc($result)) {
$count=1;
?>

      <br>
      <div class=" d-grid bg-dark text-white p-2">
        <h3><?php echo $categories['category_title'] ?> <a href="category_posts.php?category_title=<?php echo $categories['category_title']?>&category_id=<?php echo $categories['category_id']?>"><button class=" btn btn-light float-end bg-black text-white" ><b>Show All Post</b> </button></a></h3>
      </div>
      <br>

  <div class=" row">
        <div class=" p-3">
          <div class=" row row-cols-1 row-cols-md-4 g-3">
<?php
$query = "SELECT p.*, pc.category_id 
FROM post AS p 
JOIN post_category AS pc ON p.post_id = pc.post_id 
WHERE pc.category_id = " . $categories['category_id'] . " ORDER BY p.post_id DESC";


$result2 = mysqli_query($connect, $query);

while ($row = mysqli_fetch_assoc($result2)) {

?>

              <a style="text-decoration: none" href="single_post.php?post_id=<?php echo $row['post_id'] ?>">
                <div class=" col">
                  <div class=" card" style="position: relative; overflow: hidden; width: 100%; height: 300px;">
                    <img style="position: relative; overflow: hidden; width: 100%; height: 300px;" src="images/post/<?php echo $row['featured_image'] ?>" class=" card-img-top" alt="...">
                    <div class=" card-body">
                      <h5 class=" card-title fw-bold"><?php echo $row['post_title'] ?></h5>
                      <p class=" card-text"><?php echo $row['post_summary'] ?></p>
                    </div>
                  </div>
                </div>
              </a>
  
          
      <!-- end card div layout -->
<?php if($count==4)break;$count++; } echo "</div></div></div>"; } ?>



    </div>
    <?php

    include('require/sidebar.php');
    ?>

  </div>
</div>
<?php
include('require/footer.php');
?>

</body>

</html>