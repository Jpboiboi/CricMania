<table>
    <thead>
        <tr>
            {{-- <th>Row no.</th> --}}
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>State</th>
            <th>DOB</th>
            <th>Fav Playing Spot</th>
            <th>Specialization</th>
            <th>Batting Hand</th>
            <th>Jersey Number</th>
            <th>Balling Hand</th>
            <th>Balling Type</th>
            <th>Failed Columns</th>
            <th style="color: red">Error Messages</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($failuresArray as $failure)
            <tr>
                {{-- <td>{{$failure->row()}}</td> --}}
                @if (in_array('first_name', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['first_name']}}</td>
                @else
                    <td>{{$failure['values']['first_name']}}</td>
                @endif

                @if (in_array('last_name', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['last_name']}}</td>
                @else
                    <td>{{$failure['values']['last_name']}}</td>
                @endif

                @if (in_array('email', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['email']}}</td>
                @else
                    <td>{{$failure['values']['email']}}</td>
                @endif

                @if (in_array('state', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['state']}}</td>
                @else
                    <td>{{$failure['values']['state']}}</td>
                @endif

                @if (in_array('dob', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['dob']}}</td>
                @else
                    <td>{{$failure['values']['dob']}}</td>
                @endif

                @if (in_array('fav_playing_spot', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['fav_playing_spot']}}</td>
                @else
                    <td>{{$failure['values']['fav_playing_spot']}}</td>
                @endif

                @if (in_array('specialization', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['specialization']}}</td>
                @else
                    <td>{{$failure['values']['specialization']}}</td>
                @endif

                @if (in_array('batting_hand', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['batting_hand']}}</td>
                @else
                    <td>{{$failure['values']['batting_hand']}}</td>
                @endif

                @if (in_array('jersey_number', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['jersey_number']}}</td>
                @else
                    <td>{{$failure['values']['jersey_number']}}</td>
                @endif

                @if (in_array('balling_hand', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['balling_hand']}}</td>
                @else
                    <td>{{$failure['values']['balling_hand']}}</td>
                @endif

                @if (in_array('balling_type', $failure['attribute']))
                    <td style="color: red">{{$failure['values']['balling_type']}}</td>
                @else
                    <td>{{$failure['values']['balling_type']}}</td>
                @endif

                {{-- <td>{{$failure['values']['state']}}</td>
                <td>{{$failure['values']['dob']}}</td>
                <td>{{$failure['values']['fav_playing_spot']}}</td>
                <td>{{$failure['values']['specialization']}}</td>
                <td>{{$failure['values']['batting_hand']}}</td>
                <td>{{$failure['values']['jersey_number']}}</td>
                <td>{{$failure['values']['balling_hand']}}</td>
                <td>{{$failure['values']['balling_type']}}</td> --}}
                <td style="color: red">
                    <ul>
                        @foreach ($failure['attribute'] as $attribute)
                            <li>• {{ $attribute }} </li>
                        @endforeach
                    </ul>
                </td>
                <td style="color: red">
                    <ul>
                        @foreach ($failure['errors'] as $error)
                            <li>• {{ $error }}</li>
                            <li></li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
