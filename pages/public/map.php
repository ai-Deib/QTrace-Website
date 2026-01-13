<?php 
    $current_page = 'map'; 
    require('../../database/controllers/get_projectMap.php');

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Welcome to QTRACE, Quezon City's official platform for monitoring government projects and ensuring transparency."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Home</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Map Link -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Custome Css For This Page Only  -->
    <style>
        /* Map Legend Overlay */
        .map-legend { 
            position: absolute; 
            top: 20px; 
            right: 20px; 
            z-index: 1000; 
            background: white; 
            border-radius: 8px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 12px; 
            min-width: 140px;
        }
        .legend-item { 
            display: flex; 
            align-items: center; 
            font-size: 0.8rem; 
            margin-bottom: 5px; 
        }
        .dot { 
            height: 10px; 
            width: 10px; 
            border-radius: 50%; 
            display: inline-block; 
            margin-right: 10px; 
        }
        
        /*  Map  */
        #map { 
            height: 100%; 
            width: 100%; 
            border-radius: 12px; 
            z-index: 1; 
        }
        .col-md-8 { 
            position: relative; 
        }

        /* Custom Pin Styling  */
        .custom-pin { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }
        .custom-pin i { 
            font-size: 2.2rem; 
            filter: drop-shadow(0px 3px 2px rgba(0,0,0,0.3)); 
        }

        .project-list-area { 
            max-height: 400px; 
            overflow-y: auto; 
        }
        .project-item { 
            cursor: pointer; 
            padding: 10px; 
            border-bottom: 1px solid #eee; 
            transition: 0.2s; 
        }
        .project-item:hover { 
            background: #f8f9fa; 
        }
    </style>

    <body>
        <?php
            include('../../components/topNavigation.php');
        ?>
<main>
        <section class="container py-5">
            <div class="title-section mb-4">
                <h2 class="fw-bold">Interactive Project Map</h2>
                <p class="text-muted">Explore all government projects across Quezon City. Click on any project to view details.</p>
            </div>
            
            <div class="row gap-4 gap-md-0">
                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="filter-section">
                                <h6 class="fw-bold mb-3 text-secondary small">SEARCH FILTERS</h6>
                                <div class="row g-2">
                                    <div class="col-12 mb-2">
                                        <select id="statusFilter" class="form-select form-select-sm shadow-none">
                                            <option value="all">All Statuses</option>
                                            <option value="Planned">Planned</option>
                                            <option value="Ongoing">Ongoing</option>
                                            <option value="Delayed">Delayed</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <select id="categoryFilter" class="form-select form-select-sm shadow-none">
                                            <option value="all">All Categories</option>
                                            <option value="Road">Roads</option>
                                            <option value="School">Education</option>
                                            <option value="Health">Healthcare</option>
                                            <option value="Drainage">Drainage</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button id="clearFilters" class="btn btn-light btn-sm w-100 border fw-bold text-muted">Clear All</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light px-3 py-2 border rounded-top d-flex justify-content-between align-items-center">
                        <span class="small fw-bold text-uppercase text-secondary">Projects Found</span>
                        <span id="projectCount" class="badge bg-primary rounded-pill">0</span>
                    </div>
                    <div id="projectList" class="project-list-area border border-top-0 rounded-bottom bg-white">
                        </div>
                </div>

                <div class="col-md-8">
                    <div id="map" class="shadow-sm"></div>
                    <div class="map-legend">
                        <h6 class="fw-bold small border-bottom pb-2 mb-2">Status Key</h6>
                        <div class="legend-item"><span class="dot bg-primary"></span> Planned</div>
                        <div class="legend-item"><span class="dot bg-success"></span> Ongoing</div>
                        <div class="legend-item"><span class="dot bg-danger"></span> Delayed</div>
                        <div class="legend-item"><span class="dot bg-secondary"></span> Completed</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

        
        <?php
            include('../../components/footer.php');
        ?>

        <!-- Custome Script For This Page Only  -->     
        <script>
            const projects = <?php echo json_encode($projects); ?>;
        </script>

        <!-- Map Link -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <!-- Reusable Script -->
        <script src="/QTrace-Website/assets/js/map.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        
    </body>
</html>
