<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Event extends Model
{
    public $timestamps  = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['device_id', 'name', 'value', 'unit', 'data', 'date', 'zwave', 'display'];    

    public static  function getByDeviceName($device_id, $name)
    {
    	return self::where('device_id', '=', $device_id)->where('name', '=', $name)->where('date', '>=', '2016-08-20 00:00')->orderBy('date')->get();
    }

    public static function getS($device_id, $name)
    {
		return self::select(DB::raw('DATE(DATE_SUB(date, INTERVAL 4 HOUR)) as date'), 'value')->where('device_id', '=', $device_id)->where('name', '=', $name)->where('date', '>=', '2016-08-01 00:00')
                        ->groupBy(DB::raw('DATE(DATE_SUB(date, INTERVAL 4 HOUR))'))
                        ->orderBy('date')->get()->max('value')->min('value');		    
    }

    public static function getMinMax($device_id, $name)
    {
        return DB::select('SELECT DATE(DATE_SUB(date, INTERVAL 4 HOUR)) as date, avg(value) as avg, min(value) as min, max(value) as max FROM `event`where device_id = ' . $device_id . ' and name = \'' . $name . '\' GROUP By DATE(DATE_SUB(date, INTERVAL 4 HOUR))');
    }

    // public static function getS($device_id, $name)
    // {
    //     return self::select(DB::raw('DATE(date) as date'), DB::raw('sum(value) as total'))->where('device_id', '=', $device_id)->where('name', '=', $name)->where('date', '>=', '2016-08-01 00:00')
    //                     ->groupBy(DB::raw('Date(date)'))
    //                     ->orderBy('date')->get();           
    // }

}
