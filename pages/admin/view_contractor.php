<?php 
    $page_name = 'contractorList'; 
    require('../../database/controllers/get_view_contractor.php');
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
    <meta name="description" content="Details of a verified contractor working on Quezon City government projects."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Contractor Details</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Custome Css For This Page Only  -->
    <style>
        .profile-header { background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 40px 0; }
        .company-logo-lg { width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .doc-card:hover { background-color: #f1f8ff; transition: 0.3s; }

        .main-card { border-radius: 12px; border: none; }
        .status-pill { border-radius: 50px; padding: 4px 12px; font-size: 0.85rem; font-weight: 500; }
        .icon-box { width: 40px; height: 40px; background: #eef2ff; color: #4f46e5; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
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
                            <li class="breadcrumb-item"> <a href="/QTrace-Website/dashboard">Home</a> </li>
                            <li class="breadcrumb-item"><a href="/QTrace-Website/contractor-list?id=<?= $contractor_id ?>">Contractor List</a></li>
                            <li class="breadcrumb-item active">Contractor Details</li>
                        </ol>
                    </nav>

                    <div class="row mb-2 p-2 align-items-center">
                        <div class="col">
                            <!-- Page Header -->
                             <h2 class="fw-bold">Contractor Details</h2>
                            <p>Official details of a verified contractor working on Quezon City government projects</p>
                        </div>
                    </div>
                    
                    <div class="row g-2">
                        <div class="card border-0 shadow-sm mb-2 p-3">
                            <div class="card-body">
                                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
                                    
                                    <!-- Logo -->
                                    <img src="<?= !empty($contractor['Contractor_Logo_Path']) ? $contractor['Contractor_Logo_Path'] : 'https://via.placeholder.com/150' ?>" 
                                        class="company-logo-lg rounded-3 me-0 me-md-4 mb-3 mb-md-0" alt="Company Logo">
                                    

                                    <div class="flex-grow-1">
                                        <h1 class="fw-medium mb-1 fs-3"><?= htmlspecialchars($contractor['Contractor_Name']) ?></h1>
                                        <p class="text-muted mb-0 fs-6"><i class="bi bi-person-badge me-2"></i><?= htmlspecialchars($contractor['Owner_Name']) ?></p>
                                        <div class="mt-2">
                                            <span class="badge bg-primary px-3 py-2 rounded-pill"><?= $contractor['Years_Of_Experience'] ?> Years Experience</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Edit Button -->
                                    <div class="mt-3 mt-md-0 ms-md-3 d-flex justify-content-start justify-content-md-end">
                                        <a href="/QTrace-Website/pages/admin/edit_contractor.php?id=<?= $contractor_id ?>" class="btn btn-blue-primary btn-dark px-3 py-2 text-nowrap">
                                            Edit Profile
                                        </a>
                                    </div>
                                </div>
                            </div>

                                <div class="card border-0 main-card mb-4 ">
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-4 border-end">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-box me-3"><i class="bi bi-geo-alt-fill"></i></div>
                                                <div>
                                                    <small class="text-muted d-block small fw-bold">BUSINESS ADDRESS</small>
                                                    <span class="fw-medium fs-8 text-dark"><?php echo htmlspecialchars($contractor['Company_Address']); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 border-end">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-box me-3"><i class="bi bi-telephone-fill"></i></div>
                                                <div>
                                                    <small class="text-muted d-block small fw-bold">CONTACT NUMBER</small>
                                                    <span class="fw-medium fs-8 text-dark"><?php echo htmlspecialchars($contractor['Contact_Number']); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 border-end">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-box me-3"><i class="bi bi-envelope-fill"></i></div>
                                                <div>
                                                    <small class="text-muted d-block small fw-bold">EMAIL ADDRESS</small>
                                                    <span class="fw-medium fs-8 text-dark"><?php echo htmlspecialchars($contractor['Company_Email_Address']); ?>span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <!-- Engineer List Table -->
                        <div class="row g-4 p-2 py-3">
                            <div class="card main-card">
                                <div class="card-header bg-white border-0 p-2">
                                    <ul class="nav nav-tabs details px-4 pt-2 pb-2 gap-3 justify-content-md-start justify-content-center"
                                        id="contractorTabs">

                                        <!-- Profile Overview -->
                                        <li class="nav-item">
                                            <button class="nav-link active text-black-50 fw-medium d-flex align-items-center px-2 px-md-3"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#profile">
                                                <i class="bi bi-info-circle fs-6 fs-md-5"></i>
                                                <span class="ms-2 d-none d-md-inline">Profile Overview</span>
                                            </button>
                                        </li>

                                        <!-- Legal Documents -->
                                        <li class="nav-item">
                                            <button class="nav-link text-black-50 fw-medium d-flex align-items-center px-2 px-md-3"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#docs">
                                                <i class="bi bi-shield-check fs-6 fs-md-5"></i>
                                                <span class="ms-2 d-none d-md-inline">
                                                    Legal Documents (<?= count($documents); ?>)
                                                </span>
                                            </button>
                                        </li>

                                    </ul>
                                </div>

                                <div class="card-body p-4 tab-content">
                                    <div class="tab-pane fade show active" id="profile">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold mb-3">About the Company</h6>
                                                <p class="text-secondary"><?php echo nl2br(htmlspecialchars($contractor['Additional_Notes'] ?: 'No additional notes provided.')); ?></p>
                                                
                                                <h6 class="fw-bold mt-4 mb-3">Core Expertise</h6>
                                                <div>
                                                    <?php if(empty($expertise)): ?>
                                                        <small class="text-muted">General Construction</small>
                                                    <?php else: ?>
                                                        <?php foreach($expertise as $ex): ?>
                                                            <span class="skill-pill"><?php echo htmlspecialchars($ex['Expertise']); ?></span>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-5 ps-md-5">
                                                <h6 class="fw-bold mb-3">Certification Summary</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr><td class="text-muted">Established Experience:</td><td class="fw-bold text-end"><?php echo $contractor['Years_Of_Experience']; ?> Years</td></tr>
                                                    <tr><td class="text-muted">Registry Date:</td><td class="fw-bold text-end"><?php echo date("M d, Y", strtotime($contractor['Created_At'])); ?></td></tr>
                                                    <tr><td class="text-muted">Verification:</td><td class="fw-bold text-end text-success">Verified Contractor</td></tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="docs">
                                        <p class="text-muted mb-4 small">Below are the verified legal documents provided by this contractor for government compliance.</p>
                                        <div class="row g-3">
                                            <?php if(empty($documents)): ?>
                                                <div class="col-12 text-center py-4"><p class="text-muted">No documents uploaded.</p></div>
                                            <?php else: ?>
                                                <?php foreach($documents as $doc): ?>
                                                <div class="col-md-6">
                                                    <div class="doc-card d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-file-earmark-pdf fs-3 text-danger me-3"></i>
                                                            <div>
                                                                <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($doc['Document_Type']); ?></h6>
                                                                <small class="text-muted small">Verified Legal Copy</small>
                                                            </div>
                                                        </div>
                                                        <a href="<?php echo htmlspecialchars($doc['Document_Path']); ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3" target="_blank">View File</a>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
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
