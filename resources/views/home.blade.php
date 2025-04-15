<x-layout title="Home">
{{--    here to add head element like scripts, links, metas, etc.. (inside x-slot:head)--}}
    <x-slot:head>
        @vite([
            'resources/css/components/header.css',
            'resources/js/components/user-role-styling.js'
        ])
    </x-slot:head>

{{--    here to include nav bar --}}
    <x-nav class="nav"/>

{{--    here to include content --}}
    @if(auth()->user()->role == "admin")
        {{--    here to include nav bar --}}
        <x-header :userrole="auth()->user()->role" :username="auth()->user()->name" :background_url="'png/3566.jpg'"/>
        <a href="{{ route('UserManagement.search') }}">E-Core Users</a><br>
    @elseif(auth()->user()->role == "department_head")
        <a href="{{ route('department-head.professors.index') }}">E-core Professors</a><br>
    @elseif(auth()->user()->role == "coordinator")
        <a href="{{ route('Coordinator.teachingUnits') }}">Teaching Unit Management</a><br>
        <a href="{{ route('VacataireAccount') }}">Vacatire Management</a><br>
        <a href="{{ route('Coordinator.ScheduleManagement') }}">Schedule Management</a>
    @endif
</x-layout>
