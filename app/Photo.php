<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //

    public $directory = '/images/'; //photo directory

    protected $fillable = ['file'];




    public function getFileAttribute($photo)
    {
    	// Accessor - get uploaded photo:

    	return $this->directory . $photo;
    }
}
