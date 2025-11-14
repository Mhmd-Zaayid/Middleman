<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'components/save_send.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
   <style>
      body{ font-family: 'Poppins', system-ui, sans-serif; }
      .modern-filters{
         /* remove all color outside the card */
         background: transparent !important;
         background-color: transparent !important;
         padding: 3rem 1.2rem !important;
      }
      .filter-card{
         max-width: 1200px;
         margin: 0 auto;
         background: #fff;
         border-radius: 16px;
         box-shadow: 0 8px 22px -4px rgba(0,0,0,.12);
         padding: 2.2rem 2rem 2.4rem;
      }
      .filter-card h3{ 
         margin: 0 0 1.2rem; font-size: 2.1rem; font-weight: 600; color: #1d3557;
      }
      .filter-grid{
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
         gap: 1.4rem 1.2rem;
         margin-top: 1.2rem;
      }
      .filter-field{ display: flex; flex-direction: column; }
      .filter-field label{ font-size: 1.2rem; font-weight: 500; color: #2d3a4b; margin-bottom: .45rem; letter-spacing: .2px; }
      .filter-field .input{ 
         border: 1px solid #d7e0ea; background: #f9fbfd; border-radius: 10px; padding: .9rem 1rem; font-size: 1.2rem; outline: none; transition: .2s;
      }
      .filter-field .input:hover{ background: #fff; border-color: #60a5fa; box-shadow: 0 0 0 3px rgba(96,165,250,.25); }
      .filter-field .input:focus{ background: #fff; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.28); }
      .filter-actions{ display:flex; gap:1rem; align-items:center; margin-top:1.4rem; }
      .filter-actions .btn{ 
         background: linear-gradient(90deg,#4b79cf,#6aa6ff); color:#fff; border:none; padding: .95rem 1.6rem; border-radius: 30px; font-weight:600; letter-spacing:.3px; cursor:pointer; transition: .28s; box-shadow: 0 6px 18px -6px rgba(55,120,190,.45);
      }
      .filter-actions .btn:hover{ transform: translateY(-3px); box-shadow: 0 10px 24px -6px rgba(55,120,190,.55); }
      .filter-warning{ display:none; margin-top:.6rem; color:#b91c1c; font-size: .95rem; }
      @media (max-width: 640px){
         .filter-card{ padding: 1.6rem 1.2rem 1.8rem; }
         .filter-card h3{ font-size: 1.6rem; }
         .filter-grid{ grid-template-columns: 1fr; }
      }
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- search filter section starts  -->

<section class="filters modern-filters" style="padding-bottom: 0;">
   <div class="filter-card">
      <form id="filterForm" action="" method="post">
         <div id="close-filter"><i class="fas fa-times"></i></div>
         <h3>Filter Your Search</h3>
         <div id="filterMessage" class="filter-warning">Please select at least one filter.</div>
         <div class="filter-grid">
            <div class="filter-field">
               <label for="location">Select City</label>
               <select id="location" name="location" class="input">
                  <option value="">Select City</option>
                  <!-- Pan-India major cities -->
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
                  <!-- Kerala core districts -->
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
                  <!-- Additional Kerala notable towns (10 extras) -->
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
            </div>
            <div class="filter-field">
               <label for="type">Property Type</label>
               <select id="type" name="type" class="input">
                  <option value="">Any Type</option>
                  <option value="flat">flat</option>
                  <option value="house">house</option>
                  <option value="plot">plot</option>
               </select>
            </div>
            <div class="filter-field">
               <label for="bhk">How many BHK</label>
               <select id="bhk" name="bhk" class="input">
                  <option value="">Any BHK</option>
                  <option value="1">1 BHK</option>
                  <option value="2">2 BHK</option>
                  <option value="3">3 BHK</option>
                  <option value="4">4 BHK</option>
                  <option value="5">5 BHK</option>
                  <option value="6">6 BHK</option>
                  <option value="7">7 BHK</option>
                  <option value="8">8 BHK</option>
                  <option value="9">9 BHK</option>
               </select>
            </div>
            <div class="filter-field">
               <label for="min">Minimum Budget</label>
               <select id="min" name="min" class="input">
                  <option value="">Any Budget</option>
                  <option value="5000">5k</option>
                  <option value="10000">10k</option>
                  <option value="15000">15k</option>
                  <option value="20000">20k</option>
                  <option value="30000">30k</option>
                  <option value="40000">40k</option>
                  <option value="50000">50k</option>
                  <option value="100000">1 lac</option>
                  <option value="500000">5 lac</option>
                  <option value="1000000">10 lac</option>
                  <option value="2000000">20 lac</option>
                  <option value="3000000">30 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="5000000">50 lac</option>
                  <option value="6000000">60 lac</option>
                  <option value="7000000">70 lac</option>
                  <option value="8000000">80 lac</option>
                  <option value="9000000">90 lac</option>
                  <option value="10000000">1 Cr</option>
                  <option value="20000000">2 Cr</option>
                  <option value="30000000">3 Cr</option>
                  <option value="40000000">4 Cr</option>
                  <option value="50000000">5 Cr</option>
                  <option value="60000000">6 Cr</option>
                  <option value="70000000">7 Cr</option>
                  <option value="80000000">8 Cr</option>
                  <option value="90000000">9 Cr</option>
                  <option value="100000000">10 Cr</option>
                  <option value="150000000">15 Cr</option>
                  <option value="200000000">20 Cr</option>
               </select>
            </div>
            <div class="filter-field">
               <label for="max">Maximum Budget</label>
               <select id="max" name="max" class="input">
                  <option value="">Any Budget</option>
                  <option value="10000">10k</option>
                  <option value="15000">15k</option>
                  <option value="20000">20k</option>
                  <option value="30000">30k</option>
                  <option value="40000">40k</option>
                  <option value="50000">50k</option>
                  <option value="100000">1 lac</option>
                  <option value="500000">5 lac</option>
                  <option value="1000000">10 lac</option>
                  <option value="2000000">20 lac</option>
                  <option value="3000000">30 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="5000000">50 lac</option>
                  <option value="6000000">60 lac</option>
                  <option value="7000000">70 lac</option>
                  <option value="8000000">80 lac</option>
                  <option value="9000000">90 lac</option>
                  <option value="10000000">1 Cr</option>
                  <option value="20000000">2 Cr</option>
                  <option value="30000000">3 Cr</option>
                  <option value="40000000">4 Cr</option>
                  <option value="50000000">5 Cr</option>
                  <option value="60000000">6 Cr</option>
                  <option value="70000000">7 Cr</option>
                  <option value="80000000">8 Cr</option>
                  <option value="90000000">9 Cr</option>
                  <option value="100000000">10 Cr</option>
                  <option value="150000000">15 Cr</option>
                  <option value="200000000">20 Cr</option>
               </select>
            </div>
            <div class="filter-field">
               <label for="status">Status</label>
               <select id="status" name="status" class="input">
                  <option value="">Any Status</option>
                  <option value="ready to move">ready to move</option>
                  <option value="under construction">under construction</option>
                  <option value="not applicable">not applicable</option>
               </select>
            </div>
            <div class="filter-field">
               <label for="furnished">Furnished</label>
               <select id="furnished" name="furnished" class="input">
                  <option value="">Any Furnished Status</option>
                  <option value="unfurnished">unfurnished</option>
                  <option value="furnished">furnished</option>
                  <option value="semi-furnished">semi-furnished</option>
                  <option value="not applicable">not applicable</option>
               </select>
            </div>
         </div>
         <div class="filter-actions">
            <input type="submit" value="search property" name="filter_search" class="btn">
         </div>
      </form>
   </div>
</section>

<!-- search filter section ends -->

<div id="filter-btn" class="fas fa-filter"></div>

<?php

if(isset($_POST['h_search'])){

   $h_location = htmlspecialchars($_POST['h_location'], ENT_QUOTES, 'UTF-8');
   $h_type = isset($_POST['h_type']) ? htmlspecialchars($_POST['h_type'], ENT_QUOTES, 'UTF-8') : '';
   $h_min = isset($_POST['h_min']) ? htmlspecialchars($_POST['h_min'], ENT_QUOTES, 'UTF-8') : '';
   $h_max = isset($_POST['h_max']) ? htmlspecialchars($_POST['h_max'], ENT_QUOTES, 'UTF-8') : '';

   $where = ["LOWER(city) = LOWER(:location)"];
   $params = [':location' => $h_location];

   if ($h_type !== '') {
      $where[] = "type = :type";
      $params[':type'] = $h_type;
   }
   if ($h_min !== '') {
      $where[] = "price >= :min";
      $params[':min'] = $h_min;
   }
   if ($h_max !== '') {
      $where[] = "price <= :max";
      $params[':max'] = $h_max;
   }

   $sql = "SELECT * FROM `property` WHERE " . implode(' AND ', $where) . " ORDER BY date DESC";
   $select_properties = $conn->prepare($sql);
   $select_properties->execute($params);

}elseif(isset($_POST['filter_search'])){

   $location  = htmlspecialchars($_POST['location'], ENT_QUOTES, 'UTF-8');
   $type      = isset($_POST['type']) ? htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8') : '';
   $bhk       = isset($_POST['bhk']) ? htmlspecialchars($_POST['bhk'], ENT_QUOTES, 'UTF-8') : '';
   $min       = htmlspecialchars($_POST['min'], ENT_QUOTES, 'UTF-8');
   $max       = htmlspecialchars($_POST['max'], ENT_QUOTES, 'UTF-8');
   $status    = isset($_POST['status']) ? htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8') : '';
   $furnished = isset($_POST['furnished']) ? htmlspecialchars($_POST['furnished'], ENT_QUOTES, 'UTF-8') : '';

   $where = [];
   $params = [];
   if($location !== ''){
      $where[] = "LOWER(city) = LOWER(:location)";
      $params[':location'] = $location;
   }

   // Price conditions: if max selected show all from min (or 0) up to max
   $hasMin = ($min !== '');
   $hasMax = ($max !== '');
   if($hasMax){
      if($hasMin){
         if((float)$min > (float)$max){ $tmp = $min; $min = $max; $max = $tmp; }
         $where[] = "price BETWEEN :min AND :max";
         $params[':min'] = $min;
         $params[':max'] = $max;
      }else{
         $where[] = "price BETWEEN :min AND :max";
         $params[':min'] = 0;
         $params[':max'] = $max;
      }
   }elseif($hasMin){
      $where[] = "price >= :min";
      $params[':min'] = $min;
   }

   if($type !== ''){
      $where[] = "type = :type";
      $params[':type'] = $type;
   }
   if($bhk !== ''){
      $where[] = "bhk = :bhk";
      $params[':bhk'] = $bhk;
   }
   if($status !== ''){
      $where[] = "status = :status";
      $params[':status'] = $status;
   }
   if($furnished !== ''){
      $where[] = "furnished = :furnished";
      $params[':furnished'] = $furnished;
   }

   if(count($where) === 0){
      $sql = "SELECT * FROM `property` ORDER BY date DESC LIMIT 12";
      $select_properties = $conn->prepare($sql);
      $select_properties->execute();
   }else{
      $sql = "SELECT * FROM `property` WHERE " . implode(' AND ', $where) . " ORDER BY date DESC";
      $select_properties = $conn->prepare($sql);
      $select_properties->execute($params);
   }

}else{
   $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
   $select_properties->execute();
}

?>

<!-- listings section starts  -->

<section class="listings">

   <?php 
      if(isset($_POST['h_search']) or isset($_POST['filter_search'])){
         echo '<h1 class="heading">search results</h1>';
      }else{
         echo '<h1 class="heading">latest listings</h1>';
      }
   ?>

   <div class="box-container">
      <?php
         $total_images = 0;
         if($select_properties->rowCount() > 0){
            while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_user->execute([$fetch_property['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

            if(!empty($fetch_property['image_02'])){
               $image_coutn_02 = 1;
            }else{
               $image_coutn_02 = 0;
            }
            if(!empty($fetch_property['image_03'])){
               $image_coutn_03 = 1;
            }else{
               $image_coutn_03 = 0;
            }
            if(!empty($fetch_property['image_04'])){
               $image_coutn_04 = 1;
            }else{
               $image_coutn_04 = 0;
            }
            if(!empty($fetch_property['image_05'])){
               $image_coutn_05 = 1;
            }else{
               $image_coutn_05 = 0;
            }

            $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);

            $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
            $select_saved->execute([$fetch_property['id'], $user_id]);

      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_property['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-indian-rupee-sign"></i><span><?= $fetch_property['price']; ?></span></div>
            <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
               <p><i class="fas fa-bed"></i><span><?= $fetch_property['bhk']; ?> BHK</span></p>
               <p><i class="fas fa-trowel"></i><span><?= $fetch_property['status']; ?></span></p>
               <p><i class="fas fa-couch"></i><span><?= $fetch_property['furnished']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">view property</a>
               <input type="submit" value="send enquiry" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">no results found!</p>';
      }
      ?>
      
   </div>

</section>

<!-- listings section ends -->











<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>

document.querySelector('#filter-btn').onclick = () =>{
   document.querySelector('.filters').classList.add('active');
}

document.querySelector('#close-filter').onclick = () =>{
   document.querySelector('.filters').classList.remove('active');
}


document.querySelector('select[name="type"]').addEventListener('change', function() {
    const isPlot = this.value === 'plot';
    const fieldsToUpdate = ['bhk', 'status', 'furnished'];
    
    fieldsToUpdate.forEach(field => {
        const select = document.querySelector(`select[name="${field}"]`);
        if(isPlot) {
            if(field === 'bhk') select.value = '';
            if(field === 'furnished') select.value = 'not applicable';
            if(field === 'status') select.value = 'not applicable';
        }
    });
});

// Front-end validation: require at least one filter before submit
document.getElementById('filterForm').addEventListener('submit', function(e){
   const fields = ['location','type','bhk','min','max','status','furnished'];
   const hasValue = fields.some(id => {
      const el = document.getElementById(id);
      return el && el.value.trim() !== '';
   });
   const msg = document.getElementById('filterMessage');
   if(!hasValue){
      e.preventDefault();
      msg.style.display = 'block';
      msg.focus();
      setTimeout(()=> msg.style.opacity = '1', 10);
   }else{
      msg.style.display = 'none';
      msg.style.opacity = '0';
   }
});
</script>

</body>
</html>