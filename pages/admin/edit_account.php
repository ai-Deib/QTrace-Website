<?php 
		$page_name = 'accountList';
		require('../../database/connection/connection.php');

		$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if ($user_id <= 0) {
				header('Location: /QTrace-Website/account-list');
				exit();
		}

		$stmt = $conn->prepare("SELECT * FROM user_table WHERE user_ID = ?");
		$stmt->bind_param("i", $user_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();
		$stmt->close();

		if (!$user) {
				die('User not found.');
		}

		include('../../database/connection/security.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- SEO -->
		<meta name="description" content="Edit an existing user in the QTRACE system."/>
		<meta name="author" content="Confractus" />
		<link rel="icon" type="image/png" sizes="16x16" href="" />
		<title>QTrace - Edit | <?= htmlspecialchars($user['user_firstName'] . ' ' . $user['user_lastName']) ?></title>
		<!-- Bootstrap CSS Link-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
		<!-- General Css Link -->
		<link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
		<!-- Custome Css For This Page Only  -->
		<style>

		</style>
	</head>
	<body>
		<div class="app-container">
        
				<?php
						// Header Include
						include('../../components/header.php');
				?>

				<div class="content-area">
						<?php
								// Sidebar Include
								include('../../components/sideNavigation.php');
						?>

				<main class="main-view">
					<div class="container-fluid">
						<nav aria-label="breadcrumb">
							<!-- Breadcrumb -->
							<ol class="breadcrumb">
								<li class="breadcrumb-item">
									<a href="/QTrace-Website/dashboard">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="/QTrace-Website/account-list">Account List</a></li>
								<li class="breadcrumb-item"><a href="/QTrace-Website/pages/admin/view_account?id=<?= htmlspecialchars($user_id) ?>">Account Details</a></li>
								<li class="breadcrumb-item active">Edit Account</li>
							</ol>
						</nav>
						<div class="row mb-2">
							<div class="col">
								<!-- Page Header -->
								<h2 class="fw-bold">Edit User</h2>
								<p>Update details for this QTRACE user</p>
							</div>
						</div>
          
						<!-- Form Section -->
						<div class="row g-3">
							<div class="col-12 card border-0 shadow-sm p-3">
								<form method="POST" action="/QTrace-Website/database/controllers/edit_account.php" enctype="multipart/form-data" >
									<input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>" />
									<div class="mb-4">
										<legend>Personal Information</legend>
										<hr class="m-1 mb-3" />
										<div class="row mb-2">
											<div class="col-md-4">
												<label class="form-label fw-medium color-black" for="firstName">First Name</label>
												<input type="text" class="form-control" name="first_name" placeholder="e.g., John" value="<?= htmlspecialchars($user['user_firstName']) ?>" required />
											</div>
											<div class="col-md-4">
												<label class="form-label fw-medium color-black" for="middleName">Middle Name</label>
												<input type="text" class="form-control" name="middle_name" placeholder="e.g., P." value="<?= htmlspecialchars($user['user_middleName'] ?? '') ?>" />
											</div>
											<div class="col-md-4">
												<label class="form-label fw-medium color-black" for="lastName">Last Name</label>
												<input type="text" class="form-control" name="last_name" placeholder="e.g., De La Cruz" value="<?= htmlspecialchars($user['user_lastName']) ?>" required />
											</div>
										</div>
										<div class="row mb-2">
											<div class="col-md-6">
												<label class="form-label fw-medium color-black" for="sex">Sex</label>
												<select class="form-select" aria-label="Default select example" name="sex" required>
													<option value="" disabled>Select Sex</option>
													<option value="male" <?= $user['user_sex'] === 'male' ? 'selected' : '' ?>>Male</option>
													<option value="female" <?= $user['user_sex'] === 'female' ? 'selected' : '' ?>>Female</option>
													<option value="other" <?= $user['user_sex'] === 'other' ? 'selected' : '' ?>>Other</option>
												</select>
											</div>
											<div class="col-md-6">
												<label class="form-label fw-medium color-black" for="birthDate">BirthDate</label>
												<input type="date" class="form-control" name="birth_date" value="<?= htmlspecialchars($user['user_birthDate']) ?>" required />
											</div>
										</div>
										<div class="row mb-2">
											<div class="col-md-12">
												<label class="form-label fw-medium color-black" for="role">Role</label>
												<select class="form-select" aria-label="Default select example" name="role" required>
													<option value="" disabled>Select Role</option>
													<option value="citizen" <?= $user['user_Role'] === 'citizen' ? 'selected' : '' ?>>citizen</option>
													<option value="admin" <?= $user['user_Role'] === 'admin' ? 'selected' : '' ?>>admin</option>
												</select>
											</div>
										</div>
										<div class="row mb-2">
											<div class="col-md-12">
												<label class="form-label fw-medium color-black" for="password">New Password</label>
												<input type="password" class="form-control" name="defaultpassword" placeholder="Leave blank to keep current password" />
												<small class="text-muted">Fill only if you need to reset the password.</small>
											</div>
										</div>
									</div>

									<div class="mb-4">
										<legend>Contact Information</legend>
										<hr class="m-1 mb-3" />
										<div class="row mb-2">
											<div class="col-md-6">
												<label class="form-label fw-medium color-black" for="contactNumber">Contact Number</label>
												<input type="number" class="form-control" name="contact_number" placeholder="+639 9999 9999" value="<?= htmlspecialchars($user['user_contactInformation']) ?>" required />
											</div>
											<div class="col-md-6">
												<label for="validationDefaultEmail" class="form-label fw-medium color-black" >Email</label >
												<div class="input-group">
													<span class="input-group-text" id="inputGroupPrepend2">@</span>
													<input type="email" class="form-control" name="email" id="validationDefaultEmail" aria-describedby="inputGroupPrepend2" placeholder="e.g., example@example.com" value="<?= htmlspecialchars($user['user_Email']) ?>" required />
												</div>
											</div>
										</div>
										<div class="row mb-2">
											<div class="col-md-12">
												<label for="validationDefault04" class="form-label fw-medium color-black" >Main Address</label>
												<textarea class="form-control" name="main_address" rows="6" placeholder="Complete main address..." required><?= htmlspecialchars($user['user_address']) ?></textarea>
											</div>
										</div>
									</div>

									<div class="row mt-4 g-3">
										<div class="col-6">
											<a class="btn btn-outline-secondary w-100 fw-medium" href="/QTrace-Website/pages/admin/view_account?id=<?= htmlspecialchars($user_id) ?>">
												Account Details
											</a>
										</div>
										<div class="col-6">
											<button class="btn bg-color-primary text-light w-100 fw-medium" type="submit">
												Update
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
    
		<!-- Custome Script For This Page Only  --> 
		<script>

		</script>
         
		<!-- Reusable Script -->
		<script src="/QTrace-Website/assets/js/mouseMovement.js"></script>

		<!-- Bootstrap JS -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
	</body>
</html>
