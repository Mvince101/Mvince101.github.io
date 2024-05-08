<?php
	require 'config.php';

	$grand_total = 0;
	$allItems = '';
	$items = [];

	$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
	  $grand_total += $row['total_price'];
	  $items[] = $row['ItemQty'];
	}
	$allItems = implode(', ', $items);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Checkout</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
  <link rel="stylesheet" type="text/css" href="style.css">
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
          <li><a href="order.php"><i class="fas fa-mobile-alt mr-2"></i>Products</a></li>
          <li><a href="cart.php"><i class="fas fa-shopping-cart cart-logo"></i> <span id="cart-item" class="badge badge-danger"></span></a></li>
        </ul>
        <span id="hamburger-btn" class="material-symbols-outlined">menu</span>
      </nav>
    </header>
  
  <div class="container">
      <div class="col-lg-6 px-4 pb-4" id="order">
        <h4 class="text-center text-info p-2">Complete your order!</h4>
        <div class="jumbotron p-3 mb-2 text-center">
          <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?></h6>
          <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
          <h5><b>Total Amount Payable : ₱ </b><?= number_format($grand_total,2) ?>/-</h5>
        </div>
        <form action="" method="post" id="placeOrder">
          <input type="hidden" name="products" value="<?= $allItems; ?>">
          <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Enter E-Mail" required>
          </div>
          <div class="form-group">
            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
          </div>
          <div class="form-group">
            <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
          </div>
          <h6 class="text-center lead">Select Payment Mode</h6>
          <div class="form-group">
            <select name="pmode" class="form-control">
              <option value="" selected disabled>-Select Payment Mode-</option>
              <option value="cod">Cash On Delivery</option>
              <!--<option value="netbanking">Net Banking</option>
              <option value="cards">Debit/Credit Card</option>-->
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script>
      const header = document.querySelector("header");
      const hamburgerBtn = document.querySelector("#hamburger-btn");
      const closeMenuBtn = document.querySelector("#close-menu-btn");

      hamburgerBtn.addEventListener("click", () => header.classList.toggle("show-mobile-menu"));
      closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());
    </script>
  <script type="text/javascript">
  $(document).ready(function() {


    $("#placeOrder").submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: 'action.php',
        method: 'post',
        data: $('form').serialize() + "&action=order",
        success: function(response) {
          $("#order").html(response);
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
    max-width: 500px;
    margin: 0 auto;
    width: 100%;
    margin-top: 130px;
    background-color: #fed340;
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


#close-menu-btn,
  #hamburger-btn {
    color: white;
    cursor: pointer;
  }

  #close-menu-btn {
    position: absolute;
  right: 20px;
  top: 20px;
  cursor: pointer;
    display: none;
  }

  #hamburger-btn {
    display: none;
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
  
.badge{
  position: relative;
  left: 10px;
  bottom: 10px;
  width: 10px;
  height: 10px;
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