<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Layout;
use App\Service;
use App\Organization;
use App\Taxonomy;
use App\Location;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home($value='')
    {
        $home = Page::where('name', 'Home')->first();
        $taxonomies = Taxonomy::where('taxonomy_parent_name', '=', NULL)->get();

    	return view('frontEnd.home', compact('home', 'taxonomies'));
    }

    public function about($value='')
    {
        $about = Page::where('name', 'About')->first();
        $home = Page::where('name', 'Home')->first();
        return view('frontEnd.about', compact('about', 'home'));
    }

    public function feedback($value='')
    {
        $feedback = Page::where('name', 'Feedback')->first();
        return view('frontEnd.feedback', compact('feedback'));
    }

    public function YourhomePage($value='')
    {
    	return view('home');
    }

    public function dashboard($value='')
    {
    	return view('backEnd.dashboard');
    }

    public function logviewerdashboard($value='')
    {
        return redirect('log-viewer');
    }

    public function search(Request $request)
    {
        $search = $request->input('find');

        $services= Service::with(['organization', 'taxonomy'])->where('service_name', 'like', '%'.$search.'%')->orwhere('service_description', 'like', '%'.$search.'%')->orwhereHas('organization', function ($q)  use($search){
                    $q->where('organization_name', 'like', '%'.$search.'%');
                })->orwhereHas('taxonomy', function ($q)  use($search){
                    $q->where('taxonomy_name', 'like', '%'.$search.'%');
                })->paginate(10);
        $locations = Location::with('services','organization')->get();

        // $services =Service::where('service_name',  'like', '%'.$search.'%')->get();
        return view('frontEnd.services', compact('services','locations'));
    }
}
