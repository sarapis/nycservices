<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Address extends Model
{
	use Sortable;

    protected $table = 'address';
    
	public $timestamps = false;

	public function location()
    {
        return $this->belongsTo('App\Location', 'address_locations', 'location_recordid');
    }
}
