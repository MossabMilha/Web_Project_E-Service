<x-layout title="professors">

    <x-slot:head>
        @vite([
        'resources/js/components/user-role-styling.js',
        'resources/css/DepartmentHead/professors/index.css',
        'resources/css/components/chips.css',
        'resources/js/components/chips.js',
        'resources/js/department-head/professors/index.js',
        ])
    </x-slot:head>

    <x-nav/>

    <div class="main-container">

        <div class="search-wrapper">
            <form class="search-form" method="GET" action="{{route('department-head.professors.search')}}">
                <div class="search-bar">
                    <input type="text" id="search" name="search" placeholder="Search">
                    <button class="submit-btn" type="submit"><img src="{{ asset('svg/search-icon.svg') }}" alt="Search Icon"></button>
                </div>
                <div class="dropdown">
                    <button type="button" id="OptionButton">Select an Option</button>
                    <div class="dropdown-content">
                        <a onclick="selectOption('id'); return false;">id</a>
                        <a onclick="selectOption('full name'); return false;">full name</a>
                        <a onclick="selectOption('email'); return false;">email</a>
                        <a onclick="selectOption('role'); return false;">role</a>
                        <a onclick="selectOption('specialization'); return false;">specialization</a>
                    </div>
                </div>
                <input type="hidden" id="selectedOption" name="option" value="{{ request('option', 'id') }}">
            </form>
        </div>


        <div class="desktop">


            <x-table>
                <table>
                    <thead>
                    <tr>
                        <th>
                            <div class="th-wrapper">User Id</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Full Name</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Email</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Role</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Specialisation</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Created At</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Updated At</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($professors as $professor)
                        <tr>
                            <td>
                                <div class="td-wrapper">{{ $professor->id }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">{{ $professor->name }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">{{ $professor->email }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">
                                    <div class="role"> {{ $professor->role }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="td-wrapper">{{ $professor->specialization }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">{{ $professor->created_at }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">{{ $professor->updated_at }}</div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-table>
        </div>

        <div class="mobile">
            <div class="cards-grid">
                @foreach($professors as $professor)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-id">#{{ $professor->id }}</div>
{{--                            <span class="chip" data-status="{{$professor->role}}">--}}
{{--                            {{ $professor->status}}--}}
{{--                            </span>--}}
                        </div>

                        <div class="card-body">
                            <div class="info-row">
                                <span class="label">Name:</span>
                                <span class="value">{{ $professor->name }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Email:</span>
                                <span class="value">{{ $professor->email }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Role:</span>
                                <span class="value"><span class="role"> {{ $professor->role }}</span></span>
                            </div>

                            <div class="info-row">
                                <span class="label">Specialization:</span>
                                <span class="value"> {{ $professor->specialization ?? 'N/A' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Created at:</span>
                                <span class="value">{{Carbon\Carbon::parse($professor->created_at)->format('j M Y, H:i') }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Updated at:</span>
                                <span class="value">{{ Carbon\Carbon::parse($professor->updated_at)->format('j M Y, H:i') }}</span>
                            </div>


                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @if ($professors->hasPages())
            <div class="pagination">
                <a href="{{ $professors->previousPageUrl() }}" class="prev-btn {{ $professors->onFirstPage() ? 'disabled' : '' }}"><
                    previous</a>
                <span class="page-info">{{ $professors->currentPage() }} | {{ $professors->lastPage() }}</span>
                <a href="{{ $professors->nextPageUrl() }}" class="next-btn {{ $professors->hasMorePages() ? '' : 'disabled' }}">next
                    ></a>
            </div>
        @endif
    </div>
</x-layout>
