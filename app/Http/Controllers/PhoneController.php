<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Functions\Airtable;
use App\Phone;
use App\Airtables;

class PhoneController extends Controller
{

    public function airtable()
    {

        Phone::truncate();
        $airtable = new Airtable(array(
            'api_key'   => 'keyIvQZcMYmjNbtUO',
            'base'      => 'appqjWvTygtaX9eil',
        ));

        $request = $airtable->getContent( 'phones' );

        do {


            $response = $request->getResponse();

            $airtable_response = json_decode( $response, TRUE );

            foreach ( $airtable_response['records'] as $record ) {

                $phone = new Phone();
                $phone->phone_recordid = $record[ 'id' ];
                $phone->phone_number = isset($record['fields']['number'])?$record['fields']['number']:null;
                $phone->phone_locations = isset($record['fields']['locations'])? implode(",", $record['fields']['locations']):null;
                $phone->phone_services = isset($record['fields']['services'])? implode(",", $record['fields']['services']):null;
                $phone->phone_organizations = isset($record['fields']['organizations'])? implode(",", $record['fields']['organizations']):null;
                $phone->phone_contacts = isset($record['fields']['contacts'])? implode(",", $record['fields']['contacts']):null;
                $phone->phone_extension = isset($record['fields']['extension'])?$record['fields']['extension']:null;
                $phone->phone_type = isset($record['fields']['type'])?$record['fields']['type']:null;
                $phone->phone_language = isset($record['fields']['language'])? implode(",", $record['fields']['language']):null;
                $phone->phone_description = isset($record['fields']['description'])?$record['fields']['description']:null;
                $phone->phone_schedule = isset($record['fields']['schedule'])? implode(",", $record['fields']['schedule']):null;
                $phone ->save();

            }
            
        }
        while( $request = $response->next() );

        $date = date("Y/m/d H:i:s");
        $airtable = Airtables::where('name', '=', 'Phones')->first();
        $airtable->records = Phone::count();
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
        $phones = Phone::orderBy('phone_number')->get();

        return view('backEnd.tables.tb_phones', compact('phones'));
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
        $agency= Phone::find($id);
        return response()->json($agency);
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
        $phone = Phone::find($id);
        $phone->phone_number = $request->phone_number;
        $phone->phone_extension = $request->phone_extension;
        $phone->phone_type = $request->phone_type;
        $phone->phone_language = $request->phone_language;
        $phone->phone_description = $request->phone_description;
        $phone->flag = 'modified';
        $phone->save();

        return response()->json($phone);
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
