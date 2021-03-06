<?php namespace Jamesblackwell\AB\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Experiment extends Eloquent {

    protected $fillable = ['name', 'visitors', 'engagement'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        // Set the connection based on the config.
        $this->connection = config('ab.connection');
    }

    public function goals()
    {
        return $this->hasMany('Jamesblackwell\AB\Models\Goal', 'experiment');
    }

    public function scopeActive($query)
    {
        if ($experiments = Config::get('ab.experiments'))
        {
            return $query->whereIn('name', Config::get('ab.experiments'));
        }

        return $query;
    }

}
