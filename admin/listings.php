<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){

   $delete_id = htmlspecialchars($_POST['delete_id'], ENT_QUOTES, 'UTF-8');

   $verify_delete = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $select_images = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         $image_01 = $fetch_images['image_01'];
         $image_02 = $fetch_images['image_02'];
         $image_03 = $fetch_images['image_03'];
         $image_04 = $fetch_images['image_04'];
         $image_05 = $fetch_images['image_05'];
         unlink('../uploaded_files/'.$image_01);
         if(!empty($image_02)){
            unlink('../uploaded_files/'.$image_02);
         }
         if(!empty($image_03)){
            unlink('../uploaded_files/'.$image_03);
         }
         if(!empty($image_04)){
            unlink('../uploaded_files/'.$image_04);
         }
         if(!empty($image_05)){
            unlink('../uploaded_files/'.$image_05);
         }
      }
      $delete_listings = $conn->prepare("DELETE FROM `property` WHERE id = ?");
      $delete_listings->execute([$delete_id]);
      $success_msg[] = 'Listing deleted!';
   }else{
      $warning_msg[] = 'Listing deleted already!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Listings</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body class="bg-electric-blue">
   
<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<section class="listings">

   <h1 class="heading">all listings</h1>

   <form action="" method="POST" class="search-form">
      <div class="flex">
         <select name="city" class="input">
            <option value="">Select City</option>
            <!-- Pan-India major cities (retain existing) -->
            <option value="Kochi">Kochi</option>
            <option value="Mumbai">Mumbai</option>
            <option value="Delhi">Delhi</option>
            <option value="Bangalore">Bangalore</option>
            <option value="Chennai">Chennai</option>
            <option value="Kolkata">Kolkata</option>
            <option value="Hyderabad">Hyderabad</option>
            <option value="Pune">Pune</option>
            <option value="Ahmedabad">Ahmedabad</option>
            <option value="Thiruvananthapuram">Thiruvananthapuram</option>
            <!-- Kerala core district names -->
            <option value="Kottayam">Kottayam</option>
            <option value="Kannur">Kannur</option>
            <option value="Thrissur">Thrissur</option>
            <option value="Malappuram">Malappuram</option>
            <option value="Palakkad">Palakkad</option>
            <option value="Wayanad">Wayanad</option>
            <option value="Idukki">Idukki</option>
            <option value="Alappuzha">Alappuzha</option>
            <option value="Kollam">Kollam</option>
            <option value="Kozhikode">Kozhikode</option>
            <option value="Kasaragod">Kasaragod</option>
            <option value="Pathanamthitta">Pathanamthitta</option>
            <option value="Ernakulam">Ernakulam</option>
            <!-- Additional Kerala notable towns (10 extras requested) -->
            <option value="Guruvayur">Guruvayur</option>
            <option value="Kalpetta">Kalpetta</option>
            <option value="Munnar">Munnar</option>
            <option value="Varkala">Varkala</option>
            <option value="Changanassery">Changanassery</option>
            <option value="Nedumbassery">Nedumbassery</option>
            <option value="Kumbalangi">Kumbalangi</option>
            <option value="Perumbavoor">Perumbavoor</option>
            <option value="Angamaly">Angamaly</option>
            <option value="Mattancherry">Mattancherry</option>
         </select>
         <button type="submit" class="fas fa-search" name="search_btn" title="Filter by city"></button>
      </div>
   </form>

   <div class="box-container">

   <?php
      if(isset($_POST['search_btn'])){
         $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');

         $where_conditions = [];
         $params = [];

         if (!empty($city)) {
            // Use a tolerant match to handle trailing spaces or variations like "Kochi, Kerala"
            $where_conditions[] = "LOWER(TRIM(city)) LIKE LOWER(?)";
            $params[] = '%' . trim($city) . '%';
         }

         $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
         $select_listings = $conn->prepare("SELECT * FROM `property` {$where_clause} ORDER BY date DESC");
         $select_listings->execute($params);
      }else{
         $select_listings = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC");
         $select_listings->execute();
      }
      $total_images = 0;
       if($select_listings->rowCount() > 0){
         while($fetch_listing = $select_listings->fetch(PDO::FETCH_ASSOC)){

         $listing_id = $fetch_listing['id'];

         $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_user->execute([$fetch_listing['user_id']]);
         $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

         if(!empty($fetch_listing['image_02'])){
            $image_coutn_02 = 1;
         }else{
            $image_coutn_02 = 0;
         }
         if(!empty($fetch_listing['image_03'])){
            $image_coutn_03 = 1;
         }else{
            $image_coutn_03 = 0;
         }
         if(!empty($fetch_listing['image_04'])){
            $image_coutn_04 = 1;
         }else{
            $image_coutn_04 = 0;
         }
         if(!empty($fetch_listing['image_05'])){
            $image_coutn_05 = 1;
         }else{
            $image_coutn_05 = 0;
         }

         $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);
   ?>
   <div class="box">
      <div class="thumb">
         <p><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
         <img src="../uploaded_files/<?= $fetch_listing['image_01']; ?>" alt="">
      </div>
      <p class="price"><i class="fas fa-indian-rupee-sign"></i><?= $fetch_listing['price']; ?></p>
      <h3 class="name"><?= $fetch_listing['property_name']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><?= $fetch_listing['address']; ?></p>
      <div class="flex" style="margin: .7rem 0 .4rem; gap:1rem; flex-wrap:wrap;">
         <p><i class="fas fa-house"></i><span><?= $fetch_listing['type']; ?></span></p>
         <p><i class="fas fa-bed"></i><span><?= $fetch_listing['bhk']; ?> BHK</span></p>
         <p><i class="fas fa-trowel"></i><span><?= $fetch_listing['status']; ?></span></p>
         <p><i class="fas fa-couch"></i><span><?= $fetch_listing['furnished']; ?></span></p>
      </div>
      <form action="" method="POST">
         <input type="hidden" name="delete_id" value="<?= $listing_id; ?>">
         <a href="view_property.php?get_id=<?= $listing_id; ?>" class="btn">view property</a>
         <input type="submit" value="delete listing" onclick="return confirm('delete this listing?');" name="delete" class="delete-btn">
      </form>
   </div>
   <?php
         }
      }elseif(isset($_POST['search_btn'])){
         echo '<p class="empty">no results found!</p>';
      }else{
         echo '<p class="empty">no property posted yet!</p>';
      }
   ?>

   </div>

</section>



















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>