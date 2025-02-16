<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Schedule;
use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Exception;
use Carbon\CarbonImmutable;

class AdminScheduleController extends Controller
{
	public function index()
	{
		$movies = Movie::all();
		return view('admin/schedules/index', ['movies' => $movies]);
	}

	public function show($id)
	{
		$schedule = Schedule::find($id);
		return view('admin/schedules/show', ['schedule' => $schedule]);
	}

	public function create($id)
	{
		$movie = Movie::find($id);
		return view('admin/schedules/create', ['movie' => $movie]);
	}

	public function store(CreateScheduleRequest $request)
	{
		$input = $request->validated();
        $data = $this->formatDateForSave($input);

        $startTime = CarbonImmutable::parse($data['start_time']);
        if (CarbonImmutable::parse($data['start_time'])->gte($data['end_time'])) {
            return redirect('admin/schedules/create')->withInput()->withErrors([
                'start_time_time' => '終了時刻より前にしてください',
                'end_time_time' => '開始時刻より後にしてください'
            ]);
        }

        if ($startTime->diffInMinutes($data['end_time']) <= 5) {
            return redirect('admin/schedules/create')->withInput()->withErrors([
                'start_time_time' => '終了時刻より6分以上前の時刻にしてください',
                'end_time_time' => '開始時刻から6分以上後の時刻にしてください'
            ]);
        }

        if ($this->hasScheduleConflict($input, $data)) {
            return redirect()
                ->route('admin/schedules/create')
                ->withInput()
                ->withErrors(['screen_id' => '指定した時間帯は既に使用されています']);
        }

        Schedule::create($data);
        session()->flash('success', 'スケジュールを保存しました');
        return redirect('admin/schedules/create');
	}

    private function formatDateForSave(array $data): array
    {
        $data['start_time'] = $data['start_time_date'] . ' ' . $data['start_time_time'];
        $data['end_time'] = $data['end_time_date'] . ' ' . $data['end_time_time'];
        return $data;
    }

	private function hasScheduleConflict(array $input, array $data, ?int $excludeId = null): bool
    {
        $query = Schedule::where('screen_id', $input['screen_id'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                    ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']]);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

	public function edit($id)
	{
		$schedule = Schedule::find($id);
		return view('admin/schedules/edit', ['schedule' => $schedule]);
	}

	public function update($id, UpdateScheduleRequest $request)
	{
		$input = $request->validated();
        $data = $this->formatDateForSave($input);
		$startTime = CarbonImmutable::parse($data['start_time']);
        if (CarbonImmutable::parse($data['start_time'])->gte($data['end_time'])) {
            return redirect(route('admin.schedules.edit', $data['movie_id']))->withInput()->withErrors([
                'start_time_time' => '終了時刻より前にしてください',
                'end_time_time' => '開始時刻より後にしてください'
            ]);
        }

        if ($startTime->diffInMinutes($data['end_time']) <= 5) {
            return redirect(route('admin.schedules.edit', $data['movie_id']))->withInput()->withErrors([
                'start_time_time' => '終了時刻より6分以上前の時刻にしてください',
                'end_time_time' => '開始時刻から6分以上後の時刻にしてください'
            ]);
        }

        if ($this->hasScheduleConflict($input, $data, $id)) {
            return redirect()
                ->route('admin.schedules.edit', $id)
                ->withInput()
                ->withErrors(['schedule_conflict' => '指定した時間帯は既に使用されています']);
        }

        $schedule = Schedule::findOrFail($id);
        $schedule->update($data);
      	session()->flash('success', 'スケジュールを更新しました');
        return response()->view('admin/schedules/update', ['request' => $request], 302);
	}

	public function destroy($id)
	{
		$schedule = Schedule::find($id);
		if (is_null($schedule)) {
			abort(404);
		}
		$schedule->delete();
		session()->flash('flashmessage', '映画の削除が完了しました。');
		return redirect('/admin/schedules');
	}
}
