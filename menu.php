<?php
include 'includes/db.php';

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="Aseet/BG UMKM.png" type="">

  <title> PKK Desa Tegal </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>

<body class="sub_page">

  <div class="hero_area">
    <div class="bg-box">
      <img src="Aseet/Desktop - 1.png" alt="">
    </div>
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.html">
            <span>
              PKK Desa Tegal
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item">
                <a class="nav-link" href="index.html">Home </a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="menu.php">Produk <span class="sr-only">(current)</span> </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="book.html">Contact</a>
              </li>
            </ul>
            <!-- <div class="user_option">
              <a href="admin/login.php">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>
                  Admin
                </span>
              </a>
            </div> -->
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- food section -->
  <section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Produk
        </h2>
      </div>

      <main>
        <form method="GET" action="menu.php">
          <label for="category">Filter by Category:</label>
          <select id="category" name="category_id">
            <option value="0">All</option>
            <?php
            $sql = "SELECT * FROM categories";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $selected = $row['id'] == $category_id ? 'selected' : '';
              echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
            }
            ?>
          </select>
          <button type="submit">Filter</button>
        </form>

        <div class="Barang">
          <?php
          $sql = "SELECT products.*, categories.name as category_name FROM products 
                  LEFT JOIN categories ON products.category_id = categories.id";
          if ($category_id != 0) {
            $sql .= " WHERE category_id = $category_id";
          }
          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<img src='uploads/" . $row['image'] . "' alt='" . $row['name'] . "'>";
            echo "<h2>" . $row['name'] . "</h2>";
            echo "<p>harga: Rp" . number_format( $row['price'], 0, ',', '.' ) . "</p>";
            echo "<p>kategori: " . $row['category_name'] . "</p>";
            echo "<p>deskripsi: " . $row['description'] . "</p>";  // Menampilkan deskripsi produk
            echo "</div>";
          }
          ?>
        </div>
      </main>
  </section>

  <!-- end food section -->

  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <div class="row">
        <div class="col-md-4 footer-col">
          <div class="footer_contact">
            <h4>
              Media
            </h4>
            <div class="contact_link_box">
              <a href="book.html">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  Lokasi
                </span>
              </a>
              <a href="book.html">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Hubungi
                </span>
              </a>
              <a href="book.html">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  @Pemerintah_Desa_tegal
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4 footer-col">
          <div class="footer_detail">
            <a href="" class="footer-logo">
            PKK Desa Tegal
            </a>
            <p>
              UMKM Desa Tegal Temukan Produk Local
            </p>
          </div>
        </div>
        <div class="col-md-4 footer-col">
          <h4>
            Jam Oprasional
          </h4>
          <p>
            Everyday
          </p>
          <p>
            10.00 Wib -15.00 Wib
          </p>
        </div>
      </div>
      <div class="footer-info">
        <p>
          <span id="displayYear"></span>
        </p>
      </div>
    </div>
  </footer>
  <!-- footer section -->

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- isotope js -->
  <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->
</body>
</html>
