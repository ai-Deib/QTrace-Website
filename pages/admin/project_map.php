<?php
$current_page = 'projectMap';
require_once '../../database/connection/connection.php';

// Get available statuses from database
$statuses = [];
$categories = [];

// Fetch project statuses
$status_sql = "SELECT DISTINCT ps.status_name FROM project_status ps 
              INNER JOIN projects_table pt ON ps.status_id = pt.status_id 
              WHERE ps.status_name IS NOT NULL 
              ORDER BY ps.status_name ASC";
$status_result = $conn->query($status_sql);
if ($status_result->num_rows > 0) {
    while ($row = $status_result->fetch_assoc()) {
        $statuses[] = $row['status_name'];
    }
}

// Fetch project categories
$category_sql = "SELECT DISTINCT Category_Name FROM project_categories WHERE Category_Name IS NOT NULL";
$category_result = $conn->query($category_sql);
if ($category_result->num_rows > 0) {
    while ($row = $category_result->fetch_assoc()) {
        $categories[] = $row['Category_Name'];
    }
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
    <meta name="description" content="View all projects on an interactive map in the QTRACE system."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Project Map</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Map CSS -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/map.css" />
    <style>
      /* Admin-specific map styling */
      .main-view {
        padding: 0;
      }
      
      .map-admin-container {
        display: flex;
        flex-direction: column;
        height: 100%;
      }
      
      .map-header {
        padding: 24px 32px;
        background: white;
        border-bottom: 1px solid #e5e7eb;
      }
      
      .map-header h2 {
        margin: 0 0 8px;
        font-size: 24px;
        font-weight: bold;
      }
      
      .map-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
      }
      
      .map-content {
        display: flex;
        gap: 24px;
        padding: 24px 32px;
        flex: 1;
        overflow: hidden;
      }
      
      /* Override map wrapper height */
      .map-wrapper {
        height: calc(100vh - 280px);
      }
      
      .sidebar {
        width: 320px;
        max-width: 100%;
      }
      
      @media (max-width: 1024px) {
        .map-content {
          flex-direction: column;
          height: auto;
        }
        
        .sidebar {
          width: 100%;
        }
        
        .map-wrapper {
          height: 500px;
        }
      }
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
          <div class="map-admin-container">
            
            <!-- Page Header -->
            <div class="map-header">
              <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item">
                    <a href="/QTrace-Website/dashboard">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Project Map</li>
                </ol>
              </nav>
              <h2>Project Map</h2>
              <p>View and manage all projects on an interactive map of Quezon City</p>
            </div>

            <!-- Map Content -->
            <div class="map-content">

              <!-- LEFT PANEL -->
              <aside class="sidebar">

                <!-- FILTERS -->
                <div class="card">
                  <h2>Filters</h2>

                  <label>Status</label>
                  <select id="statusFilter">
                    <option value="all">All Statuses</option>
                    <?php foreach ($statuses as $status): ?>
                      <option value="<?php echo htmlspecialchars($status); ?>">
                        <?php echo htmlspecialchars($status); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>

                  <label>Category</label>
                  <select id="categoryFilter">
                    <option value="all">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                      <option value="<?php echo htmlspecialchars($category); ?>">
                        <?php echo htmlspecialchars($category); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>

                  <button id="clearFilters">Clear Filters</button>
                </div>

                <!-- PROJECT LIST -->
                <div class="card project-list">
                  <h2>Projects (<span id="projectCount">0</span>)</h2>
                  <div id="projects">
                    <div style="padding: 10px; color: #9ca3af;">Loading projects...</div>
                  </div>
                </div>

              </aside>

              <!-- MAP -->
              <main class="map-wrapper">
                <div id="map"></div>

                <!-- LEGEND -->
                <div class="legend">
                  <strong>Status Legend</strong>
                  <div><span class="dot planned"></span> Planned</div>
                  <div><span class="dot ongoing"></span> Ongoing</div>
                  <div><span class="dot delayed"></span> Delayed</div>
                  <div><span class="dot completed"></span> Completed</div>
                </div>
              </main>

            </div>
          </div>
        </main>
      </div>
    </div>
    
    <!-- Scripts -->
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
      integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="/QTrace-Website/assets/js/map.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
