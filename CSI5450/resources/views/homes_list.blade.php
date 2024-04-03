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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Home filter</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('owners/addNewOwners')}}" method="post"> -->
                                     <!-- <form action="{{ isset($owner->id) ? url('owners/update/' . $owner->id) : url('owners/addNewOwners') }}" method="post"> -->
                                     <form action="{{ url('homes')}}" method="post">
   
                                     @csrf
                                     <!-- @if(isset($owner->_id))
                                        @method('PUT')
                                     @endif -->
                                     <!-- @if(isset($homes->_id))
                                        <input type="hidden" name="id" value="{{$homes->_id}}">
                                    @endif -->
                                    <div class="row">
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label font-size-13 text-muted">City</label>
                                                        <select class="form-control" data-trigger name="city"
                                                            id="choices-single-default"
                                                            placeholder="This is a search placeholder" required>
                                                            <option value="all" 
                                                            @php
                                                            if($city_select=='all' || $city_select==''){
                                                              echo 'selected';
                                                            }
                                                            
                                                            @endphp 
                                                            
                                                            
                                                            >All</option>
                                                          @foreach($cities as $city)
                                                            <option value="{{$city}}"
                                                            @php
                                                            if($city_select==$city){
                                                              echo 'selected';
                                                            }
                                                            
                                                            @endphp 
                                                            >{{$city}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label font-size-13 text-muted">Owner</label>
                                                        <select class="form-control" data-trigger name="owner"
                                                            id="choices-single-default"
                                                            placeholder="This is a search placeholder" required>
                                                            <option value="all"  @php
                                                            if($owner_select=='all' || $owner_select==''){
                                                              echo 'selected';
                                                            }
                                                            
                                                            @endphp >All</option>
                                                          @foreach($owners as $owner)
                                                            <option value="{{$owner->_id}}"  
                                                            @php
                                                            if($owner->_id==$owner_select){
                                                              echo 'selected';
                                                            } @endphp
                                                            >{{$owner->Name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label font-size-13 text-muted">Min Price</label>
                                                        <input class="form-control" type="number" step=0.01 value="{{$price==0||$price==''?0:$price }}" id="example-text-input" name="price" required>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label font-size-13 text-muted">#Bedrooms</label>
                                                        <select class="form-control" data-trigger name="no_of_bedroom"
                                                            id="choices-single-default"
                                                            placeholder="This is a search placeholder" required>
                                                            <option value="all"  @php
                                                            if($no_of_bedroom=='all' || $no_of_bedroom==''){
                                                              echo 'selected';
                                                            }
                                                            
                                                            @endphp>All</option>
                                                           
                                                            @foreach($bedrooms as $bed)
                                                            <option value="{{$bed}}" 
                                                            @php
                                                            if($bed==$no_of_bedroom){
                                                              echo 'selected';
                                                            } @endphp
                                                            >{{$bed}}</option>
                                                       @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label font-size-13 text-muted">#Bathrooms</label>
                                                        <select class="form-control" data-trigger name="no_of_bathroom"
                                                            id="choices-single-default"
                                                            placeholder="This is a search placeholder" required>
                                                            <option value="all"  @php
                                                            if($no_of_bathroom=='all' || $no_of_bathroom==''){
                                                              echo 'selected';
                                                            }
                                                            
                                                            @endphp>All</option>
                                                           
                                                           @foreach($bathrooms as $bath)p
                                                            <option value="{{$bath}}" 
                                                            @php
                                                            if($bath==$no_of_bathroom){
                                                              echo 'selected';
                                                            } @endphp
                                                            >{{$bath}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                      <div class="mb-3">
                                                      <label for="choices-single-default" class="form-label font-size-13 text-muted">Status</label>
                                                        
                                                              <select class="form-control" data-trigger name="home_status"
                                                                        id="choices-single-default"
                                                                        placeholder="This is a search placeholder" required>
                                                                        <option value="all"  @php
                                                            if($home_status=='all' || $home_status==''){
                                                              echo 'selected';
                                                            }
                                                            
                                                            @endphp >All</option>
                                                                        <option value="for_sale"  @php
                                                            if($home_status=='for_sale'){
                                                              echo 'selected';
                                                            }
                                                            
                                                            @endphp>For Sale</option>
                                                                        <option value="owned"  @php
                                                            if($home_status=='owned'){
                                                              echo 'selected';
                                                            }
                                                            
                                                            @endphp>Owned</option>
                                                                        
                                                                    </select>
                                           

                                        </div>
                                                </div>
                                                <div class="col-1 pull-right" style="margin-top: 2%;">
                                                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                                        </div>
                                    </div>
                                     
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
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
                          @php if($type == 'owned'){ @endphp
                          <th>Owner Name</th>
                          @php }else{ @endphp
                          <th>Floors</th>
                          <th>BedRooms</th>
                          <th>BathRooms</th>
                          @php } @endphp
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
                        $locationModel = new \App\Models\Location();
                        // Use the instance to call the getLocation method
                        $location_details = $locationModel->getLocation($home->LocationId);
                        //$location_details=array();
                        //$location_details=\App\Models\Location::getLocation($home->LocationId);


                        @endphp
                        <tr>
                          <td>{{ $home->HomeID }}</td>
                          <td>{{ $home->FloorSpace }}</td>
                          @php
                          if($type == 'owned'){

                          @endphp
                          <td>

                            @php
                            $ownerModel=new \App\Models\Owners();
                            $owner_details=$ownerModel->getOwners($home->OwnerId);
                            echo $owner_details->Name;

                            @endphp
                          </td>
                          @php }else{ @endphp
                          <td>{{ $home->Floors }}</td>
                          <td>{{ $home->BedRooms }}</td>
                          <td>{{ $home->BathRooms }}</td>
                          @php } @endphp
                          <td>{{ $home->LandSize }}</td>
                          <td>{{ $home->YearConstructed }}</td>
                          <td>{{ $home->Type }}</td>
                          <td>
                            @php
                            if(empty($home->Status)){echo "";}
                            elseif($home->Status == 'for_sale'){ echo "For Sale";
                            }elseif($home->Status == 'owned'){ echo "Owned";}
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
                            @if($home->Status=='for_sale')
                            <button type="button" class="btn btn-primary waves-effect waves-light add_owned" data-bs-toggle="modal" data-id="{{ $home->_id}}" data-bs-target="#add_owner_modal">Sale to owner</button>
                            @endif @if($home->Status=='owned'||$home->Status=='for_sale' ||empty($home->Status) )
                            <button type="button" class="btn btn-primary waves-effect waves-light add_sale" data-bs-toggle="modal" data-id="{{ $home->_id}}" data-bs-target="#add_sale_modal">Available For sale</button>
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
          <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" id="add_sale_modal">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Selling information</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ url('homes/addtosale') }}" method="post" id="add_sale_form">

                    @csrf
                    <!-- @if(isset($company->_id))
                                    @method('PUT')
                                @endif -->
                    <!-- @if(isset($company->_id))
                                    <input type="hidden" name="id" value="{{ $company->_id ?? '' }}">
                                @endif -->


                    <div class="mb-3 row">
                      <label for="example-text-input" class="col-md-2 col-form-label">Companies</label>
                      <div class="col-md-10">
                        <select class="form-control" data-trigger id="company_choose" placeholder="This is a placeholder" name="company" required>
                          <option value="">Select Company</option>
                          @foreach($companies as $company)
                          <option value="{{$company->_id}}">{{$company->Name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="example-text-input" class="col-md-2 col-form-label">Agents</label>
                      <div class="col-md-10">
                        <select class="form-control" id="agent_choose" placeholder="This is a placeholder" name="agent" required>
                          <option value="">Select Agent</option>
                          

                        </select>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="example-text-input" class="col-md-2 col-form-label">Price</label>
                      <div class="col-md-10">
                        <input class="form-control" min="1" step="0.01" type="number" value="" id="price" name="price" required>
                      </div>
                    </div>
                    <input type="hidden" name="home_id" id="home_id">
                    <div class="mt-4 pull-right">
                      <button type="submit" class="btn btn-primary w-md">Submit</button>
                    </div>
                  </form>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

          <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" id="add_owner_modal">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Home sale</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ url('/sale') }}" method="post" id="add_owner_form">

                    @csrf



                    <div class="mb-3 row">
                      <label for="example-text-input" class="col-md-2 col-form-label">Owner</label>
                      <div class="col-md-10">
                        <select class="form-control" data-trigger id="owner_choose" placeholder="This is a placeholder" name="owner" required>
                          <option value="">Select Owner</option>
                          @foreach($owners as $owner)
                          <option value="{{$owner->_id}}">{{$owner->Name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="example-text-input" class="col-md-2 col-form-label">Price</label>
                      <div class="col-md-10">
                        <input class="form-control" min="1" step="0.01" type="number" value="" id="price_" name="price_" required disabled>
                      </div>
                    </div>

                    <input type="hidden" name="home_id_" id="home_id_">
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
            $(document).ready(function() {
              "use strict";
              var agentSelect = document.getElementById('agent_choose');
              // Check if Choices is already initialized
              if (!agentSelect.choices) {
                var agentChoices = new Choices(agentSelect, {
                  removeItemButton: true,
                  shouldSort: false,
                });
              }

              var comSelect = document.getElementById('company_choose');
              // Check if Choices is already initialized
              if (!comSelect.choices) {
                var comChoices = new Choices(comSelect, {
                  removeItemButton: true,
                  shouldSort: false,
                });
              }

              $(".table").on("click", ".add_owned", function() {

                var iid = $(this).attr("data-id");
                $('#add_owner_form').trigger("reset");
                $('#add_owner_modal').modal('show');

                $('#home_id_').val("");
                $('#home_id_').val(iid);
                $.ajax({
                  url: "{{ route('homes.saledetails', '') }}/" + iid,
                  method: "GET",
                  dataType: "json",
                  success: function(response) {
                    // if(response.AgentId!==null && response.CompanyId!==null && response.Status=='for_sale'){
                    //Will do if got time
                    $('#price_').val(response.price);

                    //  }
                  },
                });
              });


              $(".table").on("click", ".add_sale", function() {

                var iid = $(this).attr("data-id");
                $('#add_sale_form').trigger("reset");

                $('#home_id').val("");
                $('#home_id').val(iid);

                $.ajax({
                  url: "{{ route('homes.saledetails', '') }}/" + iid,
                  method: "GET",
                  dataType: "json",
                  success: function(response) {
                    if (response.AgentId !== null && response.CompanyId !== null && response.Status == 'for_sale') {
                      //Will do if got time
                      $('#price').val(response.price);
                      $('#add_sale_modal').modal('show');
                    }
                  },
                });

              });
              $("#company_choose").on("change", function() {
                var id = $(this).val();

                $.ajax({
                  url: "{{ route('company.getAgentDetails', '') }}/" + id,
                  method: "GET",
                  dataType: "json",
                  success: function(agentsData) {

                    agentChoices.clearChoices();
                    agentChoices.clearStore();

                    agentsData.forEach(function(agent) {
                      agentChoices.setChoices([{
                        value: agent.id,
                        label: agent.name,
                        selected: false
                      }, ], 'value', 'label', false);

                    });


                  },
                });
              });
            });
          </script>