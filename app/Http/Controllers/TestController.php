<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    private $database;

    public function __construct()
    {
        $this->database = \App\Services\FirebaseService::connect();

    }

    public function index() 
    {
        $test = $this->database->getReference('test/blogs')->getValue();

        return view('welcome',compact('test'));

    }

    public function create(){
        return view('create');
    }

    public function store(Request $request) 
    {
        $this->database
            ->getReference('test/blogs/' . $request['title'])
            ->set([
                'title' => $request['title'] ,
                'content' => $request['content']
            ]);

        return redirect('/');
    }

    public function edit(Request $request) 
    {
        $this->database->getReference('test/blogs/' . $request['title'])
            ->update([
                'content/' => $request['content']
            ]);

        return response()->json('blog has been edited');
    }

    public function delete(Request $request)
    {
        $this->database
            ->getReference('test/blogs/' . $request['title'])
            ->remove();

        return redirect('/');
    }

}
