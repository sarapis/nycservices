<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Functions\Airtable;
use App\Detail;
use App\Airtables;

class DetailController extends Controller
{

    public function airtable()
    {

        Detail::truncate();
        $airtable = new Airtable(array(
            'api_key'   => 'keyIvQZcMYmjNbtUO',
            'base'      => 'appqjWvTygtaX9eil',
        ));

        $request = $airtable->getContent( 'details' );

        do {


            $response = $request->getResponse();

            $airtable_response = json_decode( $response, TRUE );

            foreach ( $airtable_response['records'] as $record ) {

                $detail = new Detail();
                $detail->detail_recordid = $record[ 'id' ];
                $detail->detail_value = isset($record['fields']['value'])?$record['fields']['value']:null;
                $detail->detail_type = isset($record['fields']['type'])?$record['fields']['type']:null;
                $detail->detail_description= isset($record['fields']['description'])?$record['fields']['description']:null;
                $detail->detail_organizations = isset($record['fields']['organizations'])? implode(",", $record['fields']['organizations']):null;
                $detail->detail_services = isset($record['fields']['services'])? implode(",", $record['fields']['services']):null;
                $detail->detail_locations = isset($record['fields']['locations'])? implode(",", $record['fields']['locations']):null;
                $detail ->save();

            }
            
        }
        while( $request = $response->next() );

        $date = date("Y/m/d H:i:s");
        $airtable = Airtables::where('name', '=', 'Details')->first();
        $airtable->records = Detail::count();
        $airtable->syncdate = $date;
        $airtable->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = Detail::orderBy('detail_value')->get();

        return view('backEnd.tables.tb_details', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail= Detail::find($id);
        return response()->json($detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $detail = Detail::find($id);
        $detail->detail_value = $request->detail_value;
        $detail->detail_type = $request->detail_type;
        $detail->detail_description = $request->detail_description;
        $detail->flag = 'modified';
        $detail->save();

        return response()->json($detail);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
