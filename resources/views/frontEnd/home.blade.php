@extends('layouts.app')
@section('title')
Home
@stop
<style>
   .navbar-container.container-fluid{
        display: none !important;
    }
    @media (max-width: 991px){
        .page {
            padding-top: 0px !important;
        }
    }
    .pac-logo:after{
      display: none;
    }
    ul#tree1 {
        column-count: 2;
    }
</style>
<link href="{{asset('css/treeview.css')}}" rel="stylesheet">
@section('content')

    <div class="row pt-20 pl-15" style="margin-right: 0">
        <div class="col-xl-7 col-md-7">
          <!-- Panel -->
          <div class="panel mb-10">
            <div class="panel-heading text-center">
                <h1 class="panel-title" style="font-size: 25px;">I need ..</h1>
            </div>
            <div class="panel-body text-center">
                <form action="/find" method="POST" class="hidden-sm hidden-xs col-md-6 col-md-offset-3" style="display: block !important; padding-bottom: 30px;padding: 5px; ">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-icon right text-white"><a href=""><i class="fa fa-search"></i></a><input type="text" placeholder="Search here..." class="form-control text-black" name="find"/></div>
                </form>
            </div>
          </div>
          <!-- End Panel -->
          <div class="panel panel-bordered animation-scale-up">
            <div class="panel-heading text-center">
                <h3 class="panel-title" style="font-size: 25px;">Browse by Category</h3>
            </div>
            <div class="panel-body">
                <ul id="tree1">
                    @foreach($taxonomies as $taxonomy)
                        <li>
                            <a href="category_{{$taxonomy->taxonomy_recordid}}">{{$taxonomy->taxonomy_name}}</a>
                            @if(count($taxonomy->childs))
                                @include('frontLayout.manageChild',['childs' => $taxonomy->childs])
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-5">
          <!-- Panel -->
            <div class="panel">
                <div class="panel-body bg-custom">
                    <div class="form-group">
                        <h4 class="text-white">Find Services Near an Address?</h4>
                        <form method="get" action="/explore">
                          <div class="form-group">
                              
                                <div class="input-search">
                                    <i class="input-search-icon md-search" aria-hidden="true"></i>
                                    <input id="location" type="text" class="form-control text-black" name="address" placeholder="Search Address" style="border-radius:0;">
                                </div>
                              
                          </div>
                          <button type="submit" class="btn_findout"><h4 class="text-white mb-0">Search</h4></button>
                           <a href="/services_near_me" class="btn_findout pull-right"><h4 class="text-white mb-0">Services Near Me</h4></a>
                        </form>
                    </div>
                </div>
                <div class="panel-body">
                    {!! $home->body !!}
                </div>
            </div>
        </div>
          <!-- End Panel -->
    </div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="{{asset('js/treeview.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>

$(function () {
    var getData = function (request, response) {
        $.getJSON(
            "https://geosearch.planninglabs.nyc/v1/autocomplete?text=" + request.term,
            function (data) {
                response(data.features);
                
                var label = new Object();
                for(i = 0; i < data.features.length; i++)
                    label[i] = data.features[i].properties.label;
                response(label);
            });
    };
 
    var selectItem = function (event, ui) {
        $("#location").val(ui.item.value);
        return false;
    }
 
    $("#location").autocomplete({
        source: getData,
        select: selectItem,
        minLength: 2,
        change: function() {
            console.log(selectItem);

        }
    });
});
</script>
@endsection