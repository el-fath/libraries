<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Author::paginate(10);
        return view('author.index', compact('data'));
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
            'name' => ['required', 'string', 'max:255', 'unique:authors']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = Author::Create($request->all());

        return redirect()->route('authors.index', compact('data'))->with('message', "Add data for id {$data->id} success");
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:authors,name,' . $id]
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = Author::find($id);
        if ($data) {
            $data->update($request->all());
            $message = "update data for id {$data->id} success";
        } else $message = "data with id {$id} not found";

        return redirect()->route('authors.index', compact('data'))->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Author::find($id);
        if ($data) {
            if ($data->book()->count() > 0) {
                $message = "delete data failed, cause data still have relation with a book";
            } else {
                $data->delete();
                $message = "delete data for id {$id} success";
            }
        } else $message = "data with id {$id} not found";

        return redirect()->route('authors.index', compact('data'))->with('message', $message);
    }
}
