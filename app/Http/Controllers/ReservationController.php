<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservationRequest;
use Illuminate\Http\Request;
use App\Models\Sheet;
use App\Http\Repository\ReservationRepository;

class ReservationController extends Controller
{
    public $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function index($movie_id, $schedule_id, Request $request)
    {

        if (empty($request->date)) {
            abort(400);
        }

        return view('sheets.index', [
            "movie_id"       => $movie_id,
            "schedule_id"    => $schedule_id,
            "date" => $request->date,
            "sheets"   => Sheet::all(),
            "reserved" => $this->reservationRepository->isAllreadyReserved($schedule_id)
        ]);
    }

    public function create($movie_id, $schedule_id, Request $request)
    {
        // クエリがないなら400
        if (empty($request->date) || empty($request->sheetId)) {
            abort(400);
        }

        // すでに予約されてないか
        if ($this->reservationRepository->isAllReadyExist($request->sheetId, $schedule_id)) {
            abort(400);
        }

        return view('movies.reservation', [
            "movie_id"       => $movie_id,
            "schedule_id"    => $schedule_id,
            "date" => $request->date,
            "sheet_id"        => $request->sheetId
        ]);
    }

    public function store(CreateReservationRequest $request)
    {
        // クエリがないなら400
        if (empty($request->sheet_id)) {
            abort(400);
        }
        if (empty($request->schedule_id)) {
            abort(400);
        }
        if (empty($request->date)) {
            abort(400);
        }
        // すでに予約されてないか
        if ($this->reservationRepository->isAllReadyExist($request->sheet_id, $request->schedule_id)) {
            return redirect("/movies/{$request->movie_id}/schedules/{$request->schedule_id}/sheets?date={$request->date}")->with([
                "message"        => "そこはすでに予約されています",
                "movie_id"       => $request->movie_id,
                "schedule_id"    => $request->schedule_id,
                "date" => $request->date,
                "sheets" => Sheet::all()
            ]);
        }
        $this->reservationRepository->store($request);

        return redirect("movies/{$request->movie_id}")->with([
            'message'   => "予約した",
        ]);
    }
}
