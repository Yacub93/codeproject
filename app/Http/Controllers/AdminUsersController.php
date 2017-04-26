<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Role;
use App\Photo;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        //return admin/users/index view 
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::pluck('name', 'id')->all();//return array of roles

        // return $roles;//debug


        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //
       $input = $request->all();

             if (trim($request->password) == '') {
                # if password field is empty
                #pass all fields except password

                $input = $request->except('password');

            }else {

                $input = $request->all();
                $input['password'] = bcrypt($request->password);

                 }

        // User::create($request->all());

        $input = $request->all();
        // User::checkPassword($request->all());

        if ($file = $request->file('photo_id')) {
            # if photo exists get filename and move to images folder
            $photo_name = time() . $file->getClientOriginalName();

            $file->move('images', $photo_name);

            $photo = Photo::create(['file' => $photo_name]);

            $input['photo_id'] = $photo->id;
        }

        $input['password'] = bcrypt($request->password);

        User::create($input); # if photo doesn't exist create user without photo

          return redirect('/admin/users');
        // return $request->all();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('admin.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        $roles = Role::lists('name', 'id')->all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //


        $user = User::findOrFail($id);

        $input = $request->all();
        // $input = User::checkPassword($request->all());
        // $input = $user->checkPassword($input);

             if (trim($request->password) == '') {
                # if password field is empty
                #pass all fields except password

                $input = $request->except('password');

            }else {

                $input = $request->all();
                $input['password'] = bcrypt($request->password);

            }



        if ($file = $request->file('photo_id')) {
            # code...

            $photo_name = time() . $file->getClientOriginalName();

            $file->move('images', $photo_name);

            $photo = Photo::create(['file' => $photo_name]);

            $input['photo_id'] = $photo->id;

        }

        $user->update($input); //update user

          return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::findOrFail($id);

        unlink(public_path() . $user->photo->file);

        $user->delete();

        Session::flash('Deleted User', 'The user has been deleted!');

        return redirect('/admin/users');
    } 

}
