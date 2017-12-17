<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        $data = 'This is my data';

        // return view('pages.index')->with('data', $data );

        // return view('pages.index', ['data'=>$data ] );

        return view('pages.index', compact('data') );
    }

    public function about() {
        return view('pages.about');
    }

    public function contact() {
        return view('pages.contact');
    }
}
