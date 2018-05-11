<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Location extends Model
{
	use Sortable;

    protected $table = 'locations';
    
	public $timestamps = false;

	public function organization()
    {
        return $this->belongsTo('App\Organization', 'location_organization', 'organization_recordid');
    }

    public function service()
    {
        return $this->belongsTo('App\Service', 'location_services', 'service_recordid');
    }

    public function phone()
    {
        return $this->hasmany('App\Phone', 'phone_locations', 'location_recordid');
    }

    public function detail()
    {
        return $this->hasmany('App\Detail', 'detail_locations', 'location_recordid');
    }

    public function schedule()
    {
        return $this->hasmany('App\Schedule', 'schedule_locations', 'location_recordid');
    }

    public function address()
    {
        return $this->belongsTo('App\Address', 'location_address', 'address_recordid');
    }
}
