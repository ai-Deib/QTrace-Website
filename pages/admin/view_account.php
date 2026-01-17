<?php 
    require('../../database/connection/connection.php');

    // 1. Get ID from URL and protect against basic injection
    $user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($user_id > 0) {
        // 2. Fetch User Data
        $stmt = $conn->prepare("SELECT * FROM user_table WHERE user_ID = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            die("User not found.");
        }

        // 3. Logic for Age Calculation
        $birthDate = new DateTime($user['user_birthDate']);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
    } else {
        header("Location: account_list.php");
        exit();
    }
    
    include('../../database/connection/security.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Account - <?= htmlspecialchars($user['user_firstName']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-5 gap-3">
            <a href="list_account.php" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-sm-inline">Back to List</span>
            </a>
            <h2 class="fw-bold m-0 flex-grow-1 text-center">User Profile</h2>
            <div class="d-flex gap-2">
                <a href="/QTrace-Website/pages/admin/edit_account.php?id=<?= $user['user_ID'] ?>" class="btn btn-dark btn-sm d-flex align-items-center gap-1">
                    <i class="bi bi-pencil-square"></i>
                    <span class="d-none d-sm-inline">Edit Profile</span>
                </a>
                <button class="btn btn-primary btn-sm d-flex align-items-center gap-1" onclick="window.print()">
                    <i class="bi bi-printer"></i>
                    <span class="d-none d-sm-inline">Print</span>
                </button>
            </div>
        </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 70px; height: 70px; font-size: 28px; font-weight: bold;">
                            <?= strtoupper(substr($user['user_firstName'], 0, 1) . substr($user['user_lastName'], 0, 1)) ?>
                        </div>
                        <div class="ms-4">
                            <h4 class="mb-1 fw-bold"><?= htmlspecialchars($user['user_firstName'] . " " . $user['user_lastName']) ?></h4>
                            <span class="badge bg-info text-dark"><?= strtoupper($user['user_Role']) ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <div class="row g-5">
                        
                        <!-- Personal Information-->
                        <div class="col-md-6 border-end pe-md-4">
                            <h6 class="text-uppercase text-muted small fw-bold mb-2">Personal Details</h6>
                            <hr class="border-top">
                            
                            <div class="mb-4">
                                <label class="text-muted d-block small mb-1">QC ID Number</label>
                                <span class="fw-semibold text-primary"><?= htmlspecialchars($user['QC_ID_Number']) ?></span>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted d-block small mb-1">Sex / Gender</label>
                                <span class="fw-semibold"><?= ucfirst($user['user_sex']) ?></span>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted d-block small mb-1">Birthdate</label>
                                <span class="fw-semibold"><?= date("F d, Y", strtotime($user['user_birthDate'])) ?></span>
                                <span class="text-muted small ms-2">(<?= $age ?> years old)</span>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-6 ps-md-4">
                            <h6 class="text-uppercase text-muted small fw-bold mb-2">Contact Information</h6>
                            <hr class="border-top">

                            <div class="mb-4">
                                <label class="text-muted d-block small mb-1">Email Address</label>
                                <span class="fw-semibold"><?= htmlspecialchars($user['user_Email']) ?></span>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted d-block small mb-1">Phone Number</label>
                                <span class="fw-semibold"><?= htmlspecialchars($user['user_contactInformation']) ?></span>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted d-block small mb-1">Home Address</label>
                                <span class="fw-semibold"><?= nl2br(htmlspecialchars($user['user_address'])) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>