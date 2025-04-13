@extends('components.layout')

@section('title', 'Home')

@section('content')
    <div>
        <h1 class="text-black text-2xl">Home</h1>
    </div>

    @if(auth()->user()->role == "coordinator")
        <a href="{{ route('Coordinator.teachingUnits') }}" class="btn">Teaching Unit Management</a><br>
        <a href="{{ route('VacataireAccount') }}" class="btn">Vacatire Management</a><br>
        <a href="{{ route('Coordinator.ScheduleManagement') }}" class="btn">Schedule Management</a>
    @endif
@endsection
