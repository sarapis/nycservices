<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Schedule extends Model
{
	use Sortable;

    protected $table = 'schedule';
    
	public $timestamps = false;

	public function service()
    {
        return $this->belongsTo('App\Service', 'schedule_services', 'service_recordid');
    }

	public function Location()
    {
        return $this->belongsTo('App\Location', 'schedule_locations', 'location_recordid');
    }

    public function phone()
    {
        return $this->belongsTo('App\Phone', 'schedule_x_phones', 'phone_recordid');
    }
}
