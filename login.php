<?php
// Start the session to manage user authentication
session_start();

// Include the header file
include('includes/header.php');

// Include the Facebook configuration file
require_once 'config.php';

$permissions = ['email']; // Optional permissions

// Get the Facebook login URL
$fb_login_url = $fb_helper->getLoginUrl(BASE_URL . '', $permissions);

// Check if the user is already authenticated and redirect to index page if so
if(isset($_SESSION['auth']) || isset($_SESSION['fb_user_id'])) {
    $_SESSION['status'] = "You are already logged In";
    header('Location: index.php');
    exit(0);
}

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- HTML section -->
<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 my-5">
                <div class="card my-5">
                    <div class="card-header bg-light">
                        <!-- Login Form Header -->
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                        <!-- Display authentication status message if set -->
                        <?php
                        if(isset($_SESSION['auth_status'])) {
                            ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Hey!</strong> <?php echo $_SESSION['auth_status']; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                            // Unset the authentication status message
                            unset($_SESSION['auth_status']);
                        }
                        ?>
                        
                        <!-- Include any other message file if needed -->
                        <?php
                        include('message.php');
                        ?>
                        
                        <!-- Login Form -->
                        <form action="logincode.php" method="POST">
                            <div class="form-group">
                                <label for="">Email</label>
                                <span></span>
                                <!-- Email input field -->
                                <input type="text" name="email" class="form-control" placeholder="Email" required>
                            </div>

                            <div class="form-group">
                                <label for="">Password</label>
                                <!-- Password input field -->
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>

                            <hr>

                            <div class="modal-footer">
                                <!-- Submit button for form -->
                                <button type="submit" name="login_btn" class="btn btn-primary btn-block">Login</button>
                            </div> 
                        </form>

                        <!-- Sign Up link -->
                        <div class="text-center">
                            <p>Don't have an account? <a href="signup.php" class="btn-sm">Sign Up</a></p>
                        </div>

                        <!-- Facebook Login button -->
                        <div class="form-group text-center">
                            <a href="<?php echo $fb_login_url; ?>" class="btn btn-primary"><i class="bi bi-facebook"></i> Login with Facebook</a><br>
                        </div>
                        <div class="form-group text-center">
                            <a href="google_index.php" class="btn btn-primary"><i class="bi bi-google"></i> Login with Google</a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include footer and script files -->
<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>
