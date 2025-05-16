<x-layout title="Workload Hours">

    <x-slot:head>
        @vite([
            'resources/css/DepartmentHead/professors/workload.css',
            'resources/js/components/user-role-styling.js',
            //'resources/js/DepartmentHead/professors/workload.js',
            'resources/css/components/chips.css',
            'resources/js/components/chips.js'

        ])
    </x-slot:head>

    <x-nav/>

    <body>
    <div class="main-container">
        <div class="desktop">
            <x-table>
                <table>
                    <thead>
                    <tr>
                        <th>
                            <div class="th-wrapper">ID</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Name</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Type</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Specialization</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Assigned Hours</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Status</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($professors as $prof)
                        <tr>
                            <td>
                                <div class="td-wrapper"> {{ $prof->professor_id }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper"> {{ $prof->name }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">
                                    <div class="role"> {{ $prof->role }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="td-wrapper">
                                    {{ $prof->specialization ?? 'N/A' }}
                                </div>
                            </td>
                            <td>
                                <div class="td-wrapper">{{$prof->assigned_hours}}
                                    @if($prof->assigned_hours < $prof->min_hours)
                                        <span class="bg-red-200 text-red-600 text-xs py-0.5 px-1.5 rounded-2xl">
                                                < {{$prof->min_hours}}
                                            </span>
                                    @elseif($prof->assigned_hours > $prof->max_hours)
                                        <span class="bg-red-200 text-red-600 text-xs py-0.5 px-1.5 rounded-2xl">
                                                > {{$prof->max_hours}}
                                            </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="td-wrapper">
                                         <span class="chip" data-status="{{ strtolower($prof->status) }}">
                                             {{ $prof->status }}
                                         </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-table>
        </div>

        <div class="mobile">
            <div class="cards-grid">
                @foreach($professors as $prof)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-id">#{{ $prof->professor_id }}</div>
                            <span class="chip" data-status="{{ strtolower($prof->status) }}">
                                 {{ $prof->status }}
                             </span>
                        </div>

                        <div class="card-body">
                            <div class="info-row">
                                <span class="label">Name:</span>
                                <span class="value">{{ $prof->name }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Role:</span>
                                <span class="value"><span class="role"> {{ $prof->role }}</span></span>
                            </div>

                            <div class="info-row">
                                <span class="label">Specialization:</span>
                                <span class="value"> {{ $prof->specialization ?? 'N/A' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Assigned hours:</span>
                                <span class="value"> {{$prof->assigned_hours}}
                                    @if($prof->assigned_hours < $prof->min_hours)
                                        <span
                                            class="bg-red-200 text-red-600 text-xs py-0.5 px-1.5 rounded-2xl">< {{$prof->min_hours}}</span>
                                    @elseif($prof->assigned_hours > $prof->max_hours)
                                        <span
                                            class="bg-red-200 text-red-600 text-xs py-0.5 px-1.5 rounded-2xl">> {{$prof->max_hours}}</span>
                                    @endif
                                </span>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if ($professors->hasPages())
            <div class="pagination">
                <a href="{{ $professors->previousPageUrl() }}"
                   class="prev-btn {{ $professors->onFirstPage() ? 'disabled' : '' }}">← previous</a>
                <span class="page-info">{{ $professors->currentPage() }} | {{ $professors->lastPage() }}</span>
                <a href="{{ $professors->nextPageUrl() }}"
                   class="next-btn {{ $professors->hasMorePages() ? '' : 'disabled' }}">next →</a>
            </div>
        @endif
    </div>
    </body>

</x-layout>
