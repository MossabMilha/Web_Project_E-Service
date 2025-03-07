@extends('components.layout')

@section('title', 'Profile')

@section('content')
    <section class="identity-section">
        <div class="img-container">
{{--            <img class="profile-img" src="{{asset('png/profile-img.jpg')}}" alt="profile image">--}}
        </div>
        <x-info-card :title="$information['student']['title']" :data="$information['student']['data']"/>
    </section>
    <section class="info-section">
        @foreach($information as $key)
            <x-info-card :title="$key['title']" :data="$key['data']"/>
        @endforeach
    </section>
@endsection
