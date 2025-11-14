<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['post'])){

   $id = create_unique_id();
   $property_name = htmlspecialchars($_POST['property_name'], ENT_QUOTES, 'UTF-8');
   $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
   $address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
   $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');
   $type = htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8');
   $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
   $furnished = htmlspecialchars($_POST['furnished'], ENT_QUOTES, 'UTF-8');
   $bhk = htmlspecialchars($_POST['bhk'], ENT_QUOTES, 'UTF-8');
   // bedroom removed from form; default to 0
   $bedroom = 0;
   $bathroom = htmlspecialchars($_POST['bathroom'], ENT_QUOTES, 'UTF-8');
   $age = htmlspecialchars($_POST['age'], ENT_QUOTES, 'UTF-8');
   $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

   $image_02 = htmlspecialchars($_FILES['image_02']['name'], ENT_QUOTES, 'UTF-8');
   $image_02_ext = pathinfo($image_02, PATHINFO_EXTENSION);
   $rename_image_02 = create_unique_id().'.'.$image_02_ext;
   $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
   $image_02_size = $_FILES['image_02']['size'];
   $image_02_folder = 'uploaded_files/'.$rename_image_02;

   if(!empty($image_02)){
      if($image_02_size > 2000000){
         $warning_msg[] = 'image 02 size is too large!';
      }else{
         move_uploaded_file($image_02_tmp_name, $image_02_folder);
      }
   }else{
      $rename_image_02 = '';
   }

   $image_03 = htmlspecialchars($_FILES['image_03']['name'], ENT_QUOTES, 'UTF-8');
   $image_03_ext = pathinfo($image_03, PATHINFO_EXTENSION);
   $rename_image_03 = create_unique_id().'.'.$image_03_ext;
   $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
   $image_03_size = $_FILES['image_03']['size'];
   $image_03_folder = 'uploaded_files/'.$rename_image_03;

   if(!empty($image_03)){
      if($image_03_size > 2000000){
         $warning_msg[] = 'image 03 size is too large!';
      }else{
         move_uploaded_file($image_03_tmp_name, $image_03_folder);
      }
   }else{
      $rename_image_03 = '';
   }

   $image_04 = htmlspecialchars($_FILES['image_04']['name'], ENT_QUOTES, 'UTF-8');
   $image_04_ext = pathinfo($image_04, PATHINFO_EXTENSION);
   $rename_image_04 = create_unique_id().'.'.$image_04_ext;
   $image_04_tmp_name = $_FILES['image_04']['tmp_name'];
   $image_04_size = $_FILES['image_04']['size'];
   $image_04_folder = 'uploaded_files/'.$rename_image_04;

   if(!empty($image_04)){
      if($image_04_size > 2000000){
         $warning_msg[] = 'image 04 size is too large!';
      }else{
         move_uploaded_file($image_04_tmp_name, $image_04_folder);
      }
   }else{
      $rename_image_04 = '';
   }

   $image_05 = htmlspecialchars($_FILES['image_05']['name'], ENT_QUOTES, 'UTF-8');
   $image_05_ext = pathinfo($image_05, PATHINFO_EXTENSION);
   $rename_image_05 = create_unique_id().'.'.$image_05_ext;
   $image_05_tmp_name = $_FILES['image_05']['tmp_name'];
   $image_05_size = $_FILES['image_05']['size'];
   $image_05_folder = 'uploaded_files/'.$rename_image_05;

   if(!empty($image_05)){
      if($image_05_size > 2000000){
         $warning_msg[] = 'image 05 size is too large!';
      }else{
         move_uploaded_file($image_05_tmp_name, $image_05_folder);
      }
   }else{
      $rename_image_05 = '';
   }

   $image_01 = htmlspecialchars($_FILES['image_01']['name'], ENT_QUOTES, 'UTF-8');
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = 'uploaded_files/'.$rename_image_01;

   if($image_01_size > 2000000){
      $warning_msg[] = 'image 01 size too large!';
   }else{
      $insert_property = $conn->prepare("INSERT INTO `property`(id, user_id, property_name, address, city, price, type, status, furnished, bhk, bedroom, bathroom, age, image_01, image_02, image_03, image_04, image_05, description) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
      $insert_property->execute([$id, $user_id, $property_name, $address, $city, $price, $type, $status, $furnished, $bhk, $bedroom, $bathroom, $age, $rename_image_01, $rename_image_02, $rename_image_03, $rename_image_04, $rename_image_05, $description]);
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      $success_msg[] = 'property posted successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>post property</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
   <style>
      body.post-page{
         font-family: 'Poppins', system-ui, sans-serif;
         min-height: 100vh;
         /* background image only, no color overlay */
         background-image: url('images/loginback.png');
         background-size: cover;
         background-position: center center;
         background-repeat: no-repeat;
         background-attachment: fixed;
         display: flex;
         flex-direction: column;
      }
      .post-page .property-form{ padding: 4rem 2rem; flex: 1; }
      .post-page .property-form .form-card{
         max-width: 1280px; /* slightly wider card */
         margin: 0 auto;
         background: #ffffff;
         border-radius: 1.4rem;
         box-shadow: 0 8px 28px -6px rgba(30,54,80,.25);
         padding: 3.2rem 3rem 3.6rem;
         position: relative;
         overflow: hidden;
      }
      .post-page .form-title{
         display:flex; align-items:center; gap:1.2rem; margin-bottom:2.4rem;
      }
      .post-page .form-title h3{ font-size:2.4rem; font-weight:600; margin:0; background: linear-gradient(90deg,#4b79cf,#4CAF50); -webkit-background-clip:text; color:transparent; }
      .post-page .form-title .icon-wrap svg{ width:56px; height:56px; filter:drop-shadow(0 4px 8px rgba(0,0,0,.15)); }
      .post-page .grid-two{
         display:grid;
         grid-template-columns: repeat(auto-fill,minmax(320px,1fr)); /* widened each box */
         gap:2.2rem 2.0rem;
         margin-bottom:2.4rem;
      }
      .post-page .form-group{ display:flex; flex-direction:column; }
      .post-page .form-group label{ font-size:1.3rem; font-weight:500; letter-spacing:.5px; margin-bottom:.6rem; color:#1d3557; }
      .post-page .form-group label span{ color:#e63946; }
      .post-page .form-group .input,
      .post-page .form-group textarea{ width:100%; border:1px solid #cfd9e4; background:#f9fbfc; border-radius:.9rem; padding:.95rem 1.05rem; font-size:1.35rem; transition:.25s; outline:none; }
      .post-page .form-group .input:focus,
      .post-page .form-group textarea:focus{ border-color:#4CAF50; background:#fff; box-shadow:0 0 0 3px rgba(76,175,80,.18); }
      .post-page .form-group .input:hover{ background:#fff; }
      .post-page textarea{ min-height:140px; resize:vertical; }
      .post-page .images-grid{ display:grid; grid-template-columns: repeat(auto-fill,minmax(220px,1fr)); gap:2rem; margin-top:.5rem; }
      .post-page .submit-wrap{ margin-top:1.2rem; }
      .post-page .btn{
         background: linear-gradient(90deg,#4b79cf,#4CAF50);
         color:#fff; border:none; font-weight:600; letter-spacing:.5px; font-size:1.4rem;
         padding:1.15rem 2.4rem; border-radius:3rem; cursor:pointer; transition:.35s;
         box-shadow:0 6px 18px -4px rgba(55,120,190,.45);
      }
      .post-page .btn:hover{ transform:translateY(-3px); box-shadow:0 10px 24px -6px rgba(55,120,190,.55); }
      .post-page .btn:active{ transform:translateY(0); box-shadow:0 4px 14px -4px rgba(55,120,190,.45); }
      .post-page .invalid{ border-color:#e63946 !important; box-shadow:0 0 0 3px rgba(230,57,70,.25) !important; }
      .post-page .note{ font-size:1.15rem; color:#577590; margin-top:.3rem; }
      @media (max-width:860px){
         .post-page .property-form{ padding:3rem 1.4rem; }
         .post-page .form-card{ padding:2.4rem 2.2rem 3rem; }
         .post-page .form-title h3{ font-size:2.1rem; }
         .post-page .grid-two{ grid-template-columns:1fr; }
      }
      @media (prefers-reduced-motion: reduce){
         .post-page *{ transition:none !important; }
      }
   </style>

</head>
<body class="post-page">
   
<?php include 'components/user_header.php'; ?>

<section class="property-form">
   <div class="form-card">
      <div class="form-title">
         <div class="icon-wrap" aria-hidden="true">
            <!-- Real estate themed icon: gradient ring + house roof + window + location pin overlay -->
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Real estate">
               <defs>
                  <linearGradient id="estateRing" x1="8" y1="8" x2="56" y2="56" gradientUnits="userSpaceOnUse">
                     <stop offset="0%" stop-color="#7BAEE3"/>
                     <stop offset="100%" stop-color="#4CAF50"/>
                  </linearGradient>
                  <linearGradient id="estateFill" x1="22" y1="28" x2="42" y2="48" gradientUnits="userSpaceOnUse">
                     <stop offset="0%" stop-color="#7BAEE3"/>
                     <stop offset="100%" stop-color="#4CAF50"/>
                  </linearGradient>
               </defs>
               <circle cx="32" cy="32" r="30" stroke="url(#estateRing)" stroke-width="2.4" fill="rgba(255,255,255,0.12)"/>
               <!-- House base -->
               <path d="M20 46V30.8c0-.4.18-.8.5-1.05l11-8.4a2 2 0 0 1 2.4 0l11 8.4c.32.25.5.65.5 1.05V46a2 2 0 0 1-2 2H22a2 2 0 0 1-2-2Z" fill="url(#estateFill)" stroke="#2f4858" stroke-width="2"/>
               <!-- Roof -->
               <path d="M16 31.5 30.7 20.4a2.6 2.6 0 0 1 3.2 0L48 31.5" stroke="#2f4858" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
               <!-- Window -->
               <rect x="28" y="34" width="8" height="8" rx="1.2" fill="#ffffff" stroke="#2f4858" stroke-width="1.8"/>
               <path d="M32 34v8M28 38h8" stroke="#2f4858" stroke-width="1.6" stroke-linecap="round"/>
               <!-- Location pin overlay -->
               <path d="M32 19c-3.9 0-7 2.9-7 6.4 0 4.6 5.4 10.2 6.2 11 .5.5 1.1.5 1.6 0 .8-.8 6.2-6.4 6.2-11 0-3.5-3.1-6.4-7-6.4Z" fill="rgba(76,175,80,0.30)" stroke="#4CAF50" stroke-width="2"/>
               <circle cx="32" cy="25.4" r="2.4" fill="#2f4858"/>
            </svg>
         </div>
         <h3>Property Details</h3>
      </div>
      <form id="propertyForm" action="" method="POST" enctype="multipart/form-data" novalidate>
         <div class="grid-two">
            <div class="form-group">
               <label for="property_name">Property Name <span>*</span></label>
               <input type="text" id="property_name" name="property_name" required maxlength="50" placeholder="e.g. Sunny Heights" class="input">
            </div>
            <div class="form-group">
               <label for="price">Price <span>*</span></label>
               <input type="number" id="price" name="price" required min="0" max="9999999999" maxlength="10" placeholder="e.g. 2500000" class="input">
            </div>
            <div class="form-group">
               <label for="city">City <span>*</span></label>
               <select id="city" name="city" required class="input">
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
                  <!-- Kerala districts -->
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
                  <!-- Additional Kerala notable towns -->
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
            <div class="form-group">
               <label for="address">Address <span>*</span></label>
               <input type="text" id="address" name="address" required maxlength="100" placeholder="Full address" class="input">
            </div>
            <div class="form-group">
               <label for="type">Type <span>*</span></label>
               <select id="type" name="type" required class="input">
                  <option value="flat">flat</option>
                  <option value="house">house</option>
                  <option value="plot">plot</option>
               </select>
            </div>
            <div class="form-group">
               <label for="status">Status <span>*</span></label>
               <select id="status" name="status" required class="input">
                  <option value="ready to move">ready to move</option>
                  <option value="under construction">under construction</option>
                  <option value="not applicable">not applicable</option>
               </select>
            </div>
            <div class="form-group">
               <label for="furnished">Furnished <span>*</span></label>
               <select id="furnished" name="furnished" required class="input">
                  <option value="furnished">furnished</option>
                  <option value="semi-furnished">semi-furnished</option>
                  <option value="unfurnished">unfurnished</option>
                  <option value="not applicable">not applicable</option>
               </select>
            </div>
            <div class="form-group">
               <label for="bhk">BHK <span>*</span></label>
               <select id="bhk" name="bhk" required class="input">
                  <option value="0">not applicable</option>
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
            <div class="form-group">
               <label for="bathroom">Bathrooms <span>*</span></label>
               <select id="bathroom" name="bathroom" required class="input">
                  <option value="0">not applicable</option>
                  <option value="1">1 bathroom</option>
                  <option value="2">2 bathroom</option>
                  <option value="3">3 bathroom</option>
                  <option value="4">4 bathroom</option>
                  <option value="5">5 bathroom</option>
                  <option value="6">6 bathroom</option>
                  <option value="7">7 bathroom</option>
                  <option value="8">8 bathroom</option>
                  <option value="9">9 bathroom</option>
               </select>
            </div>
            <div class="form-group">
               <label for="age">Property Age <span>*</span></label>
               <input type="number" id="age" name="age" required min="0" max="99" maxlength="2" placeholder="Years" class="input">
            </div>
         </div>
         <div class="form-group">
            <label for="description">Description <span>*</span></label>
            <textarea id="description" name="description" maxlength="1000" required placeholder="Write about the property..." class="input"></textarea>
            <div class="note" id="descNote">Max 1000 characters.</div>
         </div>
         <div class="images-grid">
            <div class="form-group">
               <label for="image_01">Image 01 <span>*</span></label>
               <input type="file" id="image_01" name="image_01" class="input" accept="image/*" required>
            </div>
            <div class="form-group">
               <label for="image_02">Image 02</label>
               <input type="file" id="image_02" name="image_02" class="input" accept="image/*">
            </div>
            <div class="form-group">
               <label for="image_03">Image 03</label>
               <input type="file" id="image_03" name="image_03" class="input" accept="image/*">
            </div>
            <div class="form-group">
               <label for="image_04">Image 04</label>
               <input type="file" id="image_04" name="image_04" class="input" accept="image/*">
            </div>
            <div class="form-group">
               <label for="image_05">Image 05</label>
               <input type="file" id="image_05" name="image_05" class="input" accept="image/*">
            </div>
         </div>
         <div class="submit-wrap">
            <button type="submit" class="btn" name="post">Post Property</button>
         </div>
      </form>
   </div>
</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>
// retain existing plot conditional logic with new IDs
document.getElementById('type').addEventListener('change', function() {
   const isPlot = this.value === 'plot';
   const map = {
      bhk: isPlot ? '0' : '1',
      bathroom: isPlot ? '0' : '1',
      furnished: isPlot ? 'not applicable' : 'unfurnished',
      status: isPlot ? 'not applicable' : 'ready to move'
   };
   for(const field in map){
      const el = document.getElementById(field);
      if(el) el.value = map[field];
   }
});

// basic validation highlighting
document.getElementById('propertyForm').addEventListener('submit', function(e){
   const required = this.querySelectorAll('[required]');
   let firstInvalid = null;
   required.forEach(el => {
      if(!el.value){
         el.classList.add('invalid');
         if(!firstInvalid) firstInvalid = el;
      } else {
         el.classList.remove('invalid');
      }
   });
   if(firstInvalid){
      e.preventDefault();
      firstInvalid.focus();
   }
});
document.querySelectorAll('#propertyForm .input, #propertyForm textarea').forEach(el => {
   el.addEventListener('input', () => el.classList.remove('invalid'));
});
</script>

</body>
</html>