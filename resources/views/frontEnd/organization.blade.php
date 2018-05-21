@extends('layouts.app')
@section('title')
Organization
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
    position: relative !important;
    z-index: 0 !important;
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
    
                <div class="panel ml-15 mr-15 mb-15">
                    <div class="panel-body p-20">
                        <h2>{{$organization->organization_name}} @if($organization->organization_alternate_name!='')({{$organization->organization_alternate_name}})@endif</h2>

                        @if($organization->organization_services!='')
                        <h4 class="panel-text"> 
                            @foreach($organization->service as $service)
                                {{$service->service_name}},
                            @endforeach
                        </h4>
                        @endif
                        <h4 class="panel-text"> {{$organization->organization_description}}</h4>

                        <h4 class="panel-text"><span class="badge bg-red">Website</span> {{$organization->organization_url}}</h4>

                        @if($organization->organization_phones!='')
                        <h4 class="panel-text"><span class="badge bg-red">Main Phone:</span> @foreach($organization->phone as $phone)
                           {!! $phone->phone_number !!}, 
                        @endforeach</h4>
                        @endif

                    </div>
                  </div>

                  @if($organization->organization_services!='')
                    @foreach($organization->service as $service)
                    <div class="panel content-panel">
                        <div class="panel-body p-20">
                            <h4>{{$service->taxonomy()->first()->taxonomy_name}}</h4>
                            <a class="panel-link" href="/service_{{$service->service_recordid}}">{{$service->service_name}}</a>
                            <h4>Provided by: {{$service->organization()->first()->organization_name}}</h4>
                            <h4><span class="badge bg-red">Phone:</span> @foreach($service->phone as $phone) {!! $phone->phone_number !!} @endforeach</h4>
                            <h4><span class="badge bg-blue">Address:</span>
                                @if($service->service_address!=NULL)
                                    @foreach($service->address as $address)
                                      {{ $address->address_1 }}
                                    @endforeach
                                @endif
                            </h4>
                            <h4><span class="badge bg-blue">Description:</span> {!! str_limit($service->service_description, 200) !!}</h4>
                        </div>
                    </div>
                    @endforeach
                  @endif
              
            </div>
            
            <div class="col-md-4 p-0 pr-15">
                <div id="map" style="width: 100%;"></div>
                
                @if($organization->organization_locations!='')
                  <hr>
                  @foreach($organization->location as $location)
                  <div class="panel m-0 mt-5">
                      <div class="panel-body p-20">

                          <h4><span class="badge bg-red">Location:</span> {{$location->location_name}}</h4>
                          <h4><span class="badge bg-red">Address:</span> {{$location->address()->first()->address_1}}, {{$location->address()->first()->address_city}}, {{$location->address()->first()->address_state_province}}, {{$location->address()->first()->address_postal_code}}</h4>
                          <h4><span class="badge bg-red">Phone:</span>
                             @foreach($location->phone as $phone)
                              {{$phone->phone_number}},
                             @endforeach
                          </h4>
                      </div>
                  </div>
                  @endforeach
                @endif
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
    
    var locations = <?php print_r(json_encode($locations)) ?>;
    console.log(locations);
    var show = 1;
    if(locations.length == 0){
      show = 0;
      locations[0] = {};
      locations[0].location_latitude = 40.730981;
      locations[0].location_longitude = -73.998107;
    }
    var sumlat = 0.0;
    var sumlng = 0.0;
    for(var i = 0; i < locations.length; i ++)
    {
        sumlat += parseFloat(locations[i].location_latitude);
        sumlng += parseFloat(locations[i].location_longitude);

    }
    var avglat = sumlat/locations.length;
    var avglng = sumlng/locations.length;
    var mymap = new GMaps({
      el: '#map',
      lat: avglat,
      lng: avglng,
      zoom:10
    });


    $.each( locations, function(index, value ){

        mymap.addMarker({
            lat: value.location_latitude,
            lng: value.location_longitude,
            title: value.city,
                   
            infoWindow: {
                maxWidth: 250,
                content: ('<a href="/service_'+value.service.service_recordid+'" style="color:#424242;font-weight:500;font-size:14px;">'+value.service.service_name+'</a>')
            }
        });
   });
</script>
@endsection


