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
    <!-- Custome Css For This Page Only  -->
    <style>
            * {
        box-sizing: border-box;
        }

        body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        background: #f3f4f6;
        color: #111827;
        }

        /* HEADER */
        .page-header {
        padding: 24px 32px;
        background: white;
        }

        .page-header h1 {
        margin: 0 0 6px;
        font-size: 26px;
        }

        .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
        }

        /* MAIN LAYOUT */
        .content {
        display: flex;
        gap: 24px;
        padding: 24px 32px;
        height: calc(100vh - 120px);
        }

        /* SIDEBAR */
        .sidebar {
        width: 360px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        }

        /* CARDS */
        .card {
        background: white;
        padding: 16px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .card h2 {
        margin: 0 0 12px;
        font-size: 16px;
        }

        /* FILTERS */
        label {
        display: block;
        margin-top: 10px;
        font-size: 13px;
        }

        select,
        button {
        width: 100%;
        padding: 8px;
        margin-top: 6px;
        font-size: 14px;
        }

        button {
        margin-top: 14px;
        background: #e5e7eb;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        }

        /* PROJECT LIST */
        .project-list {
        flex: 1;
        overflow-y: auto;
        }

        .project-card {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        cursor: pointer;
        }

        .project-card.active {
        background: #eef2ff;
        }

        .project-card small {
        color: #6b7280;
        }

        /* STATUS TAG */
        .status {
        float: right;
        font-size: 12px;
        padding: 2px 8px;
        border-radius: 999px;
        }

        .status.Ongoing { background: #dcfce7; color: #166534; }
        .status.Delayed { background: #fee2e2; color: #991b1b; }
        .status.Planned { background: #dbeafe; color: #1e40af; }
        .status.Completed { background: #e5e7eb; color: #374151; }

        /* MAP */
        .map-wrapper {
        flex: 1;
        position: relative;
        }

        #map {
        height: 100%;
        width: 100%;
        border-radius: 16px;
        }

        /* LEGEND */
        .legend {
        position: absolute;
        top: 16px;
        right: 16px;
        background: white;
        padding: 10px;
        border-radius: 10px;
        font-size: 13px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
        }

        .planned { background: #2563eb; }
        .ongoing { background: #16a34a; }
        .delayed { background: #dc2626; }
        .completed { background: #6b7280; }
    </style>

    <body>
        <?php
            include('../../components/topNavigation.php');
        ?>
        <main>
            <!-- HEADER -->
            <section class="page-header">
                <h1>Interactive Project Map</h1>
                <p>
                Explore all government projects across Quezon City.
                Click on any project to view details.
                </p>
            </section>

            <!-- MAIN -->
            <div class="content">

                <!-- LEFT PANEL -->
                <aside class="sidebar">

                <!-- FILTERS -->
                <div class="card">
                    <h2>Filters</h2>

                    <label>Status</label>
                    <select id="statusFilter">
                    <option value="all">All Statuses</option>
                    <option value="Planned">Planned</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Delayed">Delayed</option>
                    <option value="Completed">Completed</option>
                    </select>

                    <label>Category</label>
                    <select id="categoryFilter">
                    <option value="all">All Categories</option>
                    <option value="Infrastructure">Infrastructure</option>
                    <option value="Healthcare">Healthcare</option>
                    <option value="Education">Education</option>
                    </select>

                    <button id="clearFilters">Clear Filters</button>
                </div>

                <!-- PROJECT LIST -->
                <div class="card project-list">
                    <h2>Projects (<span id="projectCount"></span>)</h2>
                    <div id="projects"></div>
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
        
        <?php
            include('../../components/footer.php');
        ?>

        <!-- Map JS -->
         <script src="/QTrace-Website/assets/js/map.js"></script>

        <!-- MapAPI -->
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhA_ByIJUv0-alQhScOplTchhamHNpN4I&callback=initMap"
            async
            defer
    ></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>
