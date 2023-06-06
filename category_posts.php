<?php
include('require/header.php');
include('database/connection.php');

isset($_GET['category_id'])?$category_id=$_GET['category_id']:header('location:home.php');
isset($_GET['category_title'])?$category_title=$_GET['category_title']:header('location:home.php');
?>

<div class=" container">
  <div class=" row">
    <div class=" col-md-9">
<br>
<div class=" d-grid bg-dark text-center text-white p-2">
        <h3><?php echo $category_title ?> All Posts </h3>
  </div>    
    <div class=" row">
        <div class=" p-3">
          <div class=" row row-cols-1 row-cols-md-4 g-3">  

<?php
$query = "SELECT p.*, pc.category_id 
FROM post AS p 
JOIN post_category AS pc ON p.post_id = pc.post_id 
WHERE pc.category_id = " . $category_id . " ORDER BY p.post_id DESC";


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
<?php } echo "</div></div></div>";  ?>



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