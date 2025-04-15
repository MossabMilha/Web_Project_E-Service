@extends('components.layout')

@section('title', 'Home')

@section('content')
    <div>
        <h1 class="text-black text-2xl">Home</h1>
    </div>
    @if(auth()->user()->role == "admin")
        <a href="{{ route('UserManagement.search') }}" class="btn">E-Core Users</a><br>
    @elseif(auth()->user()->role == "department_head")
        <a href="{{ route('department-head.professors.index') }}" class="btn">E-core Professors</a><br>
    @elseif(auth()->user()->role == "coordinator")
        <a href="{{ route('Coordinator.teachingUnits') }}" class="btn">Teaching Unit Management</a><br>
        <a href="{{ route('VacataireAccount') }}" class="btn">Vacatire Management</a><br>
        <a href="{{ route('Coordinator.ScheduleManagement') }}" class="btn">Schedule Management</a>
    @endif




@endsection
