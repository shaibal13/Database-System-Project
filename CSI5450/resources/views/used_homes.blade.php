@include('.backend/main_layouts.css')

<body data-layout="vertical" data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('.backend.main_layouts.header')
        @include('.backend.main_layouts.sidebar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Used Homes List</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Homes</a></li>
                                        <li class="breadcrumb-item active">Used Homes List</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header table_header">
                                    <h4 class="card-title">List of Homes Sold More Than Once</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Floor Space</th>
                                                    <th>Floors</th>
                                                    <th>Bedrooms</th>
                                                    <th>Bathrooms</th>
                                                    <th>Street</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Sales Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($usedHomes as $home)
                                                <tr>
                                                    <td>{{ $home->FloorSpace }}</td>
                                                    <td>{{ $home->Floors }}</td>
                                                    <td>{{ $home->BedRooms }}</td>
                                                    <td>{{ $home->BathRooms }}</td>
                                                    <td>{{ $home->Street }}</td>
                                                    <td>{{ $home->City }}</td>
                                                    <td>{{ $home->State }}</td>
                                                    <td>{{ $home->SalesCount }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8">No used homes found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('.backend.main_layouts.footer_common')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
</body>
