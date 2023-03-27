<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class CreateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'movie_id' => ['required'],
            'start_time_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:end_time_date'],
            'start_time_time' => ['required', 'date_format:H:i', 'before:end_time_time', function ($attribute, $value, $fail) {
                $end_time = $this->post('end_time_time');
                $end_time = strtotime($end_time) === false ? (string)Carbon::today()->endOfDay() : $end_time;
                $carbon_end_time = new Carbon($end_time);
                $start_time = $this->post('start_time_time');
                $start_time = strtotime($start_time) === false ? (string)Carbon::today()->startOfDay() : $start_time;
                $carbon_start_time = new Carbon($start_time);
                if ($carbon_start_time->diffInMinutes($carbon_end_time) <= 5) {
                    $fail('開始日時は終了日時より前にしてください。');
                }
            },],
            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date'],
            'end_time_time' => ['required', 'date_format:H:i', 'after:start_time_time', function ($attribute, $value = null, $fail) {
                $end_time = $this->post('end_time_time');
                $end_time = strtotime($end_time) === false ? (string)Carbon::today()->endOfDay() : $end_time;
                $carbon_end_time = new Carbon($end_time);
                $start_time = $this->post('start_time_time');
                $start_time = strtotime($start_time) === false ? (string)Carbon::today()->startOfDay() : $start_time;
                $carbon_start_time = new Carbon($start_time);
                if ($carbon_end_time->diffInMinutes($carbon_start_time) <= 5) {
                    $fail('終了日時は開始日時より後にしてください。');
                }
            },],
        ];
    }
}
