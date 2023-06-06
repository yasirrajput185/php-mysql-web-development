<?php
include('require/header.php');
include('database/connection.php');

if(isset($_SESSION['role_id']) && $_SESSION['role_id']==2 ){

?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <h2>Manage Category</h2>
            
            <hr>

    <?php 
      include('require/table/table_data.php')
    ?>

<h1 align="center">All Categories</h1>

    <table class="table table-dark table-hover display" id="example" style="width:100%">
      <thead>
  <tr>
    <th>Category ID</th>
    <th>Category Title</th>
    <th>Category Description</th>
    <th>Category Status</th>
  </tr>
  </thead>
  <tbody>
  <?php

    $query = "SELECT * FROM category";
    $result = mysqli_query($connect, $query);
    $count=0;
    while ($row = mysqli_fetch_assoc($result)) {
      $count++;
        ?>
        <tr>
            <td><?php echo $row['category_id']?></td>
            <td><?php echo $row['category_title']?></td>
            <td><?php echo $row['category_description']; ?></td>
            <td>
              <?php 
                if($row['category_status']=='Active'){
                  ?>
                  <!-- <button class="btn btn-primary" disabled>Active</button></a> -->
                  <a href="all_admin_features.php?msg=category_inactive&category_id=<?php echo $row['category_id']?>"><button class="btn btn-danger">Inactive</button></a>
                  <?php
                } 
                
                if($row['category_status']=='InActive'){
                  ?>
                  <a href="all_admin_features.php?msg=category_active&category_id=<?php echo $row['category_id']?>"><button class="btn btn-primary">Active</button></a>
                  <!-- <button class="btn btn-danger" disabled>Inactive</button></a> -->
                  <?php
                }
              ?>
            </td>
        </tr>
        <?php
    }
    ?>

   

</tbody>  
<tr>
    <td>Create New</td>
    <form action="all_admin_features.php" method="post">
      <td><input type="text" name="category_title" placeholder="eg. Sports" required></td>
      <td><input type="text" name="category_description" placeholder="eg. World Cup" required></td>
      <td><button type="submit" name="add_category" class="btn btn-primary">Add</button></td>
    </form>
  </tr> 
</table>

</div>
<?php   
include('require/sidebar.php');
?>
</div></div>

<?php   
include('require/footer.php');

}else{
  header('location:home.php');
}




?>