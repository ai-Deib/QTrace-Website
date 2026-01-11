<?php $current_page = 'addProject'; ?>

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
                      <label for="contractor_id" class="form-label fw-medium color-black">Contractor</label>
                      <select class="form-select" name="Contractor_ID" id="contractor_id" required>
                        <option value="" selected disabled>Select Contractor</option>
                        <!-- Options will be populated dynamically -->
                      </select>
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="status_id" class="form-label fw-medium color-black">Status</label>
                      <select class="form-select" name="status_id" id="status_id" required>
                        <option value="" selected disabled>Select Status</option>
                        <!-- Options will be populated dynamically -->
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
                      <label for="location_id" class="form-label fw-medium color-black">Project Location</label>
                      <select class="form-select" name="location_ID" id="location_id" required>
                        <option value="" selected disabled>Select Location</option>
                        <!-- Options will be populated dynamically -->
                      </select>
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
    <script>
      // Load contractors, statuses, and locations on page load
      $(document).ready(function() {
        // Load contractors
        $.get('/QTrace-Website/database/controllers/get_contractors.php', function(data) {
          const contractors = JSON.parse(data);
          contractors.forEach(contractor => {
            $('#contractor_id').append(`<option value="${contractor.Contractor_Id}">${contractor.Contractor_Name}</option>`);
          });
        });

        // TODO: Load project statuses
        // $.get('/QTrace-Website/database/controllers/get_project_statuses.php', function(data) {
        //   const statuses = JSON.parse(data);
        //   statuses.forEach(status => {
        //     $('#status_id').append(`<option value="${status.status_id}">${status.status_name}</option>`);
        //   });
        // });

        // TODO: Load locations
        // $.get('/QTrace-Website/database/controllers/get_locations.php', function(data) {
        //   const locations = JSON.parse(data);
        //   locations.forEach(location => {
        //     $('#location_id').append(`<option value="${location.location_id}">${location.address}, ${location.barangay}</option>`);
        //   });
        // });
      });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>