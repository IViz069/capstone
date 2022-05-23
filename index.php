<?php
session_start();

require 'database.php';

$products = $conn->prepare('SELECT * FROM caps_products');
$products->execute();
$productsResults = $products->fetchAll();



if (isset($_SESSION['user_id'])) {
   $records = $conn->prepare('SELECT id, email, password FROM caps_users WHERE id = :id');
   $records->bindParam(':id', $_SESSION['user_id']);
   $records->execute();
   $results = $records->fetch(PDO::FETCH_ASSOC);

   $user = null;

   if (count($results) > 0) {
      $user = $results;
   }
}
?>

<!DOCTYPE html>
<html>

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Rodamientos Salas SRL</title>
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- bootstrap css -->
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <!-- style css -->
   <link rel="stylesheet" href="css/style.css">
   <!-- Responsive-->
   <link rel="stylesheet" href="css/responsive.css">
   <!-- fevicon -->
   <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
   <!-- Tweaks for older IEs-->
   <link rel="stylesheet" href="css/owl.carousel.min.css">
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <link rel="stylesheet" href="https://rawgit.com/LeshikJanz/libraries/master/Bootstrap/baguetteBox.min.css">
</head>

<body class="main-layout">
   <!-- loader  -->
   <div class="loader_bg">
      <div class="loader"><img src="images/loading.gif" alt="#" /></div>
   </div>
   <!-- end loader -->

   <!-- header -->
   <header class="header-area">
      <div class="container-fluid">
         <div class="row ">

            <div class=" col-md-2 col-sm-3">
               <div class="logo">
                  <a href="index.php">Rodamientos<br><span>Salas</span></a>
               </div>
            </div>
            <div class="col-md-8 col-sm-9">
               <div class="navbar-area">
                  <nav class="site-navbar">
                     <ul>
                        <li><a class="active" href="index.php">Inicio</a></li>
                        <li><a href="products.php">Productos</a></li>
                        <li><a href="#">Nosotros</a></li>
                     </ul>
                     <button class="nav-toggler">
                        <span></span>
                     </button>
                  </nav>
               </div>
            </div>
            <div class=" col-md-2 di_none">
               </ul>
               <?php if (!empty($user)) : ?>
                  <ul class="email text_align_right">
                     <li><a href="profile.php"><img width="30" src="images/profile.png"></a></li>
                  <?php else : ?>
                     <ul class="email text_align_right">
                        <li><a href="login.php">Login</a></li>
                     <?php endif; ?>
                     <li><a href="cart.php"><img width="30"src="images/cart.png"></a></li>
            </div>
         </div>
      </div>
   </header>
   <!-- end header inner -->
   <!-- top -->
   <div class="full_bg bt_fe">
      <div class="slider_main">
         <div class="container-fluid">
            <div class="row d_flex">
               <div class="col-md-5">
                  <div class="creative">
                     <h1>BRINDAMOS SOLUCIONES PARA LOS ENTORNOS MAS EXIGENTES</h1>
                     <a class="read_more" href="contact.html">Contactanos</a>
                  </div>
               </div>
               <div class="col-md-7">
                  <!-- carousel code -->
                  <div id="banner1" class="carousel slide">
                     <ol class="carousel-indicators">
                        <li data-target="#banner1" data-slide-to="0" class="active"></li>
                        <li data-target="#banner1" data-slide-to="1"></li>
                        <li data-target="#banner1" data-slide-to="2"></li>
                     </ol>
                     <div class="carousel-inner">
                        <!-- first slide -->
                        <div class="carousel-item active">
                           <div class="container">
                              <div class="carousel-caption relative">
                                 <div class="row d_flex">
                                    <div class="col-md-12">
                                       <div class="cemara">
                                          <figure><img src="images/img.png" alt="#" /></figure>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- second slide -->
                        <div class="carousel-item">
                           <div class="container">
                              <div class="carousel-caption relative">
                                 <div class="row d_flex">
                                    <div class="col-md-12">
                                       <div class="cemara">
                                          <figure><img src="images/img.png" alt="#" /></figure>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- third slide-->
                        <div class="carousel-item">
                           <div class="container">
                              <div class="carousel-caption relative">
                                 <div class="row d_flex">
                                    <div class="col-md-12">
                                       <div class="cemara">
                                          <figure><img src="images/img.png" alt="#" /></figure>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- controls -->
                     <a class="carousel-control-prev" href="#banner1" role="button" data-slide="prev">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                     </a>
                     <a class="carousel-control-next" href="#banner1" role="button" data-slide="next">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
   <!-- end banner -->
   <!-- gallery -->
   <div class="gallery">
      <div class="container_with">
         <div class="row">
            <div class="col-md-12">
               <div class="titlepage text_align_center">
                  <span>Nuestros</span>
                  <h2>Productos</h2>
               </div>
            </div>
         </div>
         <div class="tz-gallery">
            <div class="row">
               <?php
               for ($i = 0; $i < count($productsResults); $i++) {
                  ?>
                     <div class="col-lg-4 col-md-6 ma_bottom30">
                        <div class="lightbox">
                           <img height="200" src="<?php echo $productsResults[$i][4] ?>" alt="Bridge">
                           <div class="view_main">
                              <div class="pose">
                                 <a class="read_more" href="images/g1.jpg"><img src="images/ga.png" alt="#" /></a>
                                 

                  <?php
                  for ($j = 0; $j < (count($productsResults[0]) / 2)-1; $j++) {
                     ?>
                        <span ><?php print $productsResults[$i][$j]?></span>
                     <?php
                  }
                  ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php
               }
               ?>

            </div>
         </div>
      </div>
   </div>
   <!-- end gallery -->
   <!-- about -->
   <div class="about">
      <div class="container">
         <div class="row">
            <div class="col-md-6">
               <div class="titlepage text_align_left">
                  <span>02</span>
                  <h2>About Us</h2>
                  <p>Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model </p>
                  <a class="read_more" href="about.html">Read More</a>
               </div>
            </div>
            <div class="col-md-6">
               <div class="about_img">
                  <figure><img src="images/about_img.png" alt="#" /></figure>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end about -->
   
   <!--  customers -->
   <!--
   <div class="customers">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="titlepage text_align_center">
                  <span>04</span>
                  <h2>What is Saying Customers</h2>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="satteb text_align_center">
                  <p>fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that itfact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that itfact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that itfact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it</p>
                  <h3>The point of using </h3>
                  <i><img src="images/custo.jpg" alt="#" /></i>
               </div>
            </div>
         </div>
      </div>
   </div>
   -->
   <!-- end customers  -->

   <!-- contact -->
      <!--
   <div class="contact">
      <div class="container">
         <div class="row">
            <div class="col-md-12 ">
               <div class="titlepage text_align_center">
                  <span>05</span>
                  <h2>Requste A Call Back</h2>
               </div>
            </div>
            <div class="col-md-8 offset-md-2">
               <form id="request" class="main_form">
                  <div class="row">
                     <div class="col-md-12">
                        <input class="form_control" placeholder="Your name" type="type" name=" Name">
                     </div>
                     <div class="col-md-12">
                        <input class="form_control" placeholder="Phone Number" type="type" name="Phone Number">
                     </div>
                     <div class="col-md-12">
                        <input class="form_cont" placeholder="Message" type="type" name="message">
                     </div>
                     <div class="col-md-12">
                        <div class="group_form">
                           <button class="send_btn">Send</button>
                           <button class="send_btn">Location</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
      -->
   <!-- end contact -->

   <!-- end footer -->
   <footer>
      <div class="footer">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <ul class="menu_footer">
                     <li><a class="active" href="index.html">Home</a></li>
                     <li><a href="about.html">About</a></li>
                     <li><a href="services.html">Services</a></li>
                     <li><a href="gallery.html">Gallery</a></li>
                     <li><a href="projects.html">Projects</a></li>
                     <li><a href="blog.html">Blog</a></li>
                     <li><a href="contact.html">Contact</a></li>
                  </ul>
               </div>
               <div class="col-md-12">
                  <ul class="top_infomation">
                     <li><a href="javascript:void(0)"><i><img src="images/loc.png" alt="#" /></i></a></li>
                     <li><a href="javascript:void(0)"><i><img src="images/call.png" alt="#" /></i></a></li>
                     <li><a href="javascript:void(0)"><i><img src="images/mail.png" alt="#" /></i></a></li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="copyright">
            <div class="container">
               <div class="row d_flex">
                  <div class="col-md-8">
                     <p>© 2022 All Rights Reserved. Design by <a href="https://html.design/"> Free html Templates</a></p>
                  </div>
                  <div class="col-md-4">
                     <ul class="social_icon_bottom ">
                        <li><a href="Javascript:void(0)"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="Javascript:void(0)"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="Javascript:void(0)"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </footer>
   <!-- end footer -->
   <!-- Javascript files-->
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.bundle.min.js"></script>
   <script src="js/jquery-3.0.0.min.js"></script>
   <script src="js/owl.carousel.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
   <script src="js/custom.js"></script>
   <script type="text/javascript">
      baguetteBox.run('.tz-gallery');
   </script>
</body>

</html>