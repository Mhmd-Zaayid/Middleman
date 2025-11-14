<?php
// Single admin mode: disable further registrations
include '../components/connect.php';

// If any admin exists, redirect immediately
$countAdminsStmt = $conn->prepare("SELECT COUNT(*) FROM `admins`");
$countAdminsStmt->execute();
$adminTotal = (int)$countAdminsStmt->fetchColumn();
if($adminTotal > 0){
   header('Location: dashboard.php');
   exit;
}

// Allow creation ONLY if zero admins exist (initial setup)
if(isset($_POST['submit'])){
   $id = create_unique_id();
   $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
   $pass_raw = $_POST['pass'];
   $c_pass_raw = $_POST['c_pass'];
   if($pass_raw !== $c_pass_raw){
      $warning_msg[] = 'Password not matched!';
   }else{
      $pass = htmlspecialchars(sha1($pass_raw), ENT_QUOTES, 'UTF-8');
      $insert_admin = $conn->prepare("INSERT INTO `admins`(id, name, password) VALUES(?,?,?)");
      $insert_admin->execute([$id, $name, $pass]);
      $success_msg[] = 'Admin created. Redirecting...';
      header('Refresh:2; URL=dashboard.php');
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
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<!-- register section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Initial Admin Setup</h3>
      <p style="font-size:1.3rem; color:#555; margin-bottom:1rem;">Create the primary admin account. This action is available only once.</p>
      <input type="text" name="name" placeholder="choose username" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" placeholder="choose password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="c_pass" placeholder="confirm password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Create Admin" name="submit" class="btn">
   </form>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<-- custom js file link  -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>