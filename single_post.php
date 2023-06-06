<?php
include('require/header.php');
include('database/connection.php');
?>

<div class="container">
    <div class="row">
        <?php
        $post_id = $_GET['post_id'];

        $query = "SELECT * FROM post WHERE post_id = $post_id";
        $result = mysqli_query($connect, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $post_id = $row['post_id'];
        ?>
            <div class="col-md-9">
                <h1><?php echo $row['post_title'] ?></h1>
                <hr>

                <div class="card mb-3">
                    <img src="images/post/<?php echo $row['featured_image'] ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Summary: <?php echo $row['post_summary'] ?></h5>
                        <p class="card-text"><?php echo $row['post_description'] ?></p>

                        <h4>File Attachments</h4>
                        <?php
                        $query = "SELECT * FROM post_attachment WHERE post_id = $post_id AND is_active = 'Active'";
                        $execute = mysqli_query($connect, $query);
                        while ($attachment = mysqli_fetch_assoc($execute)) {
                        ?>
                            <a href="<?php echo $attachment['post_attachment_path']; ?>" class="btn btn-link"><?php echo $attachment['post_attachment_title']; ?></a>
                        <?php } ?>
                    </div>
                </div>

                <?php if (isset($_SESSION['user_id']) && $row['is_comment_allowed'] == 1) { ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <form method="post" class="row">
                                <div class="col-md-9">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="text_comment" style="height: 100px"></textarea>
                                        <label for="floatingTextarea2">Comments</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" name="post_comment<?php echo $post_id; ?>" class="btn btn-primary text-white float-end">Post Comment</button>
                                    <button type="button" class="btn btn-primary text-white float-end" onclick="showComments(<?php echo $post_id; ?>)">Show Comments</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
                <div class="card mb-3" id="commentContainer<?php echo $post_id; ?>" style="display: none;">
                    <div class="card-body">
                        <?php
                        if (isset($_POST["post_comment$post_id"]) && $_POST["text_comment"] != "") {

                            $text_comment = $_POST['text_comment'];
                            $query = "INSERT INTO post_comment (post_id , user_id , comment) 
                                      VALUES ('$post_id' , '" . $_SESSION['user_id'] . "' , '$text_comment')";
                            $result1 = mysqli_query($connect, $query);

                            if ($result1) {
                                //echo "Commented Successfully..";
                            } else {
                                echo "Error";
                            }
                        }

                        $query = "SELECT c.comment,c.created_at, u.first_name, u.last_name,u.user_image
                                  FROM post_comment AS c
                                  JOIN user AS u ON c.user_id = u.user_id
                                  WHERE c.post_id = $post_id  AND c.is_active = 'Active'
                                  ORDER BY c.post_comment_id DESC";

                        $result2 = mysqli_query($connect, $query);

                        while ($row = mysqli_fetch_assoc($result2)) {
                        ?>
                            <div class="mb-3">
                                <img src="images/dp/<?php echo $row['user_image'] ?>" class="rounded-circle me-3" alt="Profile Image" style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="media-body">
                                    <h5 class="mt-0"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h5>
                                    <p><?php echo $row['comment']; ?></p>
                                    <p class="mb-0">Time: <?php echo $row['created_at']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php } ?>

        <?php include('require/sidebar.php'); ?>
    </div>
</div>

<?php include('require/footer.php'); ?>

<script>
    function showComments(postId) {
        var commentContainer = document.getElementById("commentContainer" + postId);
        if (commentContainer.style.display === "none") {
            commentContainer.style.display = "block";
        } else {
            commentContainer.style.display = "none";
        }
    }
</script>
