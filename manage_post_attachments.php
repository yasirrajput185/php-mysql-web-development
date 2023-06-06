<?php
include('require/header.php');
include('database/connection.php');

if(isset($_SESSION['role_id']) && $_SESSION['role_id']==2 ){

?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <h2>Manage Post Attachment</h2>
            
            <hr>

    <?php 
      include('require/table/table_data.php')
    ?>

<h1 align="center">All Attachments</h1>

    <table class="table table-dark table-hover display" id="example" style="width:100%">
      <thead>
  <tr>
    <th>S.no</th>
    <th>Attachment Title</th>
    <th>Post</th>
    <th>View</th>
    <th>Status</th>
  </tr>
  </thead>
  <tbody>
  <?php

    $query = "SELECT * FROM post_attachment";
    $result = mysqli_query($connect, $query);
    $count=0;
    while ($row = mysqli_fetch_assoc($result)) {
      $count++;
        ?>
        <tr>
            <td><?php echo $count ?></td>
            <td><?php echo $row['post_attachment_title']?></td>
            <td>
              <a href="single_post.php?post_id=<?php echo $row['post_id']?>"><button class="btn btn-primary">View</button></a>
            </td>
            <td><a href="<?php echo $row['post_attachment_path'];?>"><button class="btn btn-primary">View/Download</button></a></td>
            <td>
              <?php 
                if($row['is_active']=='Active'){
                  ?>
                  <!-- <button class="btn btn-primary" disabled>Active</button></a> -->
                  <a href="all_admin_features.php?msg=attachment_inactive&post_attachment_id=<?php echo $row['post_attachment_id'] ?>"><button class="btn btn-danger">Inactive</button></a>
                  <?php
                } 
                
                if($row['is_active']=='InActive'){
                  ?>
                  <a href="all_admin_features.php?msg=attachment_active&post_attachment_id=<?php echo $row['post_attachment_id'] ?>"><button class="btn btn-success">Active</button></a>
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