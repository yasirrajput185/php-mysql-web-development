<?php
include('require/header.php');
include('database/connection.php');

if(isset($_SESSION['role_id']) && $_SESSION['role_id']==2 ){


?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <h2>Your Posts</h2>
            When post is active button will show for inactive

            <hr>

            <?php 
      include('require/table/table_data.php')
    ?>

            <table class="table table-dark table-hover display" id="example" style="width:100%">
                <h1 align="center">All Posts</h1>
                <?php 
                    if (isset($_GET['msg'])) {
                        echo "<h4 align='center'>".$_GET['msg']."</h4>";
                    }
                 ?>
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Post Title</th>
                        <th>Open Post</th>
                        <th>Comments</th>
                        <th>Post Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                // Include the database connection file
                include('database/connection.php');
                
                // Fetch the posts from the database
                $query = "SELECT * FROM post";
                $result = mysqli_query($connect, $query);
                
                // Loop through the posts and display them in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['post_id']; ?></td>
                        <td><?php echo $row['post_title']; ?></td>
                        <td><a href="single_post.php?post_id=<?php echo $row['post_id']; ?>"><button
                                    class="btn btn-primary">View</button></a></td>
                        <td>

                            <?php 
                            if($row['is_comment_allowed']==0){
                          ?>
                            <a href="all_admin_features.php?msg=comment_on&post_id=<?php echo $row['post_id']?>"><button
                                    class="btn btn-success">On</button></a>

                            <?php 
                            }
                          if($row['is_comment_allowed']==1){
                          ?>

                            <a href="all_admin_features.php?msg=comment_off&post_id=<?php echo $row['post_id']?>"><button
                                    class="btn btn-danger">Off</button></a>

                            <?php 
                          }
                          ?>

                        </td>
                        <td>
                            <?php
                            //print_r($row);
                            if ($row['post_status']=='InActive') { ?>
                            <a href="all_admin_features.php?msg=post_active&post_id=<?php echo $row['post_id']?>"><button
                                    class="btn btn-success">Active</button>
                                <?php } else { ?>
                                <a href="all_admin_features.php?msg=post_inactive&post_id=<?php echo $row['post_id']?>"><button
                                        class="btn btn-danger">Inactive</button>
                                    <?php } ?>
                        </td>
                        
                        <td>
                            <a href="edit_post.php?post_id=<?php echo $row['post_id'];?>&featured_image=<?php echo $row['featured_image']?>"
                                class="btn btn-primary">Edit</a>
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
    </div>
</div>
<?php   
  include('require/footer.php');

}else{
    header('location:home.php');
}

?>