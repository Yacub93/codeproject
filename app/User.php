<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id', 'photo_id', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');

    }

    // public function checkPassword($request) {
    //     if (trim($request['password']) == '') {
    //         # if password field is empty
    //         #pass all fields except password
    //         $request = Input::except('password')
    //         $input = $request;
    //         // $input = $request->except(['password']);

    //         }else {

    //         $input = Input::all();
    //         $input['password'] = bcrypt($input['password']);

    //         }
    //     return $this->$input;
    //     } 


    //  public function setPasswordAttribute($password) {   
    //     if (!empty($password))
    //     {
    //     $this->attributes['password'] = bcrypt($password);
    //     }
    // }   

    // public function checkRole($role)
    // {
    //     #Do Validation here:

    // }

    public function isAdmin() {
        # 
        if ($this->role->name == "Administrator" && $this->is_active == 1) {
            # 
            return true;

        }

        return false;

    }

    public function posts()
    {

        return $this->hasMany('App\Post');
    }

    public function getGravatarAttribute()
    {
        # use gravatar image for user if not available use param -> mm
        $hash = md5(strtolower(trim($this->attributes['email']))) . "?d=mm";

        return "http://www.gravatar.com/avatar/$hash";
    }

}
