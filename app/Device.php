<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $timestamps  = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'device';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type', 'uuid', 'added'];    

    public function events()
    {
        return $this->hasMany('App\Event');
    }    

    public function latest()
    {
        return $this->hasMany('App\LatestEvent');
    }    

    public function getLatestName($name)
    {
        return $this->latest()->where('name', '=', $name)->first();
    }  

    public static function getByUniqueId($uuid) 
    {
        return self::where('uuid', '=', $uuid)->first();
    }
}
