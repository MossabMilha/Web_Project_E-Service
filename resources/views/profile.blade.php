@extends('components.layout')

@section('title', 'Profile')

@section('content')
    <style>
        div{
            margin-left: 10%;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div>
        @foreach($information as $key)
            <br><br>
            <table>
                <tr>
                    <th colspan="2">${{$key['title']}}</th>
                </tr>
                @foreach($key['data'] as $key_1 => $value_1)
                    <tr>
                        <td>{{ucfirst(str_replace('_', ' ', $key_1)) }}</td>
                        <td>{{$value_1}}</td>
                    </tr>

                @endforeach
            </table>
            <br>
        @endforeach
    </div>







@endsection

