<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'phones';
    
	public $timestamps = false;

	public function location()
    {
        return $this->belongsTo('App\Location', 'phone_locations', 'location_recordid');
    }

    public function service()
    {
        return $this->belongsTo('App\Service', 'phone_services', 'service_recordid');
    }

    public function schedule()
    {
        return $this->belongsTo('App\Schedule', 'phone_schedule', 'schedule_recordid');
    }
}
