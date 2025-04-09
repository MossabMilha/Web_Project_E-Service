<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--    @vite(['resources/js/department-head/teaching-units.js', 'resources/css/department-head/TeachingUnits.css'])--}}
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Professors List</title>
</head>
<body>
<div class="main-container">
    <div class="search-wrapper">
        <form class="search-form" method="GET" action="">
            <div class="search-bar">
                <input type="text" id="search" name="search" placeholder="Search">
                <button class="submit-btn" type="submit"><img src="{{ asset('svg/search-icon.svg') }}"
                                                              alt="Search Icon"></button>
            </div>
            <div class="dropdown">
                <button id="OptionButton" onclick="toggleDropdown()">Select an Option</button>
                <div class="dropdown-content">
                    <a href="#" onclick="selectOption('id')">id</a>
                    <a href="#" onclick="selectOption('name')">name</a>
                    <a href="#" onclick="selectOption('description')">description</a>
                    <a href="#" onclick="selectOption('hours')">hours</a>
                    <a href="#" onclick="selectOption('type')">type</a>
                    <a href="#" onclick="selectOption('semester')">semester</a>
                    <a href="#" onclick="selectOption('status')">status</a>
                </div>
            </div>
            <input type="hidden" id="selectedOption" name="option" value="{{ request('option', 'id') }}">
        </form>
        {{--        <form class="add-user-form" method="GET" action="{{ route('UserManagement.adduser') }}">--}}
        {{--            <button class="add-btn" type="submit">+ Add New User</button>--}}
        {{--        </form>--}}
    </div>
    <div class="table-container">
        <table>
            <tr>
                <th>User Id</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Specialisation</th>
                <th>Account Created At</th>
                <th>Last Updated</th>
                <th></th>
            </tr>

            @foreach($profsWithUnits as $data)
                <tr class="border-blue-400 border-2">
                    @php
                        $professor = $data['professor'];
                        $units = $data['units']
                    @endphp
                    <td>{{ $professor->id }}</td>
                    <td>{{ $professor->name }}</td>
                    <td>{{ $professor->email }}</td>
                    <td>{{ $professor->role }}</td>
                    <td>{{ $professor->specialization }}</td>
                    <td>{{ $professor->created_at }}</td>
                    <td>{{ $professor->updated_at }}</td>
                     link to professor profile
                    <td><a href="#">more...</a></td>
                </tr>

                @if($units->isNotEmpty())
                    @foreach($units as $unit)
                        <tr class="bg-blue-200">
                            <td>{{$unit->name}}</td>
                            <td>{{$unit->description}}</td>
                            <td></td>
                            <td>{{$unit->hours}}</td>
                            <td>{{$unit->credits}}</td>
                            <td>{{$unit->semester}}</td>
                            <td>{{$unit->status}}</td>
                            <td>
                                <form action="{{ route('department-head.professors.units.destroy', ['professor_id' => $professor->id, 'unit_id' => $unit->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
                <tr class="bg-blue-200 ">
                    <td class="flex items-center justify-center"><a class="text-blue-700 border-1" href="{{route('department-head.professors.assign', $professor->id)}}">add +</a></td>
                </tr>
            @endforeach
        </table>
    </div>
    {{--    @if ($units->hasPages())--}}
    {{--        <div class="pagination">--}}
    {{--            <a href="{{ $units->previousPageUrl() }}" class="prev-btn {{ $units->onFirstPage() ? 'disabled' : '' }}"><--}}
    {{--                previous</a>--}}
    {{--            <span class="page-info">{{ $units->currentPage() }} | {{ $units->lastPage() }}</span>--}}
    {{--            <a href="{{ $units->nextPageUrl() }}" class="next-btn {{ $units->hasMorePages() ? '' : 'disabled' }}">next--}}
    {{--                ></a>--}}
    {{--        </div>--}}
    {{--    @endif--}}
</div>
</body>
</html>
