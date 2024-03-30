
@include('.backend/main_layouts/css')
    <body data-layout="vertical" data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

        @include('.backend/main_layouts/header')
     
            <!-- ========== Left Sidebar Start ========== -->

        @include('.backend/main_layouts/sidebar')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">CSI5450</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Homes</a></li>
                                            <li class="breadcrumb-item active">Homes List</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header table_header">
                    <!-- <div class="col-lg-10"> -->
                        <div class="row">
                    <h4 class="card-title col-lg-8">@php
                          if($type=='all'){
                            echo "Homes List";
                          } elseif($type=='for_sale'){
                            echo "For Sale home list";
                          }else{
                            echo "Owned Home List";
                          }
                    @endphp</h4>
                 <!-- </div> -->
                    <div class="col-lg-4 pull-right">
                    <a href="{{ route('homes.addoredit') }}" class="btn btn-xs btn-secondary waves-effect waves-light pull-right">Add New Home</a>

                       
                        </div>
</div>
                    <!-- <p class="card-title-desc">
                      For basic styling—light padding and only horizontal
                      dividers—add the base class <code>.table</code> to any
                      <code>&lt;table&gt;</code>.
                    </p> -->
                  </div>
                  <div class="card-body ">
                    <div class="table-responsive">
                      <table class="table mb-0">
                        <!-- table mb-0-->
                      
                        <thead>
                          <tr>
                            <th>Home Id</th>
                            <th>Floor Space</th>
                            <th>Floors</th>
                            <th>BedRooms</th>
                            <th>BathRooms</th>
                            <th>Land Size</th>
                            <th>YearConstructed</th>
                            <th>Type</th>
                            <th>Status</th>
                             <th>Address</th>
                            <th>Option</th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($homes as $home)
                        @php
                        $location_details=array();
                        $location_details=\App\Models\Location::getLocation($home->LocationId);
                        
                       
                        @endphp
                        <tr>
                            <td>{{ $home->HomeID }}</td>
                            <td>{{ $home->FloorSpace }}</td>
                            <td>{{ $home->Floors }}</td>
                            <td>{{ $home->BedRooms }}</td>
                            <td>{{ $home->BathRooms }}</td>
                            <td>{{ $home->LandSize }}</td>
                            <td>{{ $home->YearConstructed }}</td>
                            <td>{{ $home->Type }}</td>
                            <td>
                            @php
                            if($home->Status == 'for_sale'){ echo "For Sale"; 
                            }else{ echo "Owned";}
                            @endphp
                            </td>
                            <td>
    {{ $location_details->Street }}
    @if (!empty($location_details->Apt))
        ,<br> Unit {{ $location_details->Apt }}
    @endif
    , {{ $location_details->City }}
    @if (!empty($location_details->Apt))
    , {{ $location_details->County }}
    @endif
   
    ,<br> {{ $location_details->State }}
    , {{ $location_details->Zip }}
</td>
                            <td> <a href="{{ route('homes.addoredit', $home->_id) }}" class="btn btn-xs btn-warning">Edit</a>
                                  <a href="{{ route('homes.add_appliances', $home->_id) }}" class="btn btn-xs btn-success">Add Appliances</a> 
                                  <!-- @if($type=='for_sale' || $home->Status=='for_sale')
                                  <a href="{{ route('homes.statuschange',['id' => $home->_id, 'status' => 'owned']) }}" class="btn btn-xs btn-warning">Moved to owner</a>
                                  @elseif($type=='owned'|| $home->Status=='owned')
                                <a href="{{ route('homes.statuschange',['id' => $home->_id, 'status' => 'for_sale']) }}" class="btn btn-xs btn-warning">Available for sale</a>
                                @endif -->
                                @if($type=='for_sale' || $home->Status=='for_sale')
                                <button type="button" class="btn btn-primary waves-effect waves-light add_owned" data-bs-toggle="modal" data-id="{{ $home->_id}}" data-bs-target=".bs-example-modal-center">Sale to owner</button>
                                @elseif($type=='owned'|| $home->Status=='owned') 
                                <button type="button" class="btn btn-primary waves-effect waves-light add_sale" data-bs-toggle="modal" data-id="{{ $home->_id}}" data-bs-target=".bs-example-modal-center">Available For sale</button>
                                @endif
                              </td>
                            <!-- Add other fields as needed -->
                        </tr>
                    @endforeach
                       
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
</div>
                        <!-- end row -->
                        <!-- end row -->
                        <!-- end page title -->
                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Center modal</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <form action="{{ url('companies/addorupdateNewCompaniesForm') }}" method="post">
   
   @csrf
   <!-- @if(isset($company->_id))
      @method('PUT')
   @endif -->
   @if(isset($company->_id))
      <input type="hidden" name="id" value="{{ $company->_id ?? '' }}">
  @endif
     
    
      <div class="mb-3 row">
          <label for="example-text-input" class="col-md-2 col-form-label">Companies</label>
          <div class="col-md-10">
          <select class="form-control" data-trigger
                          id=""
                          placeholder="This is a placeholder" name="company" multiple>
                          @foreach($companies as $company)
                          <option value="{{$company->_id}}">{{$company->Name}}</option>  
                          @endforeach
                      </select>
          </div>
      </div>
      <div class="mb-3 row">
          <label for="example-text-input" class="col-md-2 col-form-label">Price</label>
          <div class="col-md-10">
              <input class="form-control" min="1"  step="0.01" type="number" value="" id="example-text-input" name="price" required>
          </div>
      </div>
     
      <div class="mt-4 pull-right">
                          <button type="submit" class="btn btn-primary w-md">Submit</button>
      </div>
      </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

@include('.backend/main_layouts/footer_common')
     

<script>
  $(document).ready(function () {
  "use strict";

  $(".table").on("click", ".add_sale", function () {
    var iid = $(this).attr("data-id");
    alert(iid);
  });
});
                          </script>                       


                    
                        
                   