<style>
    .top-header {
            flex-shrink: 0;
            z-index: 1050;
        }

    .search-box-desktop { max-width: 450px; }
</style>
    <header class="top-header navbar navbar-dark shadow px-3 d-flex align-items-center py-3 bg-color-primary">
        <a class="navbar-brand lh-1 fw-bold d-flex align-items-center me-auto" href="#">
        <i class="bi bi-shield-check me-2"></i>
        <div >
            <span class="fs-5">QTrace</span>
            <br>
            <span class="fs-8 fw-normal">Quezon City Transparency</span>
        </div>
        </a>

        <div class="d-none d-lg-flex flex-grow-1 justify-content-center px-4">
            <div class="input-group input-group-sm search-box-desktop">
                <span class="input-group-text bg-color-surface bg-opacity-10 border-0 color-black"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-color-surface bg-opacity-10 border-0  shadow-none color-black" placeholder="Search projects...">
            </div>
        </div>

        <div class="d-flex align-items-center">
            <!-- <div class="dropdown d-none d-lg-block">
                <button class="btn btn-link text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-5 me-1"></i> Admin
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </div> -->
            
            <button class="navbar-toggler d-lg-none border-0 ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </header>