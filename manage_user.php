<?php
include('require/header.php');
include('database/connection.php');

if(isset($_SESSION['role_id']) && $_SESSION['role_id']==2 ){

?>


<div class="container">
    <div class="row">
        <div class="col-md-9">
            <h2>Manage User</h2>        
            <hr>
    
    <?php 
      include('require/table/table_data.php')
    ?>

<h1 align="center">All Users and Admins</h1>

    <table class="table table-dark table-hover display" id="example" style="width:100%">
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Status</th>
        <th>Permission</th>
        <th>Edit</th>
        <th>Roll Type</th>
    </tr>
    </thead>
    <tbody>      
    <?php
    
$user_id=$_SESSION['user_id'];
    $query = "SELECT * FROM user WHERE user_id!=$user_id ";
    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <tr>
            <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
              <?php 
                if($row['is_active']=='Active'){
                  ?>
                  <a href="all_admin_features.php?msg=user_inactive&user_id=<?php echo $row['user_id']?>&user_email=<?php echo $row['email']?>"><button class="btn btn-danger">Inactive</button></a>
                  <?php
                } 
                
                if($row['is_active']=='InActive'){
                  ?>
                  <a href="all_admin_features.php?msg=user_active&user_id=<?php echo $row['user_id']?>&user_email=<?php echo $row['email']?>"><button class="btn btn-primary">Active</button></a>
                  <!-- <button class="btn btn-danger" disabled>Inactive</button></a> -->
                  <?php
                }
            
            
              ?>
            </td>
            <td>

            <?php 
                if($row['is_approved']=='Pending'){
                          ?>
                            <a href="all_admin_features.php?msg=user_approved&user_id=<?php echo $row['user_id']?>&user_email=<?php echo $row['email']?>"><button class="btn btn-primary">Approve</button></a>
                            <a href="all_admin_features.php?msg=user_rejected&user_id=<?php echo $row['user_id']?>&user_email=<?php echo $row['email']?>"><button class="btn btn-danger">Reject</button></a>                            
                          <?php 
                            }   
                          if($row['is_approved']=='Rejected'){
                          ?>
                            <button class="btn btn-danger" disabled>Rejected</button>         
                            <?php 
                          }
                          if($row['is_approved']=='Approved'){
                            ?>
                              <button class="btn btn-success" disabled>Approved</button>         
                            <?php }  
                          ?>
  
            </td>
              
              <td>  
                <a href="edit_profile.php?user_id=<?php echo $row['user_id']?>&user_email=<?php echo $row['email']?>&user_image=<?php echo $row['user_image']?>"><button class="btn btn-primary">Edit</button></a>
              </td>

              <td>
              <?php

              if($row['role_id']==1){
              ?>  
                <!-- <button class="btn btn-primary" disabled>User</button> -->
                <a href="all_admin_features.php?msg=role_admin&user_id=<?php echo $row['user_id']?>&user_email=<?php echo $row['email']?>"><button class="btn btn-success">Admin</button></a>

              <?php
            }else if($row['role_id']==2){
              ?>  
                <a href="all_admin_features.php?msg=role_user&user_id=<?php echo $row['user_id']?>&user_email=<?php echo $row['email']?>"><button class="btn btn-primary">User</button></a>
               <!--  <button class="btn btn-success" disabled>Admin</button> -->
<?php } ?>


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