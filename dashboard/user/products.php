<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
	header('Location: ../../login.php');
	exit();
}
require_once __DIR__ . '/../../forms/db_con.php'; // Adjust the path if necessary

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT profile_picture FROM users WHERE id = ?";
$stmt = $db_con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicons -->
    <link href="../../assets/img/main_logo.png" rel="icon">

    <title>A-CHOO'S KOREAN STORE</title>
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link href="../../assets/css/profile.css" rel="stylesheet">
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-store'></i>
			<span class="text">UserHub</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="../user/home.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
				<a href="../user/products.php">
					<i class='bx bxs-cart-add'></i>
					<span class="text">Products</span>
				</a>
			</li>
            <li>
				<a href="../user/automation.php">
					<i class='bx bxs-calculator'></i>
					<span class="text">Automation</span>
				</a>
			</li>
			<li>
				<a href="../user/profile.php">
					<i class='bx bxs-user-circle'></i>
					<span class="text">Profile</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="../../forms/logout_con.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">A-CHOO'S KOREAN STORE</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="../user/profile.php" class="profile">
                <img src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Products Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="../user/home.php">Home</a>
						</li>
					</ul>
				</div>
			</div>

            <div class="message">
				<!-- Validation message section -->
				<?php
				if (session_status() == PHP_SESSION_NONE) {
					session_start(); // Start the session if it hasn't started
				}

				// Display error messages
				if (isset($_SESSION['error'])) {
					echo '<div class="error_message">' . $_SESSION['error'] . '</div>';
					unset($_SESSION['error']); // Clear the error message
				}

				// Display success messages
				if (isset($_SESSION['success'])) {
					echo '<div class="success_message">' . $_SESSION['success'] . '</div>';
					unset($_SESSION['success']); // Clear the success message
				}
				?>
			</div>

             <!-- Page content -->
             <div class="table-data">
				<div class="todo">
					<div class="order">
                        <div class="head">
                            <h3>Product List</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Product Picture</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Product Pcs</th>
                                    <th>Product QR Code</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include '../../forms/user_products.php'; ?>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>

             <div class="row">
                <div class="col-xl-8 order-xl-s">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Add Products</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <button type="button" class="btn btn-sm btn-primary" id="uploadButton">Upload Picture</button>
                                        <form id="uploadForm" method="post" action="../../forms/user_upload_products_picture.php" enctype="multipart/form-data" style="display: none;">
                                            <input type="file" id="profilePictureInput" name="p_picture" accept="image/*">
                                        </form>
                                  </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="../../forms/user_products_2.php">
                                <h6 class="heading-small text-muted mb-4">Product information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <input type="hidden" name="product_id">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label">Product Name</label>
                                                <input type="text" name="product_name" class="form-control form-control-alternative"
                                                    placeholder="Product Name" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Product Price</label>
                                                <input type="number" name="product_price" class="form-control form-control-alternative"
                                                    placeholder="Product Price" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label">Product Pcs</label>
                                                <input type="number" name="product_pcs"
                                                    class="form-control form-control-alternative" placeholder="Product Pcs" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                      </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
			     
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../../assets/js/dashboard.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('uploadButton').addEventListener('click', function() {
            document.getElementById('profilePictureInput').click();
        });

        document.getElementById('profilePictureInput').addEventListener('change', function() {
            document.getElementById('uploadForm').submit();
        });
    </script>
</body>
</html>