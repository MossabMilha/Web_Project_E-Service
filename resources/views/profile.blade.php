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
            <br>
            <x-info-card :title="$key['title']" :data="$key['data']"/>
            <br>
        @endforeach
    </div>
@endsection

