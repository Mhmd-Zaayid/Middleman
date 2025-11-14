<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){
   // Accept either a user email or an admin username in unified field
   $identifier_raw = $_POST['login_id'] ?? '';
   $identifier = htmlspecialchars($identifier_raw, ENT_QUOTES, 'UTF-8');
   $pass = htmlspecialchars(sha1($_POST['pass']), ENT_QUOTES, 'UTF-8');

   if(filter_var($identifier, FILTER_VALIDATE_EMAIL)){
      // Treat as normal user email login
      $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
      $select_users->execute([$identifier, $pass]);
      $row = $select_users->fetch(PDO::FETCH_ASSOC);
      if($select_users->rowCount() > 0){
         // Clear any accidental admin cookie
         if(isset($_COOKIE['admin_id'])){
            setcookie('admin_id', '', time() - 3600, '/');
         }
         setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
         header('location:home.php');
         exit;
      }else{
         $warning_msg[] = 'Incorrect email or password!';
      }
   }else{
      // Treat as admin username login
      $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ? LIMIT 1");
      $select_admins->execute([$identifier, $pass]);
      $admin_row = $select_admins->fetch(PDO::FETCH_ASSOC);
      if($select_admins->rowCount() > 0){
         if(isset($_COOKIE['user_id'])){
            setcookie('user_id', '', time() - 3600, '/');
         }
         setcookie('admin_id', $admin_row['id'], time() + 60*60*24*30, '/');
         header('location:admin/dashboard.php');
         exit;
      }else{
         $warning_msg[] = 'Incorrect admin name or password!';
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
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>


<?php include 'components/user_header.php'; ?>

<!-- login section starts  -->
<section class="form-container">
   <style>
      .form-container {
         /* Fill entire viewport, overriding global section max-width */
         max-width: none !important;
         width: 100vw;
         margin: 0 !important;
         min-height: 100vh;
         /* Background image fit */
         background-image: url('images/loginback.png');
         background-size: cover;
         background-position: center center;
         background-repeat: no-repeat;
         background-attachment: fixed;
         /* Center form on top of background */
         display: flex;
         align-items: center;
         justify-content: center;
         padding: 2rem;
         overflow: hidden;
      }

   .form-container form {
      width: 100%;
      max-width: 500px;
      /* make room for a thin left accent stripe */
      padding: 2rem 2rem 2rem 2.5rem;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.95);
      /* subtle neutral shadow behind the form */
      box-shadow: 0 4px 18px rgba(13, 17, 23, 0.08);
   /* blue-only gradient border using border-image */
   border: 4px solid transparent;
   -webkit-border-image: linear-gradient(45deg, #1e40af, #3b82f6, #60a5fa) 1;
   border-image: linear-gradient(45deg, #1e40af, #3b82f6, #60a5fa) 1;
      transition: transform 0.18s ease, box-shadow 0.18s ease;
      position: relative;
      overflow: visible;
   }

   /* thin colored accent stripe on the left of the form */
   .form-container form::before {
      content: "";
      position: absolute;
      left: 8px;
      top: 12px;
      bottom: 12px;
      width: 6px;
      border-radius: 6px;
   /* left accent stripe changed to neutral grays */
   background: linear-gradient(180deg, #d1d5db 0%, #e5e7eb 100%);
      pointer-events: none;
      opacity: 0.98;
   }

   /* hover and focus states to give a small lift and color glow */
   .form-container form:hover,
   .form-container form:focus-within {
   transform: translateY(-6px);
   /* neutral glow on hover */
   box-shadow: 0 14px 30px rgba(17,24,39,0.06), 0 6px 18px rgba(0,0,0,0.06);
   }

   /* heading accent */
   .form-container form h3 {
      font-size: 1.45rem;
      margin: 0 0 0.6rem 0;
      color: #1f2937; /* slightly dark slate */
      letter-spacing: 0.4px;
      text-transform: capitalize;
      font-weight: 700;
   }
   .form-container form h3::after {
      content: "";
      display: block;
      width: 56px;
      height: 4px;
      margin-top: 10px;
      border-radius: 3px;
   /* heading underline uses subtle gray */
   background: linear-gradient(90deg,#9ca3af,#d1d5db);
      opacity: 0.95;
   }

   /* inputs inside the form — small, neat styling and focus glow */
   .form-container form .box {
      width: 100%;
      padding: 0.72rem 0.85rem;
      border-radius: 8px;
      border: 1px solid #e6e9ee;
      margin: 0.55rem 0 0.9rem 0;
      box-sizing: border-box;
      transition: box-shadow 0.16s ease, border-color 0.16s ease, transform 0.12s ease;
      background: #fff;
   }

   .form-container form .box:focus {
      outline: none;
   /* neutral input focus */
   border-color: #9ca3af;
   box-shadow: 0 10px 24px rgba(17,24,39,0.04), 0 0 0 4px rgba(156,163,175,0.06);
      transform: translateY(-1px);
   }

   /* subtle gradient button (keeps existing sizing from global .btn) */
   .form-container form .btn {
   /* neutral button — keep border gradient as the only blue element */
   background: linear-gradient(90deg, #f3f4f6 0%, #e5e7eb 100%);
   color: #111827;
   border: 1px solid #e6e9ee;
   padding: 0.68rem 1rem;
   border-radius: 8px;
   box-shadow: 0 6px 16px rgba(17,24,39,0.04);
      cursor: pointer;
      transition: transform 0.14s ease, box-shadow 0.14s ease, opacity 0.12s ease;
   }

   .form-container form .btn:active {
      transform: translateY(1px) scale(0.998);
      opacity: 0.98;
   }

   /* smaller devices: keep padding comfortable */
   @media (max-width: 420px) {
      .form-container form {
         padding: 1.25rem;
      }
   }

   @media (max-width: 768px) {
      .form-container {
         padding: 1rem;
      }
      .form-container form {
         width: 90%;
      }
   }
   </style>

   <form action="" method="post" style="background: rgba(255, 255, 255, 0.8);">
      <h3>welcome back!</h3>
   <input type="text" name="login_id" required maxlength="50" placeholder="enter email or admin name" class="box" autocomplete="username">
      <input type="password" name="pass" required maxlength="20" placeholder="enter your password" class="box">
      <p>don't have an account? <a href="register.php">register new</a></p>
      <input type="submit" value="login now" name="submit" class="btn">
   </form>
</section>










<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>