<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminReservationRequest;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\UpdateAdminReservationRequest;
use App\Models\Sheet;
use Carbon\CarbonImmutable;
use Tests\Feature\LaravelStations\Station19\AdminReservationTest;

class AdminReservationController extends Controller
{
    public function index()
    {
        return view('admin/reservations/index', ['reservations' => Reservation::with('sheet')->where("reservations.date", ">=", CarbonImmutable::now())->get()]);
    }

    public function create()
    {
        return view('admin.reservations.create');
    }

    public function edit($reservation_id)
    {
        return view('admin.reservations.edit', [
            "reservation" => Reservation::find($reservation_id),
            "movie_id"    => Reservation::getIdOfMovieReservated($reservation_id)
        ]);
    }

    public function store(CreateAdminReservationRequest $request)
    {
        // if (empty($request->date) || empty($request->sheet_id) || empty($request->movie_id) || empty($request->schedule_id) || empty($request->name) || empty($request->email)) {
        //     abort(400);
        // }
        if (empty($request->sheet_id) || empty($request->movie_id) || empty($request->schedule_id) || empty($request->name) || empty($request->email)) {
            abort(400);
        }

        $reservation = new Reservation();

        if ($reservation->isAlreadyExist($request)) {
            return redirect("/movies/{$request->movie_id}/schedules/{$request->schedule_id}/sheets?date={$request->date}")->with([
                "message"        => "そこはすでに予約されています",
                "movie_id"       => $request->movie_id,
                "schedule_id"    => $request->schedule_id,
                "date" => $request->date,
                "sheets" => Sheet::all()
            ]);
        }

        $reservation->storeReservation($request);

        return redirect("movies/{$request->movie_id}")->with([
            'message'   => "予約した",
        ]);
    }

    public function update($reservation_id, UpdateAdminReservationRequest $request)
    {
        // if (empty($request->date) || empty($request->sheet_id) || empty($request->movie_id) || empty($request->schedule_id) || empty($request->name) || empty($request->email)) {
        //     abort(400);
        // }
        if (empty($request->sheet_id) || empty($request->movie_id) || empty($request->schedule_id) || empty($request->name) || empty($request->email)) {
            abort(400);
        }
        Reservation::updateReservation($reservation_id, $request);

        return redirect("/admin/reservations")->with([
            'message'   => "更新した",
        ]);
    }

    public function destroy($reservation_id)
    {
        if (!Reservation::isExist($reservation_id)) {
            abort(404);
        }

        Reservation::deleteReservation($reservation_id);

        return redirect("/admin/reservations")->with([
            'message'   => "削除した",
        ]);
    }
}
