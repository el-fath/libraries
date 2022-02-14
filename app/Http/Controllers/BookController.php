<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
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
        $data['book'] = Book::with('author')->paginate(10);
        $data['author'] = Author::get();
        return view('book.index', compact('data'));
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
        $authors = Author::get();
        if($authors->count() == 0 ) {
            $message = "Please create author first before create a book";
            return redirect()->route('books.index')->with('message', $message);
        } else {
            $data = Book::Create($request->all());
            $message = "Add data for id {$data->id} success";
            return redirect()->route('books.index', compact('data'))->with('message', $message);
        }
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
        $data = Book::find($id);
        if ($data) {
            $data->update($request->all());
            $message = "update data for id {$data->id} success";
        } else $message = "data with id {$id} not found";

        return redirect()->route('books.index', compact('data'))->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Book::find($id);
        if ($data) {
            $data->delete();
            $message = "delete data for id {$id} success";
        } else $message = "data with id {$id} not found";

        return redirect()->route('books.index', compact('data'))->with('message', $message);
    }
}
