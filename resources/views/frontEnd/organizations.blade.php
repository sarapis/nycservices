@extends('layouts.app')
@section('title')
Organizations
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
            <div class="col-md-12 pt-15 pr-0">
                @foreach($organizations as $organization)
                <div class="panel content-panel">
                    <div class="panel-body p-20">
                        <a class="panel-link" href="/organization_{{$organization->organization_recordid}}">{{$organization->organization_name}}</a>
                        <h4>Number of Services: @if($organization->organization_services!=null)
                          {{sizeof(explode(",", $organization->organization_services))}}
                            @else 0 @endif</h4>
                        <h4><span class="badge bg-blue">Description:</span> {!! str_limit($organization->organization_description, 200) !!}</h4>
                    </div>
                </div>
                @endforeach
                <div class="pagination p-20">
                    {{ $organizations->appends(\Request::except('page'))->render() }}
                </div>
            </div>
<!--             
            <div class="col-md-4 p-0">
                <div id="map" style="position: fixed !important;width: 28%;"></div>
            </div> -->
        </div>
    </div>
</div>
<script>
 $(document).ready(function () {
   
    if( address_district != ''){
    
        $('#btn-district span').html("District: "+address_district);
        $('#btn-district').show();
    };
});
</script>
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
    
    var sumlat = 0.0;
    var sumlng = 0.0;
    for(var i = 0; i < locations['data'].length; i ++)
    {
        sumlat += parseFloat(locations['data'][i].latitude);
        sumlng += parseFloat(locations['data'][i].longitude);

    }
    var avglat = sumlat/locations['data'].length;
    var avglng = sumlng/locations['data'].length;
    var mymap = new GMaps({
      el: '#map',
      lat: avglat,
      lng: avglng,
      zoom:10
    });


    $.each( locations['data'], function(index, value ){
        var icon;
        if(value.project_status_category == "Complete")
            icon = '<button type="button" class="btn btn-floating btn-success btn-xs waves-effect waves-classic mr-5" style="box-shadow:none;"><i class="icon fa-check" aria-hidden="true"></i></button>';
        else if(value.project_status_category == "Project Status Needed")
            icon = '<button type="button" class="btn btn-floating  btn-xs waves-effect waves-classic mr-5" style="box-shadow:none;"></button>';
        else if(value.project_status_category == "Not funded")
            icon = '<button type="button" class="btn btn-floating btn-danger btn-xs waves-effect waves-classic mr-5" style="box-shadow:none;"><i class="icon fa-remove" aria-hidden="true"></i></button>';
        else
            icon ='<button type="button" class="btn btn-floating btn-warning btn-xs waves-effect waves-classic mr-5" style="box-shadow:none;"><i class="icon fa-minus" aria-hidden="true"></i></button>';

        mymap.addMarker({
            lat: value.latitude,
            lng: value.longitude,
            title: value.city,
                   
            infoWindow: {
                maxWidth: 250,
                content: ('<a href="/profile/'+value.id+'" style="color:#424242;font-weight:500;font-size:14px;">'+icon+value.project_title+'</a>')
            }
        });
   });
</script>
@endsection


