<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
	public function index(Request $request)
	{
		$keyword = $request->input('keyword');
		$is_showing = $request->input('is_showing');
		$query = Movie::query();
		if ($is_showing != "2" && $is_showing != "") {
			$query->where('is_showing', (int)$is_showing);
		}
		if (!empty($keyword)) {
			if (!empty($keyword)) {
				$query->where('title', 'LIKE', "%{$keyword}")
					->orwhere('description', 'LIKE', "%{$keyword}");
			}
		}
		$movies = $query->paginate(20)->withQueryString();

		return view('movies/index', compact('movies', 'keyword', 'is_showing'));
	}

	public function show($id)
	{
		$movie = Movie::find($id);
		return view('movies/show', ['movie' => $movie]);
	}
}
