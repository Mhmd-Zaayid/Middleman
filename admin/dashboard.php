<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body class="bg-electric-blue">
   
<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<!-- dashboard section starts  -->

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <style>
      /* Stat cards styled but sized/positioned to mimic original 35rem grid */
      .stats-grid{ display:grid; grid-template-columns: repeat(auto-fit,35rem); align-items:flex-start; justify-content:center; gap:1.5rem; }
      .stat-card{ position:relative; background:#fff; border-radius:.5rem; padding:2rem; box-shadow:var(--box-shadow); border:var(--border); text-align:center; }
      .stat-card .icon{ width:60px; height:60px; display:grid; place-items:center; border-radius:1rem; color:#fff; font-size:2.2rem; margin:0 auto 1rem; }
      .stat-card .value{ font-size:2.5rem; font-weight:600; color:var(--black); line-height:1; }
      .stat-card .label{ color:var(--light-color); font-size:1.6rem; margin:.8rem 0 1rem; text-transform:capitalize; }
      .stat-card .cta{ display:inline-block; margin-top:1rem; font-size:1.4rem; color:#2563eb; font-weight:600; }
      .stat-card .cta:hover{ text-decoration:underline; }
      .bg-blue{ background:linear-gradient(135deg,#3b82f6,#60a5fa); }
      .bg-emerald{ background:linear-gradient(135deg,#10b981,#34d399); }
      .bg-purple{ background:linear-gradient(135deg,#8b5cf6,#a78bfa); }
      .bg-rose{ background:linear-gradient(135deg,#ef4444,#f97316); }
      .stat-card .bg-fade{ display:none; }
      .stat-card:hover{ transform:translateY(-2px); box-shadow:0 1rem 2rem -4px rgba(0,0,0,.15); }
      @media (max-width:450px){ .stats-grid{ grid-template-columns:1fr; } }
   </style>

   <div class="box-container stats-grid">
      <div class="box stat-card">
         <div class="icon bg-blue"><i class="fas fa-user-shield"></i></div>
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ? LIMIT 1");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <div class="label">Welcome</div>
         <div class="value" style="font-size:1.8rem;"><?= htmlspecialchars($fetch_profile['name']); ?></div>
         <a href="update.php" class="cta">Update profile →</a>
      </div>

      <div class="box stat-card">
         <div class="icon bg-emerald"><i class="fas fa-building"></i></div>
         <?php
            $select_listings = $conn->prepare("SELECT * FROM `property`");
            $select_listings->execute();
            $count_listings = $select_listings->rowCount();
         ?>
         <div class="label">Properties Posted</div>
         <div class="value"><?= $count_listings; ?></div>
         <a href="listings.php" class="cta">View listings →</a>
      </div>

      <div class="box stat-card">
         <div class="icon bg-purple"><i class="fas fa-users"></i></div>
         <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $count_users = $select_users->rowCount();
         ?>
         <div class="label">Total Users</div>
         <div class="value"><?= $count_users; ?></div>
         <a href="users.php" class="cta">View users →</a>
      </div>

      <div class="box stat-card">
         <div class="icon bg-rose"><i class="fas fa-envelope"></i></div>
         <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            $count_messages = $select_messages->rowCount();
         ?>
         <div class="label">New Messages</div>
         <div class="value"><?= $count_messages; ?></div>
         <a href="messages.php" class="cta">View messages →</a>
      </div>
   </div>

</section>


<!-- dashboard section ends -->




















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>