<?php

namespace App\Imports;

use App\Models\Player;
use App\Models\User;
use App\Notifications\ImportUser;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MainSheetImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        DB::transaction(function () use($rows) {
            foreach ($rows as $row)
            {
                $password = fake()->sentence(1);

                $user = User::create([
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['email'],
                    'password' => Hash::make($password),
                    'role' => 'player',
                    'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                $player = Player::create([
                    'state' => $row['state'],
                    'dob' => Carbon::createFromFormat('d-m-Y', $row['dob'])->format('Y-m-d'),
                    'fav_playing_spot' => $row['fav_playing_spot'],
                    'specialization' => $row['specialization'],
                    'batting_hand' => $row['batting_hand'],
                    'jersey_number' => $row['jersey_number'],
                    'balling_hand' => $row['balling_hand'],
                    'balling_type' => $row['balling_type'],
                    'user_id' => $user->id
                ]);

                Notification::route('mail',$row['email'])->notify(new ImportUser($row['email'], $password));
            }
        });

    }

    public function prepareForValidation($data, $index)
    {
        if(isset($data['dob']) && !DateTime::createFromFormat('d-m-Y',$data['dob'])) {
            $data['dob'] = date_format(Date::excelToDateTimeObject($data['dob']), 'd-m-Y');
        }
        return $data;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string'
            ],
            'last_name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'email',
                'distinct',
                'unique:users,email'
            ],
            'state' => [
                'required',
                'string'
            ],
            'dob' => [
                'required',
                'date_format:d-m-Y',
                'before_or_equal:today'
            ],
            'fav_playing_spot' => [
                'required',
                'numeric',
                'min:1',
                'max:11'
            ],
            'specialization' => [
                'required',
                'string'
            ],
            'batting_hand' => [
                'required'
            ],
            'jersey_number' => [
                'required',
                'numeric',
                'min:1',
                'max:999'
            ],
            'balling_hand' => [
                'required',
                'string'
            ],
            'balling_type' => [
                'required',
                'string'
            ],
        ];
    }


}
