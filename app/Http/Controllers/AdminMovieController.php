<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('movies/index', ['movies' => $movies]);
    }

    public function create()
    {
        $movies = Movie::all();
        return view('admin/movies/create', ['movies' => $movies]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                "title" => 'required|unique:movies,title',
                "image_url" => 'required|url',
                "published_year" => 'required|numeric',
                "is_showing" => 'required',
                "description" => 'required',
            ]
        );

        $newMovie = Movie::create([
            "title" => $validate['title'],
            "image_url" => $request->image_url,
            "published_year" => $request->published_year,
            "is_showing" => $request->is_showing,
            "description" => $request->description,
        ]);

        return redirect("movies/index");
    }
}
