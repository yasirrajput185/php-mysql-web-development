<?php
include('require/header.php');
include('database/connection.php');

if(isset($_SESSION['role_id']) && $_SESSION['role_id']==2 ){

?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <h2>Manage feedback</h2>
            
            <hr>

    <?php 
      include('require/table/table_data.php')
    ?>

<h1 align="center">All Feedbacks</h1>

    <table class="table table-dark table-hover display" id="example" style="width:100%">
      <thead>
  <tr>
    <th>S.no</th>
    <th>Username</th>
    <th>Email</th>
    <th>feedback Message</th>
    <th>Reply By Gmail</th>
  </tr>
  </thead>
  <tbody>
  <?php

    $query = "SELECT * FROM user_feedback";
    $result = mysqli_query($connect, $query);
    $count=1;
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $count++?></td>
            <td><?php echo $row['user_name']?></td>
            <td><?php echo $row['user_email']; ?></td>
            <td><?php echo $row['feedback'];?></td>
            <td><a href="https://mail.google.com/"><button class="btn btn-primary">Reply</button></a></td>
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