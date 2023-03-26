<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\Genre;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

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

	public function store(CreateMovieRequest $request)
	{
		DB::beginTransaction();
		try {
			$genre_name = $request->genre;
			if ($genre_name) {
				$is_genre_name_record = Genre::where('name', $genre_name)->first();

				if (!$is_genre_name_record) {
					$result = Genre::create([
						"name" => $genre_name
					]);
					if ($result) {
						$genre_id = $result->id;
					} else {
						return redirect()
							->route('admin.movies.create')
							->withError('ジャンルテーブルへの登録が失敗しました。');
					}
				} else {
					$genre_id = $is_genre_name_record->id;
				}
			}
			$result = Movie::create([
				"title" => $request->title,
				"image_url" => $request->image_url,
				"published_year" => $request->published_year,
				"is_showing" => $request->is_showing,
				"description" => $request->description,
				"genre_id" => $genre_id
			]);
			DB::commit();
			return redirect("movies")
				->withSuccess('データを登録しました。');
		} catch (\Throwable $e) {
			DB::rollback();
			report($e);
			abort(500);
		}
	}

	public function edit($id)
	{
		$movie = Movie::find($id);
		return view('movies/edit')->with(['movie' => $movie]);
	}

	public function update(UpdateMovieRequest $request, $id)
	{
		DB::beginTransaction();
		try {
			$genre_name = $request->genre;
			if ($genre_name) {
				$is_genre_name_record = Genre::where('name', $genre_name)->first();

				if (!$is_genre_name_record) {
					$result = Genre::create([
						"name" => $genre_name
					]);
					if ($result) {
						$genre_id = $result->id;
					}
				} else {
					$genre_id = $is_genre_name_record->id;
				}
			}
			$movie = Movie::find($id);
			$result = $movie->update([
				"title" => $request->title,
				"image_url" => $request->image_url,
				"published_year" => $request->published_year,
				"is_showing" => $request->is_showing,
				"description" => $request->description,
				"genre_id" => $genre_id
			]);
			DB::commit();
			return redirect("movies")
				->withSuccess('データを更新しました。');
		} catch (\Throwable $e) {
			DB::rollback();
			report($e);
			abort(500);
		}
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

	public function show($id)
	{
		return view('admin/movies/show', ['movie' => Movie::with('schedules')->find($id)]);
	}
}
