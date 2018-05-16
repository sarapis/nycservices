@extends('layouts.app')
@section('title')
Service
@stop
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


<style type="text/css">
.table a{
    text-decoration:none !important;
    color: rgba(40,53,147,.9);
    white-space: normal;
}
.footable.breakpoint > tbody > tr > td > span.footable-toggle{
    position: absolute;
    right: 25px;
    font-size: 25px;
    color: #000000;
}
.ui-menu .ui-menu-item .ui-state-active {
    padding-left: 0 !important;
}
ul#ui-id-1 {
    width: 260px !important;
}
#map{
    position: fixed !important;
}
</style>

@section('content')
<div class="wrapper">
    @include('layouts.sidebar')
    <!-- Page Content Holder -->
    <div id="content" class="container">
        <!-- <div id="map" style="height: 30vh;"></div> -->
        <!-- Example Striped Rows -->
        <div class="row" style="margin-right: 0">
            <div class="col-md-8 pt-15 pr-0">
    
                <div class="panel ml-15 mr-15">
                    <div class="panel-body p-20">
                        <h2>{{$service->service_name}}</h2>
                        <h4 class="panel-text"><span class="badge bg-red">Alternate Name:</span> {{$service->service_alternate_name}}</h4>

                        <h4 class="panel-text"><span class="badge bg-red">Category:</span> {{$service->taxonomy()->first()->taxonomy_name}}</h4>

                        <h4 class="panel-text"><span class="badge bg-red">Organization:</span> {{$service->organization()->first()->organization_name}}</h4>

                        <h4 class="panel-text"><span class="badge bg-blue">Description:</span> {!! $service->service_description !!}</h4>

                        <h4 class="panel-text"><span class="badge bg-red">Phone:</span> @foreach($service->phone as $phone) {!! $phone->phone_number !!} @endforeach</h4>

                        <h4 class="panel-text"><span class="badge bg-blue">Url:</span> @if($service->service_url!=NULL) {{$service->service_url}} @endif</h4>

                        @if($service->service_email!=NULL) 
                        <h4 class="panel-text"><span class="badge bg-blue">Email:</span> {{$service->service_email}}</h4>
                        @endif

                        <hr>

                        <h3>Additional Info</h3>

                        <h4 class="panel-text"><span class="badge bg-blue">Application Process:</span> {!! $service->service_application_process !!}</h4>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 p-0">
                <div id="map" style="position: fixed !important;width: 28%;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        if(screen.width < 768){
          var text= $('.navbar-container').css('height');
          var height = text.slice(0, -2);
          $('.page').css('padding-top', height);
          $('#content').css('top', height);
        }
        else{
          var text= $('.navbar-container').css('height');
          var height = text.slice(0, -2);
          $('.page').css('margin-top', height);
        }
    });
</script>
<script>
    var value = <?php print_r(json_encode($location)) ?>;
    console.log(value);

    var mymap = new GMaps({
      el: '#map',
      lat: value.location_latitude,
      lng: value.location_longitude,
      zoom:13
    });

     mymap.addMarker({
      lat: value.location_latitude,
      lng: value.location_longitude,
      infoWindow: {
          maxWidth: 250,
          content: ('<span style="color:#424242;font-weight:500;font-size:14px;">'+value.organization.organization_name+'<br>'+value.address.address_1+', '+value.address.address_city+', '+value.address.address_state_province+', '+value.address.address_postal_code+'</span>')
      }
    });



</script>
@endsection


