<?php 
    $page_name = 'projectList'; 
    require('../../database/controllers/get_project_details.php');
    include('../../database/connection/security.php');
    
    // Placeholder for reports count - you can replace this with a real DB count
    $report_count = 1; 
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Details of a Quezon City government project."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Project Details</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Custome Css For This Page Only  -->
    <style>
        .main-card { border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .status-pill { border-radius: 50px; padding: 4px 12px; font-size: 0.85rem; font-weight: 500; }
        .icon-box { width: 40px; height: 40px; background: #eef2ff; color: #4f46e5; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    
        /* Documents Styling */
        .doc-card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.25rem; margin-bottom: 1rem; transition: background 0.2s; }
        .doc-card:hover { background-color: #f8fafc; }
        .doc-icon { background: #e0f2fe; color: #0284c7; width: 45px; height: 45px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }

        /* Milestone/Gallery Styling */
        .gallery-card { border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; transition: transform 0.2s; }
        .gallery-card:hover { transform: translateY(-5px); }
        .gallery-img { height: 200px; object-fit: cover; width: 100%; }
        
        /* Reports Styling */
        .report-card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.5rem; }
        .official-response { background-color: #eff6ff; border-left: 4px solid #3b82f6; border-radius: 4px; padding: 1rem; margin-top: 1rem; }
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
                            <li class="breadcrumb-item"><a href="/QTrace-Website/project-list?id=<?= $project_id ?>">Project List</a></li>
                            <li class="breadcrumb-item active">Project Details</li>
                        </ol>
                    </nav>

                    <div class="row mb-2">
                        <div class="col">
                            <!-- Page Header -->
                             <h2 class="fw-bold">Project Details</h2>
                            <p>Official details of a Quezon City government project</p>
                        </div>
                    </div>
                    
                    <div class="container-fluid py-2">
                        <div class="card main-card mb-4">
                            <div class="card-body py-5 px-4">
                                <div class="row mb-3 d-flex flex-column flex-md-row align-items-start">
                                    <div class="col-md-3 d-flex justify-content-start justify-content-md-end mb-2 mb-md-0 order-1 order-md-2">
                                        <a href="/QTrace-Website/pages/admin/edit_project.php?id=<?= $project_id ?>" class="btn btn-blue-primary btn-dark px-3 py-2 text-nowrap">Edit Project</a>
                                    </div>
                                    <div class="col-md-9 order-2 order-md-1">
                                        <h3 class="fw-bold mb-3">
                                            <?php echo htmlspecialchars($project['ProjectDetails_Title']); ?>
                                        </h3>
                                        <p class="text-secondary mb-0"><?php echo htmlspecialchars($project['ProjectDetails_Description']); ?></p>
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-3 border-end">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3"><i class="bi bi-geo-alt-fill"></i></div>
                                            <div>
                                                <small class="text-muted d-block small fw-bold">LOCATION</small>
                                                <span class="fw-medium fs-8  text-dark"><?php echo htmlspecialchars($full_address); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border-end">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3"><i class="bi bi-currency-exchange"></i></div>
                                            <div>
                                                <small class="text-muted d-block small fw-bold">BUDGET</small>
                                                <span class="fw-medium fs-8  text-dark">₱<?php echo formatShorthand($project['ProjectDetails_Budget']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border-end">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3"><i class="bi bi-calendar-event"></i></div>
                                            <div>
                                                <small class="text-muted d-block small fw-bold">TIMELINE</small>
                                                <span class="fw-medium fs-8  text-dark"><?php echo date("Y-m-d", strtotime($project['ProjectDetails_StartedDate'])); ?> to <?php echo date("Y-m-d", strtotime($project['ProjectDetails_EndDate'])); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3"><i class="bi bi-grid-fill"></i></div>
                                            <div>
                                                <small class="text-muted d-block small fw-bold">CATEGORY</small>
                                                <span class="fw-medium fs-8  text-dark"><?php echo htmlspecialchars($project['Project_Category'] ?? 'N/A'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-header card bg-white border-0 p-2">
                            <ul class="nav nav-tabs details px-4 pt-2 pb-2 gap-3 justify-content-md-start justify-content-center" id="projectTabs">
                                <li class="nav-item">
                                    <button class="nav-link active text-black-50 fw-medium d-flex align-items-center px-2 px-md-3" data-bs-toggle="tab" data-bs-target="#overview">
                                    <i class="bi bi-file-text fs-6 fs-md-5"></i>
                                    <span class="ms-2 d-none d-md-inline">Overview</span>
                                    </button>
                                </li>

                                <li class="nav-item"> 
                                    <button class="nav-link text-black-50 fw-medium d-flex align-items-center px-2 px-md-3" data-bs-toggle="tab" data-bs-target="#docs">
                                    <i class="bi bi-folder2-open fs-6 fs-md-5"></i>
                                    <span class="ms-2 d-none d-md-inline"> Documents (<?= count($documents); ?>)</span>
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link text-black-50 fw-medium d-flex align-items-center px-2 px-md-3" data-bs-toggle="tab" data-bs-target="#gallery">
                                    <i class="bi bi-images fs-6 fs-md-5"></i>
                                    <span class="ms-2 d-none d-md-inline"> Photo Gallery (<?= count($milestones); ?>)</span>
                                    </button>
                                </li>

                                <li class="nav-item"> 
                                    <button class="nav-link text-black-50 fw-medium d-flex align-items-center px-2 px-md-3" data-bs-toggle="tab" data-bs-target="#reports">
                                    <i class="bi bi-chat-left-dots fs-6 fs-md-5"></i>
                                    <span class="ms-2 d-none d-md-inline"> Reports (<?= $report_count; ?>)</span>
                                    </button>
                                </li>
                            </ul>

                            <div class="card-body p-4 tab-content">
                                <div class="tab-pane fade show active" id="overview">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold mb-4">Project Details</h6>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Category:</span>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($project['Project_Category'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Status:</span>
                                                <span class="status-pill bg-success-subtle text-success">● <?php echo htmlspecialchars($project['Project_Status']); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Total Budget:</span>
                                                <span class="fw-bold">₱<?php echo number_format($project['ProjectDetails_Budget'], 2); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 border-start ps-md-5">
                                            <h6 class="fw-bold mb-4">Project Team</h6>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Contractor:</span>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($project['Contractor_Name'] ?? 'No Assigned Contractor'); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Barangay:</span>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($project['ProjectDetails_Barangay']); ?></span>
                                            </div>
                                            <a href="/QTrace-Website/view-contractor?id=<?= $project['Contractor_ID'] ?>" class="btn btn-link p-0 text-decoration-none fw-bold mt-2" style="color: var(--primary)">View Contractor Profile →</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="docs">
                                    <p class="text-muted mb-4">All public documents related to this project. Documents are updated regularly by project administrators.</p>
                                    <?php foreach ($documents as $doc): ?>
                                    <div class="doc-card d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="doc-icon me-3"><i class="bi bi-file-earmark-text"></i></div>
                                            <div>
                                                <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($doc['ProjectDocument_Type']); ?></h6>
                                                <small class="text-muted">Uploaded on <?php echo date("Y-m-d", strtotime($doc['ProjectDocument_UploadedAt'])); ?></small>
                                            </div>
                                        </div>
                                        <a href="<?php echo htmlspecialchars($doc['ProjectDocument_FileLocation']); ?>" class="btn btn-primary px-4 rounded-pill" download>
                                            <i class="bi bi-download me-2"></i>Download
                                        </a>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="tab-pane fade" id="gallery">
                                    <p class="text-muted mb-4">Visual documentation of project progress. Photos are uploaded by project engineers and administrators.</p>
                                    <div class="row g-4">
                                        <?php foreach ($milestones as $ms): ?>
                                        <div class="col-md-6">
                                            <div class="gallery-card shadow-sm h-100 bg-white">
                                                <img src="<?php echo htmlspecialchars($ms['projectMilestone_Image_Path']); ?>" class="gallery-img" alt="Milestone Photo">
                                                <div class="p-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($ms['projectMilestone_Phase']); ?></h6>
                                                        <span class="badge bg-primary-subtle text-primary rounded-pill">Ongoing</span>
                                                    </div>
                                                    <small class="text-muted">Uploaded: <?php echo date("Y-m-d", strtotime($ms['projectMilestone_UploadedAT'])); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="reports">
                                    <p class="text-muted mb-4">Citizen reports and feedback regarding this project. All verified reports receive official responses.</p>
                                    <div class="report-card bg-white shadow-sm border">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h6 class="fw-bold mb-1">Jose Ramirez</h6>
                                                <small class="text-muted">2024-12-10</small>
                                            </div>
                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3">● Under Investigation</span>
                                        </div>
                                        <p class="mb-1"><strong>Issue Type:</strong> No Progress</p>
                                        <p class="text-secondary">No construction activity observed for 5 days straight.</p>
                                        
                                        <div class="official-response">
                                            <p class="mb-1 fw-bold small text-primary">Official Response</p>
                                            <p class="mb-0 small text-dark">Team dispatched to investigate. Contractor has been contacted.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
