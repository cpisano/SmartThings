<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LatestEvent extends Model
{
    public $timestamps  = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'latest_event';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['device_id', 'name', 'value', 'unit', 'date'];    

    public function events()
    {
        return $this->hasMany('App\Event');
    }    
}
