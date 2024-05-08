<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cart</title>
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
        <li><a href="order.php"><i class="fas fa-mobile-alt mr-2"></i>Products</a></li>
        <li><a href="checkout.php"><i class="fas fa-money-check-alt mr-2"></i>Checkout</a></li>
      </ul>
      <span id="hamburger-btn" class="material-symbols-outlined">menu</span>
    </nav>
  </header>

  <div class="container">
    <div class="row">
      <div class="col-lg-10">
        <div style="display:<?php if (isset($_SESSION['showAlert'])) { echo $_SESSION['showAlert']; } else { echo 'none'; } unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
          <button type="button" class="close" data-dismiss="alert"></button>
          <strong><?php if (isset($_SESSION['message'])) { echo $_SESSION['message']; } unset($_SESSION['showAlert']); ?></strong>
        </div>
        <div class="table-contain">
          <table class="table text-center">
            <thead>
              <tr>
                <td colspan="7">
                  <h4 class="text-center text-info m-0">Products in your cart!</h4>
                </td>
              </tr>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>
                  <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                require 'config.php';
                $stmt = $conn->prepare('SELECT * FROM cart');
                $stmt->execute();
                $result = $stmt->get_result();
                $grand_total = 0;
                while ($row = $result->fetch_assoc()):
              ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                <td><img src="<?= $row['product_image'] ?>" width="50"></td>
                <td><?= $row['product_name'] ?></td>
                <td>
                  ₱<?= number_format($row['product_price'],2); ?>
                </td>
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <td>
                  <input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style="width:75px;" readonly>
                </td>
                <td>₱<?= number_format($row['total_price'],2); ?></td>
                <td>
                  <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php $grand_total += $row['total_price']; ?>
              <?php endwhile; ?>
              <tr>
                <td colspan="3">
                  <a href="order.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                    Shopping</a>
                </td>
                <td colspan="2"><b>Grand Total</b></td>
                <td><b>₱<?= number_format($grand_total,2); ?></b></td>
                <td>
                  <a href="checkout.php" class="btn btn-info <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>

  <script>
    const header = document.querySelector("header");
    const hamburgerBtn = document.querySelector("#hamburger-btn");
    const closeMenuBtn = document.querySelector("#close-menu-btn");

    hamburgerBtn.addEventListener("click", () => header.classList.toggle("show-mobile-menu"));
    closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());
  </script>

  <script type="text/javascript">
    $(document).ready(function() {

      // Change the item quantity
      $(".itemQty").on('change', function() {
        var $el = $(this).closest('tr');

        var pid = $el.find(".pid").val();
        var pprice = $el.find(".pprice").val();
        var qty = $el.find(".itemQty").val();
        location.reload(true);
        $.ajax({
          url: 'action.php',
          method: 'post',
          cache: false,
          data: {
            qty: qty,
            pid: pid,
            pprice: pprice
          },
          success: function(response) {
            console.log(response);
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

  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 10px;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
    margin-top: 130px;
  }

  .card {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    background-color: #01554f;
  }

  .nav-link:hover {
    color: #fed340;
  }

  h4,
  b {
    color: black;
  }

  a {
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

  .addItemBtn {
    background-color: #fed340;
  }

  .navbar img {
    max-height: 100%;
    max-width: 6.9%;
    height: auto;
    padding: 0;
    margin: 0;
    margin-left: 40px;
  }

  table {
    border-collapse: collapse;
    width: 100%;
    border: 5px solid #01554f;
    background-color: #fed340;
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

    .table-contain {
      margin: 0 auto;
      width: 95%;
      overflow-x: auto;
    }

    tbody {
      margin: 0 auto;
      width: 95%;
      overflow-x: auto;
    }

    table {
      overflow-x: auto;
      display: block;
    }

    table thead,
    table tbody,
    table tr,
    table th,
    table td {
      display: block;
    }

    table tbody tr {
      display: flex;
      flex-direction: column;
      border: 2px solid #01554f;
      padding: 10px;
      margin-bottom: 20px;
    }

    table tbody tr:last-child {
      border-bottom: none;
    }

    table tr td,
    table thead tr th {
      flex: 1;
      text-align: center;
    }

    table tbody tr td:first-child {
      margin-bottom: 10px;
    }

    table thead {
      display: none;
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

    #hamburger-btn,
    #close-menu-btn {
      display: block;
    }

    .navbar .menu-links {
      position: fixed;
      top: 0;
      right: -250px;
      width: 250px;
      height: 100vh;
      background: #01554f;
      flex-direction: column;
      padding: 70px 40px 0;
      transition: right 0.2s ease;
      z-index: 1020;
    }

    header.show-mobile-menu .navbar .menu-links {
      right: 0;
    }

    .navbar .menu-links span {
      display: block;
      padding: 15px;
      text-align: center;
    }

    .navbar a {
      color: white;
    }

    .navbar img {
      max-width: 20%;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 0 10px;
      max-width: 100%;
      margin: 0 1rem;
      width: 100%;
      margin-top: 130px;
      overflow-x: auto;
    }
  }
</style>
