<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $data = User::paginate(10);
        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = User::Create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
        ]);

        if ($request->role == 'admin') {
            $data->roles()->sync(1);
        }

        return redirect()->route('users.index', compact('data'))->with('message', "Add data for id {$data->id} success");
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = User::find($id);
        if ($data) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id]
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator);
            }
    
            if ($request->role == 'admin') {
                $data->roles()->sync(1);
            } else {
                $data->roles()->detach();
            }

            $data->update($request->all());

            $message = "update data for id {$data->id} success";
        } else $message = "data with id {$id} not found";

        return redirect()->route('users.index', compact('data'))->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        if ($data) {
            if ($data->roles()->where('name', '=', 'admin')->exists()) {
                $data->roles()->detach();
            }
            $data->delete();
            $message = "delete data for id {$id} success";
        } else $message = "data with id {$id} not found";

        return redirect()->route('users.index', compact('data'))->with('message', $message);
    }
}
