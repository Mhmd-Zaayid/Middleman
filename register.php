<?php
ob_start(); // Prevent headers already sent issue

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $id = create_unique_id();

   // Sanitize inputs (FILTER_SANITIZE_STRING is deprecated in PHP 8+)
   $name   = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
   $number = preg_replace('/[^0-9]/', '', $_POST['number']); // keep only numbers
   $email  = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

   // Hash passwords
   $pass   = sha1($_POST['pass']);
   $c_pass = sha1($_POST['c_pass']);

   // Check if email already exists
   $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_users->execute([$email]);

   if($select_users->rowCount() > 0){
      $warning_msg[] = 'Email already taken!';
   }else{
      if($pass != $c_pass){
         $warning_msg[] = 'Passwords do not match!';
      }else{
         // Insert new user
         $insert_user = $conn->prepare("INSERT INTO `users`(id, name, number, email, password) VALUES(?,?,?,?,?)");
         $insert_user->execute([$id, $name, $number, $email, $c_pass]);
         
         if($insert_user){
            // Verify user after insert
            $verify_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
            $verify_users->execute([$email, $pass]);
            $row = $verify_users->fetch(PDO::FETCH_ASSOC);
         
            if($verify_users->rowCount() > 0){
               setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
               header('Location: home.php');
               exit();
            }else{
               $error_msg[] = 'Something went wrong!';
            }
         }

      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body class="register-page">
   
<?php include 'components/user_header.php'; ?>

<!-- register section starts  -->

<section class="form-container">

   <form action="" method="post" class="register-form">
      <h3>Create an account!</h3>
      <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="box">
      <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="box">
      <input type="tel" name="number" required pattern="[0-9]{10}" maxlength="10" placeholder="Enter your number" class="box">
      <input type="password" name="pass" required maxlength="20" placeholder="Enter your password" class="box">
      <input type="password" name="c_pass" required maxlength="20" placeholder="Confirm your password" class="box">
      <p>Already have an account? <a href="login.php">Login now</a></p>
      <input type="submit" value="Register now" name="submit" class="btn">
   </form>

</section>

<!-- register section ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>
