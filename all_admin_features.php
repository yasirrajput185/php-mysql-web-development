<!-- all_admin_features -->
<?php
include('database/connection.php');
$action="";
if(isset($_GET['msg']))$action=$_GET['msg'];

if(isset($_GET['post_id'])){
    $post_id=$_GET['post_id'];
}
//echo $action;

if($action=='comment_on'){

$query = "UPDATE post SET is_comment_allowed = 1 WHERE post_id = $post_id";
$result = mysqli_query($connect, $query);

if ($result) {
    header('location:manage_post.php?msg=comment_on_successfully');
} else {
    header('location:manage_post.php?msg=try_again');
}

}

if($action=='comment_off'){

    $query = "UPDATE post SET is_comment_allowed = 0 WHERE post_id = $post_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {
            header('location:manage_post.php?msg=comment_off_successfully');
        } else {
            header('location:manage_post.php?msg=try_again');
        }
    
}

if($action=='post_active'){

    $query = "UPDATE post SET post_status = 'active' WHERE post_id = $post_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {
            header('location:manage_post.php?msg=post_active_successfully');
        } else {
            header('location:manage_post.php?msg=try_again');
        }
    
}


if($action=='post_inactive'){

    $query = "UPDATE post SET post_status = 'InActive' WHERE post_id = $post_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {
            header('location:manage_post.php?msg=post_inactive_successfully');
        } else {
            header('location:manage_post.php?msg=try_again');
        }
    
}



if($action=='change_category'){

    $category_id=$_GET['category_id'];
    $post_id=$_GET['post_id'];

    $query = "UPDATE post_category SET category_id = $category_id WHERE post_id = $post_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {
            header('location:manage_post.php?msg=category_changed_successfully');
        } else {
            header('location:manage_post.php?msg=try_again');
        }
    
}
    





// <<======= Manage User ============>>

//Change Password Page

if(isset($_POST['change_password_email'])){
    $email=$_POST['change_password_email'];
    $_SESSION['change_pass_email']=$email;
}

if(isset($_POST['send_email'])){
    echo "mail sent";
    $query = "SELECT * FROM `user` WHERE email = '$email';";
    $result= mysqli_query($connect,$query);
    if($row = mysqli_fetch_assoc($result)){
echo "matched email";
    //Sending Email
        $_SESSION['pin']=rand(100000,999999);
        $pin=$_SESSION['pin'];
        
        $subject="Change Password";
        $message="To Change Your Password Enter PIN :  $pin ";
        $send_from='onlinebloggingapplication@gmail.com';
        $send_to=$_SESSION['change_pass_email'];
        include('php_mailer/email_proc.php');
    //email done
        $user_id=$row['user_id'];
        header("location:forgot_password.php?mail_sent=1&user_id=$user_id");
    }else{
        header("location:forgot_password.php?msg=Email Address Not Registered");
    }

}

if(isset($_POST['send_code'])){
   // die;
    $pin=$_POST['pin_code'];
    $user_id=$_GET['user_id'];

    if($pin==$_SESSION['pin']){
    include("require/header.php");

    ?>
    <link rel="stylesheet" href="require/bootstrap/css/bootstrap.min.css">
    <div class="row justify-content-center">
  
    <div class="col-md-6 col-lg-5">
  
      <div class="card my-5">
        <div class="card-body p-4 bg-dark text-white">
      <h3 class="card-title mb-4 text-center text-white">Change Password</h3>

    <form method="post" action="all_admin_features.php?user_id=<?php echo $user_id ?>"> 
            <div class="mb-3">
            <label class="form-label text-white">Enter New Password</label>
              <input type="text" class="form-control" id="exampleInputEmail1" name="new_password" aria-describedby="emailHelp" required>
              <div id="emailHelp" class="form-text text-white">Check your email and enter code.</div>
            </div>
            <div class="d-grid">
              <button type="submit" name='change_password' class="btn btn-primary text-white">Change Password</button>
            </div>
            </div>
    </form>
</div></div></div></div>

    <?php 

    }else {
    header("location:forgot_password.php?user_id=$user_id&msg=Pin Not Matched. Check Your Email and Try Again&mail_sent=");    
}


}

    if(isset($_POST['change_password'])){
        echo "change";
        print_r($_SESSION);
        $user_id=$_GET['user_id'];
        $new_password=$_POST['new_password'];

        //echo $user_id." ".$new_password;
        $query = "UPDATE user SET password = '$new_password' WHERE user_id = $user_id";
        $result = mysqli_query($connect, $query);

            //Sending Email
        $subject="Your Password Has Been Changed";
        $message="If you did not do this activity kindly check your account";
        $send_from='onlinebloggingapplication@gmail.com';
        $send_to=$_SESSION['change_pass_email'];
        include('php_mailer/email_proc.php');
            //email done
        session_destroy();
        header('location:login.php?msg=Password Changed');        
    }



//Change Password END





if(isset($_GET['user_id']))$user_id=$_GET['user_id'];

if($action=='user_approved'){

    $query = "UPDATE user SET is_approved = 'Approved' WHERE user_id = $user_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {
            //Sending Email
                
                $subject="Your Account has been Approved";
                $message="Dear user, Your Account has been Approved. Now you can use online blogging Application.";
                $send_from=$_SESSION['email'];
                $send_to=$_GET['user_email'];
                include('php_mailer/email_proc.php');

            //email done

            header('location:manage_user.php?msg=user_approved_successfully');
        } else {
            header('location:manage_user.php?msg=try_again');
        }
    
}


if($action=='user_rejected'){
    $query = "UPDATE user SET is_approved = 'Rejected' WHERE user_id = $user_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {

            //Sending Email
                
                $subject="Your Account Request has been Rejected";
                $message="Sorry..!! Your Account Request has been Rejected.";
                $send_from=$_SESSION['email'];
                $send_to=$_GET['user_email'];
                include('php_mailer/email_proc.php');

            //email done

            header('location:manage_user.php?msg=user_approved_successfully');
        } else {
            header('location:manage_user.php?msg=try_again');
        }
}


if($action=='user_active'){
    $query = "UPDATE user SET is_active = 'Active' WHERE user_id = $user_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {

            //Sending Email
                
                $subject="Now your Account is Active";
                $message="Now You can login to online blogging Application";
                $send_from=$_SESSION['email'];
                $send_to=$_GET['user_email'];
                include('php_mailer/email_proc.php');

            //email done



            header('location:manage_user.php?msg=user_active_successfully');
        } else {
            header('location:manage_user.php?msg=try_again');
        }
}


if($action=='user_inactive'){
    $query = "UPDATE user SET is_active = 'InActive' WHERE user_id = $user_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {

            //Sending Email
                
                $subject="Your Account Has been Deactivated";
                $message="You can not use online blogging Application";
                $send_from=$_SESSION['email'];
                $send_to=$_GET['user_email'];
                include('php_mailer/email_proc.php');

            //email done



            header('location:manage_user.php?msg=user_inactive_successfully');
        } else {
            header('location:manage_user.php?msg=try_again');
        }
}


//Make Admin

if($action=='role_user'){
    $query = "UPDATE user SET role_id = 1 WHERE user_id = $user_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {

            //Sending Email
                
                $subject="Your Account Role Has been Changed to User";
                $message="Now you Have 'USER' Role in online blogging Application";
                $send_from=$_SESSION['email'];
                $send_to=$_GET['user_email'];
                include('php_mailer/email_proc.php');

            //email done

            header('location:manage_user.php?msg=Role Changed');
        } else {
            header('location:manage_user.php?msg=try_again');
        }
}


if($action=='role_admin'){
    $query = "UPDATE user SET role_id = 2 WHERE user_id = $user_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {

            //Sending Email
                
                $subject="Your Account Role Has been Changed to Admin";
                $message="Now you Have 'ADMIN' Role in online blogging Application";
                $send_from=$_SESSION['email'];
                $send_to=$_GET['user_email'];
                include('php_mailer/email_proc.php');

            //email done





            header('location:manage_user.php?msg=Role Changed');
        } else {
            header('location:manage_user.php?msg=try_again');
        }
}


// <<<<<<<============ Comment Manage =============>>>>>

if(isset($_GET['post_comment_id']))$comment_id=$_GET['post_comment_id'];

if($action=='comment_active'){
    $query = "UPDATE post_comment SET is_active = 'Active' WHERE post_comment_id = $comment_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {
            header('location:manage_comments.php?msg=comment_active_successfully');
        } else {
            header('location:manage_comments.php?msg=try_again');
        }
}


if($action=='comment_inactive'){
    $query = "UPDATE post_comment SET is_active = 'InActive' WHERE post_comment_id = $comment_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {
            header('location:manage_comments.php?msg=comment_inactive_successfully');
        } else {
            header('location:manage_comments.php?msg=try_again');
        }
}


// <<<<======= Manage Category ==========>>>>

if(isset($_GET['category_id']))$category_id=$_GET['category_id'];

if($action=='category_active'){
    $query = "UPDATE category SET category_status = 'Active' WHERE category_id = $category_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {
            header('location:manage_category.php?msg=category_active_successfully');
        } else {
            header('location:manage_category.php?msg=try_again');
        }
}


if($action=='category_inactive'){
    $query = "UPDATE category SET category_status = 'InActive' WHERE category_id = $category_id";
    $result = mysqli_query($connect, $query);
    
        if ($result) {
            header('location:manage_category.php?msg=category_inactive_successfully');
        } else {
            header('location:manage_category.php?msg=try_again');
        }
}


// add new category

if(isset($_POST['add_category']) && $_POST['category_title']!=""){

    $category_title=$_POST['category_title'];
    $category_description=$_POST['category_description'];

    $query = "INSERT INTO category (category_title, category_description) 
    VALUES ('$category_title', '$category_description')";
    
$result = mysqli_query($connect, $query);
if ($result) {
    header('location:manage_category.php?msg=category_added_successfully');
} else {
    header('location:manage_category.php?msg=try_again');
}

}


 // $query = "UPDATE category SET category_status = 'InActive' WHERE category_id = $category_id";
 //    $result = mysqli_query($connect, $query);
   
// <<<<======= Follow Blog ==========>>>>


if($action=='follow'){
    echo $blog_following_id=$_GET['blog_following_id'];
    echo $user_id=$_SESSION['user_id'];
    $blog_title=$_GET['blog_title'];

    $query = "UPDATE following_blog SET status='Followed' WHERE follower_id=$user_id AND blog_following_id=$blog_following_id ";
    $result = mysqli_query($connect, $query);
        if (mysqli_affected_rows($connect) > 0) {
            header("location:blog.php?blog_id=$blog_following_id&blog_title=$blog_title");
          } else{
            $query = "INSERT INTO following_blog (follower_id , blog_following_id , status)
            VALUES ($user_id , $blog_following_id , 'followed')";
            $result = mysqli_query($connect, $query);
            
                if ($result) {
                    header("location:blog.php?blog_id=$blog_following_id&blog_title=$blog_title&start=0");
                } else {
                    header("location:blog.php?blog_id=$blog_following_id&blog_title=$blog_title&start=0");
                }
        }
}

if($action=='unfollow'){
    $blog_following_id=$_GET['blog_following_id'];
    $user_id=$_SESSION['user_id'];
    $blog_title=$_GET['blog_title'];

    $query = "UPDATE following_blog SET status='unfollowed' WHERE follower_id=$user_id AND blog_following_id=$blog_following_id ";
    $result = mysqli_query($connect, $query);
        if ($result) {
            header("location:blog.php?blog_id=$blog_following_id&blog_title=$blog_title&start=0");
        } else {
            header("location:blog.php?blog_id=$blog_following_id&blog_title=$blog_title&start=0");
        }
}




// <<<<======= POST ATTACHMENT ==========>>>>

if($action=='remove_post_attachment'){

extract($_GET);
print_r($_GET);
$query = "UPDATE post_attachment SET is_active='InActive' WHERE post_id=$post_id AND post_attachment_id=$post_attachment_id ";
    $result = mysqli_query($connect, $query);
        if ($result) {

            header("location:edit_post.php?post_id=$post_id");
        } else {
            header("location:edit_post.php?post_id=$post_id");
        }



}



//inactive and active attachment


if($action=='attachment_active'){
    extract($_GET);
    $query = "UPDATE post_attachment SET is_active='Active' WHERE post_attachment_id=$post_attachment_id ";
    $result = mysqli_query($connect, $query);
        if (mysqli_affected_rows($connect) > 0) {
            header("location:manage_post_attachments.php?msg=Active Successfully");
        } else {
            header("location:manage_post_attachments.php?msg=Something Went Wrong");
        }
}


if($action=='attachment_inactive'){
    extract($_GET);
    $query = "UPDATE post_attachment SET is_active='InActive' WHERE post_attachment_id=$post_attachment_id ";
    $result = mysqli_query($connect, $query);
        if (mysqli_affected_rows($connect) > 0) {
            header("location:manage_post_attachments.php?msg=InsActive Successfully");
        } else {
            header("location:manage_post_attachments.php?msg=Something Went Wrong");
        }
}















?>