<?php
$current_page = 'addProject';
require_once '../../database/connection/connection.php';

// Preload contractors for server-rendered dropdown
$contractors = [];
$contractorStmt = $conn->prepare("SELECT Contractor_Id, Contractor_Name FROM contractor_table ORDER BY Contractor_Name ASC");
if ($contractorStmt) {
  $contractorStmt->execute();
  $result = $contractorStmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $contractors[] = $row;
  }
  $contractorStmt->close();
}

// Preload project statuses for server-rendered dropdown
$statuses = [];
$statusStmt = $conn->prepare("SELECT status_id, status_name FROM project_status ORDER BY status_name ASC");
if ($statusStmt) {
  $statusStmt->execute();
  $statusResult = $statusStmt->get_result();
  while ($row = $statusResult->fetch_assoc()) {
    $statuses[] = $row;
  }
  $statusStmt->close();
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Register a new project in the QTRACE system."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Add New Project</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
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
                <li class="breadcrumb-item active">Add New Project</li>
              </ol>
            </nav>
            <div class="row mb-2">
              <div class="col">
                <!-- Page Header -->
                <h2 class="fw-bold">Add New Project</h2>
                <p>Register a new project in the QTRACE system</p>
              </div>
            </div>
          
            <!-- Form Section -->
            <div class="row g-3">
              <div class="col-12 card border-0 shadow-sm p-3">
                <form method="POST" action="/QTrace-Website/database/controllers/add_projectlists.php">
                  <div class="row g-3 mb-4">
                    <legend>Project Information</legend>
                    <hr class="m-1" />
                    <div class="col-md-12 mb-4">
                      <label for="project_title" class="form-label fw-medium color-black">Project Title</label>
                      <input type="text" class="form-control" name="Project_Title" id="project_title" placeholder="e.g., Road Widening Project" required />
                    </div>
                    <div class="col-md-12 mb-4">
                      <label for="project_description" class="form-label fw-medium color-black">Project Description</label>
                      <textarea class="form-control" name="Project_Description" id="project_description" rows="4" placeholder="Describe the project details..." required></textarea>
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="contractor_id" class="form-label fw-medium color-black">Project Contractor</label>
                      <select class="form-select" name="Contractor_ID" id="contractor_id" required>
                        <option value="" selected disabled>Select Contractor</option>
                        <?php foreach ($contractors as $contractor): ?>
                          <option value="<?php echo htmlspecialchars($contractor['Contractor_Id']); ?>">
                            <?php echo htmlspecialchars($contractor['Contractor_Name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="status_id" class="form-label fw-medium color-black">Project Status</label>
                      <select class="form-select" name="status_id" id="status_id" required>
                        <option value="" selected disabled>Select Status</option>
                        <?php foreach ($statuses as $status): ?>
                          <option value="<?php echo htmlspecialchars($status['status_id']); ?>">
                            <?php echo htmlspecialchars($status['status_name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <div class="row g-3 mb-4">
                    <legend>Budget & Timeline</legend>
                    <hr class="m-1" />
                    <div class="col-md-12 mb-4">
                      <label for="project_budget" class="form-label fw-medium color-black">Project Budget</label>
                      <input type="number" step="0.01" class="form-control" name="Project_Budget" id="project_budget" placeholder="e.g., 1000000.00" required />
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="start_date" class="form-label fw-medium color-black">Start Date</label>
                      <input type="date" class="form-control" name="Project_StartedDate" id="start_date" />
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="end_date" class="form-label fw-medium color-black">End Date</label>
                      <input type="date" class="form-control" name="Project_EndDate" id="end_date" />
                    </div>
                  </div>

                  <div class="row g-3 mb-4">
                    <legend>Location</legend>
                    <hr class="m-1" />
                    <div class="col-md-12 mb-4">
                      <label for="locationPickerMap" class="form-label fw-medium color-black">Select Project Location</label>
                      <p class="text-muted small">
                        <i class="bi bi-geo-alt-fill text-primary"></i> Click existing markers to select a saved location<br>
                        <i class="bi bi-pin-map-fill text-warning"></i> Click anywhere on the map to drop a custom location pin
                      </p>
                      <div id="locationPickerMap" style="width: 100%; height: 400px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>
                      <div id="selectedLocationDisplay" class="mt-3"></div>
                      
                      <!-- Hidden fields for location -->
                      <input type="hidden" name="location_ID" id="location_id_value" />
                      <input type="hidden" id="custom_latitude" />
                      <input type="hidden" id="custom_longitude" />
                      
                      <!-- Custom Location Form (shown when user drops a pin) -->
                      <div id="customLocationForm" style="display: none;" class="mt-3 p-3 border rounded bg-light">
                        <h6 class="mb-3"><i class="bi bi-pin-map"></i> Custom Location Details</h6>
                        <div class="row g-3">
                          <div class="col-md-12">
                            <label for="custom_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="custom_address" placeholder="e.g., 123 Main Street">
                          </div>
                          <div class="col-md-6">
                            <label for="custom_barangay" class="form-label">Barangay</label>
                            <input type="text" class="form-control" id="custom_barangay" placeholder="e.g., Batasan Hills">
                          </div>
                          <div class="col-md-6">
                            <label for="custom_district" class="form-label">District Number</label>
                            <input type="number" class="form-control" id="custom_district" placeholder="e.g., 2" min="1" max="6">
                          </div>
                          <div class="col-12">
                            <button type="button" class="btn btn-warning btn-sm" onclick="saveCustomLocation()">
                              <i class="bi bi-save"></i> Save Location
                            </button>
                          </div>
                        </div>
                      </div>
                      
                      <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="clearLocationSelection()">
                        <i class="bi bi-x-circle"></i> Clear Selection
                      </button>
                    </div>
                  </div>

                  <div class="row mt-4 g-3">
                    <div class="col-6">
                      <button class="btn btn-outline-secondary w-100 fw-medium" type="reset">
                        Cancel
                      </button>
                    </div>
                    <div class="col-6">
                      <button class="btn bg-color-primary text-light w-100 fw-medium" type="submit">
                        Add Project
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
    
    <!-- Custom Script For This Page Only  --> 
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
      integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="/QTrace-Website/assets/js/location-picker.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>