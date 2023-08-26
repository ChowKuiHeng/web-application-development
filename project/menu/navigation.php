<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <a class="navbar-brand ms-3" href="index.php">
        <img src="img/88speedmart_logo.png" alt="88 Speedmart" width="100" class="d-inline-block align-text-top" />
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end me-3" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="customerDropdown" data-bs-toggle="dropdown">
                    Customer
                </a>
                <ul class="dropdown-menu" aria-labelledby="customerDropdown">
                    <li><a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                    <li><a class="dropdown-item" href="customer_read.php">Read Customer</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="productDropdown" data-bs-toggle="dropdown">
                    Product
                </a>
                <ul class="dropdown-menu" aria-labelledby="productDropdown">
                    <li><a class="dropdown-item" href="product_create.php">Create Product</a></li>
                    <li><a class="dropdown-item" href="product_read.php">Read Product</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" data-bs-toggle="dropdown">
                    Order
                </a>
                <ul class="dropdown-menu" aria-labelledby="orderDropdown">
                    <li><a class="dropdown-item" href="order_create.php">Create Order</a></li>
                    <li><a class="dropdown-item" href="order_list_read.php">Read Order</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown">
                    Category
                </a>
                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                    <li><a class="dropdown-item" href="categories_create.php">Create Category</a></li>
                    <li><a class="dropdown-item" href="categories_read.php">Read Category</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contactus.php">Contact us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?logout=true">Logout</a>
            </li>
        </ul>
    </div>
</nav>