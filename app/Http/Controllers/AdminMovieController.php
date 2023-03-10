<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Exception;

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

        Movie::create([
            "title" => $validate['title'],
            "image_url" => $request->image_url,
            "published_year" => $request->published_year,
            "is_showing" => $request->is_showing,
            "description" => $request->description,
        ]);

        return redirect("movies/index");
    }

    public function edit($id)
    {
        $movie = Movie::find($id);
        return view('movies/edit')->with(['movie' => $movie]);
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                "title" => 'required|unique:movies,title',
                "image_url" => 'required|url',
                "published_year" => 'required|numeric',
                "is_showing" => 'required',
                "description" => 'required',
            ]
        );
        Movie::where('id', '=', $request->id)
            ->update([
                'title'       => $request->title,
                'image_url'   => $request->image_url,
                'description' => $request->description,
                'is_showing'  => $request->is_showing,
                'published_year' => $request->published_year,
            ]);
        return response()->view('movies/index', ['movies' => Movie::all()], 302);
    }

    public function destroy($id)
    {
        $movie = Movie::find($id);
        if (is_null($movie)) {
            abort(404);
        }
        $movie->delete();
        session()->flash('flashmessage', '映画の削除が完了しました。');
        return redirect('/admin/movies')->with(['movies' => Movie::all()]);
    }
}
