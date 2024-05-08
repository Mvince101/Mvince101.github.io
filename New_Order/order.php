<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shopping Cart System</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
</head>

<body>
<header>
      <nav class="navbar">
        <img src="logo.png" alt="">
        <ul class="menu-links">
          <span id="close-menu-btn" class="material-symbols-outlined">close</span>
          <li><a href="homepage.html">Home</a></li>
          <li><a href="https://maps.app.goo.gl/FPQ3oU7A9Qu2iCSA7">Stores</a></li>
          <li><a href="aboutus.html">About us</a></li>
          <li><a href="contact.html">Contact us</a></li>
          <li><a href="checkout.php"><i class="fas fa-money-check-alt mr-2"></i>Checkout</a></li>
          <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a></li>
        </ul>
        <span id="hamburger-btn" class="material-symbols-outlined">menu</span>
      </nav>
    </header>

  <div class="container">
    <div id="message"></div>
    <div class="row mt-2 pb-3">
      <?php
  			include 'config.php';
  			$stmt = $conn->prepare('SELECT * FROM product');
  			$stmt->execute();
  			$result = $stmt->get_result();
  			while ($row = $result->fetch_assoc()):
  		?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
        <div class="card-deck">
          <div class="card p-2 border-secondary mb-2">
            <img src="<?= $row['product_image'] ?>" class="card-img-top" height="250">
            <div class="card-body p-1">
              <h4 class="card-title text-center"><?= $row['product_name'] ?></h4>
              <h5 class="card-text text-center text-danger">₱<?= number_format($row['product_price'],2) ?>/-</h5>

            </div>
            <div class="card-footer p-1">
              <form action="" class="form-submit">
                <div class="row p-2">
                  <div class="col-md-6 py-1 pl-4">
                    <b>Quantity : </b>
                  </div>
                  <div class="col-md-6">
                    <input type="number" class="form-control pqty" value="<?= $row['product_qty'] ?>">
                  </div>
                </div>
                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                <button class="btn btn-block addItemBtn"><i class="fas fa-cart-plus"></i> Add to
                  cart</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
  


  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script type="text/javascript">
  $(document).ready(function() {


    $(".addItemBtn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pname = $form.find(".pname").val();
      var pprice = $form.find(".pprice").val();
      var pimage = $form.find(".pimage").val();
      var pcode = $form.find(".pcode").val();

      var pqty = $form.find(".pqty").val();

      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
          pid: pid,
          pname: pname,
          pprice: pprice,
          pqty: pqty,
          pimage: pimage,
          pcode: pcode
        },
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
          load_cart_item_number();
        }
      });
    });


    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
  });
  </script>

  
<script>
      const header = document.querySelector("header");
      const hamburgerBtn = document.querySelector("#hamburger-btn");
      const closeMenuBtn = document.querySelector("#close-menu-btn");

      hamburgerBtn.addEventListener("click", () => header.classList.toggle("show-mobile-menu"));
      closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());
    </script>
    
</body>

</html>

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
    margin: 0;
    padding: 0;
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
      background-image: url("bg.jpg");
  }

.container{
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 10px;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
    margin-top: 130px;
  }

.card{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    background-color: #01554f;
}

.nav-link:hover{
    color: #fed340;
}

h4, b{
    color: black;
}

a{
  text-decoration: none;
  color: black;
}


header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  padding: 10px;
  background-color: #01554f;
  z-index: 10;
}

header .navbar {
  display: flex;
  align-items: center;
justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0;
}


.navbar .menu-links {
  display: flex;
  list-style: none;
  gap: 35px;
}

.navbar a {
  color: white;
font-size: 1rem;
  text-decoration: none;
  transition: 0.2s ease;
}

.navbar a:hover {
  color: #fad97a;
}


#close-menu-btn {
  color: white;
  position: absolute;
  right: 20px;
  top: 20px;
  cursor: pointer;
  display: none;
}

#hamburger-btn {
  color: white;
  cursor: pointer;
  display: none;
}

#close-menu-btn {
  position: absolute;
  right: 20px;
  top: 20px;
  cursor: pointer;
  display: none;
}

#hamburger-btn {
  color: white;
  cursor: pointer;
  display: none;
}

.addItemBtn{
  background-color: #fed340;
}

.navbar img {
    max-height: 100%;
    max-width: 6.9%;
    height: auto;
    padding: 0;
    margin: 0;
    margin-left: 40px; /* Add this */
  }

@media (max-width: 767px) {
  header {
    padding: 5px;
  }

  .badge{
  position: relative;
  left: 10px;
  bottom: 10px;
  width: 10px;
  height: 10px;
}

  header.show-mobile-menu::before {
    content: "";
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(5px);
  }

  #hamburger-btn, #close-menu-btn {
    display: block;
  }

  .navbar .menu-links {
    position: fixed;
    top: 0;
    right: -250px; /* Change left to right */
    width: 250px;
    height: 100vh;
    background: #01554f;
    flex-direction: column;
    padding: 70px 40px 0;
    transition: right 0.2s ease; /* Change left to right */
    z-index: 1020; /* Even higher to ensure visibility over other content */
  }
  
  header.show-mobile-menu .navbar .menu-links {
    right: 0; /* Change left to right */
  }
  
  .navbar .menu-links span {
    display: block; /* Make the menu links appear vertically */
    padding: 15px; /* Adjust padding as needed */
    text-align: center; /* Center the text */
  }

  .navbar a {
    color: white;

  }
  .navbar img{
max-width: 20%;
  }

  .hero-section .content {
    text-align: center;
  
  }

  .hero-section .content :is(h2, p) {
    max-width: 200%;
  }

  .hero-section .content h2 {
    font-size: 2.3rem;
    line-height: 60px;
   
  }
  
  .hero-section .content button {
    padding: 9px 18px;
  }

  .container{
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 10px;
    max-width: 300px;
    margin: 0 auto;
    width: 100%;
    margin-top: 130px;
  }
}
  </style>