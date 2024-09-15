<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
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

	<title>KoreAI</title>

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>

<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-store'></i>
			<span class="text">AdminHub</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="../admin/home.php">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
				<a href="../admin/controls.php">
					<i class='bx bxs-group'></i>
					<span class="text">User Control</span>
				</a>
			</li>
			<li>
				<a href="../admin/profile.php">
					<i class='bx bxs-user-circle'></i>
					<span class="text">Profile</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="../../forms/logout_con.php" class="logout">
					<i class='bx bxs-log-out-circle'></i>
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
			<i class='bx bx-menu'></i>
			<a href="#" class="nav-link">KoreAI</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="../admin/profile.php" class="profile">
				<img src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>User Control</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">User Control</a>
						</li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li>
							<a class="active" href="../admin/home.php">Home</a>
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

			<div class="table-data">
				<div class="todo">
					<div class="order">
						<div class="head">
							<h3>User List Approval</h3>
						</div>
						<table>
							<thead>
								<tr>
									<th>User ID</th>
									<th>Email</th>
									<th>Status</th>
									<th>Request Date</th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php include '../../forms/admin_controls.php'; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->


	<script src="../../assets/js/dashboard.js"></script>
</body>

</html>