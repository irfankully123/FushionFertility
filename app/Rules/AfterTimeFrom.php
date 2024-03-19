<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AfterTimeFrom implements Rule
{


    public function passes($attribute, $value)
    {
        $index = str_replace('schedule.', '', $attribute);
        $isChecked = request()->input("schedule.$index.isChecked", false);
        $timeFrom = request()->input("schedule.$index.time_from");

        if ($isChecked && !empty($timeFrom)) {
            return strtotime($value) > strtotime($timeFrom);
        }

        return true;
    }

    public function message()
    {
        return 'incorrect time';
    }


}
