<header id="page-topbar" class="isvertical-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.svg" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">Shaibal</span>
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.svg" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">Shaibal</span>
                                </span>
                            </a>
                
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- Search -->
                        <!-- <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="bx bx-search"></span>
                            </div>
                        </form> -->
            
                    </div>

                    <div class="d-flex">
                        <div class="dropdown d-inline-block d-lg-none">
                            <button type="button" class="btn header-item"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-sm" data-feather="search"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                                <form class="p-2">
                                    <div class="search-box">
                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded bg-light border-0" placeholder="Search...">
                                            <i class="mdi mdi-magnify search-icon"></i>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </header>
<div class="vertical-menu">

<!-- LOGO -->
<div class="navbar-brand-box">
    <a href="index.html" class="logo logo-dark">
        <span class="logo-sm">
            <img src="assets/images/logo-sm.svg" alt="" height="22"> 
        </span>
        <span class="logo-lg">
            <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">CSI5450</span>
        </span>
    </a>

    <a href="index.html" class="logo logo-light">
        <span class="logo-lg">
            <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">CSI5450</span>
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo-sm.svg" alt="" height="22">
        </span>
    </a>
</div>

<button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
    <i class="fa fa-fw fa-bars"></i>
</button>

<div data-simplebar class="sidebar-menu-scroll">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title" data-key="t-menu">Menu</li>

            <li>
                <a href="/">
                    <i class="bx bx-tachometer icon nav-icon"></i>
                    <span class="menu-item" data-key="t-dashboards">Dashboard</span>
                    <!-- <span class="badge rounded-pill bg-success">5+</span> -->
                </a>
            </li>

            <li class="menu-title" data-key="t-applications">Applications</li>
            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="bx bx-store icon nav-icon"></i>
                    <span class="menu-item" data-key="t-ecommerce">Agent</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('agents.addoredit') }}" data-key="t-products">Add New Agent</a></li>
                    <li><a href="/agents" data-key="">Agent List</a></li>
                   
                </ul>
              
            </li>
            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="bx bx-store icon nav-icon"></i>
                    <span class="menu-item" data-key="t-ecommerce">Homes</span>
                </a>
                
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('homes.addoredit') }}" data-key="t-products">Add New Homes</a></li>
                    <li><a href="/homes" data-key="">Homes List</a></li>
                    <li><a href="/homes/forSale" data-key="">For Sale</a></li>
                    <li><a href="/homes/owned" data-key="">Owned Homes</a></li>
                    <li><a href="{{ route('homes.previousOwner') }}" data-key="t-products">Previous Owners</a></li>
                    <li><a href="{{ route('used-homes') }}" data-key="t-used-homes">Used Homes</a></li>
                    <li><a href="{{ route('homes.mostExpensiveHome') }}" data-key="t-used-homes">Most Expensive Home</a></li>
                    <!-- <li><a href="/homes/owned" data-key="">Owned Homes</a></li> -->
                    <!-- <li><a href="{{ route('homes.add_appliances') }}" data-key="t-products">New Appliances to home</a></li> -->
                   
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="bx bx-store icon nav-icon"></i>
                    <span class="menu-item" data-key="t-ecommerce">Sales</span>
                </a>
                
                <ul class="sub-menu" aria-expanded="false">
                    <!-- <li><a href="{{ route('homes.addoredit') }}" data-key="t-products">Add New Homes</a></li> -->
                    <li><a href="/salehistory" data-key="">All Sales</a></li>
                   
                    <!-- <li><a href="{{ route('homes.add_appliances') }}" data-key="t-products">New Appliances to home</a></li> -->
                   
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="bx bx-store icon nav-icon"></i>
                    <span class="menu-item" data-key="t-ecommerce">Owners</span>
                </a>
                
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('owners.addoredit') }}" data-key="t-products">Add New Owner</a></li>
                    <li><a href="/owners" data-key="">Owners List</a></li>
                    <li><a href="{{ route('owners.owners_have_homes') }}" data-key="t-products">Owners of specified home type</a></li>
                   
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="bx bx-store icon nav-icon"></i>
                    <span class="menu-item" data-key="t-ecommerce">Appliances</span>
                </a>
                
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('appliances.addoredit') }}" data-key="t-products">Add New Appliances</a></li>
                    <li><a href="/appliances" data-key="">Appliances List</a></li>
                    <li><a href="{{ route('appliances.appliances_by_maker') }}" data-key="t-products">Find home by maker</a></li>
                   
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="bx bx-store icon nav-icon"></i>
                    <span class="menu-item" data-key="t-ecommerce">Companies</span>
                </a>
                
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('companies.addoredit') }}" data-key="t-products">Add New Company</a></li>
                    <li><a href="/companies" data-key="">Companies List</a></li>
                   
                </ul>
            </li>
           
        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->
