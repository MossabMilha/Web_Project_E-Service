<x-layout title="Workload Hours">

    <x-slot:head>
        @vite([
            'resources/css/DepartmentHead/professors/workload.css',
            //'resources/js/DepartmentHead/professors/workload.js',
            'resources/css/components/chips.css',
            'resources/js/components/chips.js'

        ])
    </x-slot:head>

    <x-nav/>

    <body>
    <div class="main-container">
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
                        <div class="th-wrapper">Min Hours</div>
                    </th>
                    <th>
                        <div class="th-wrapper">Max Hours</div>
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
                            <div class="td-wrapper"> {{ $prof->role }}</div>
                        </td>
                        <td>
                            <div class="td-wrapper"> {{ $prof->min_hours }}</div>
                        </td>
                        <td>
                            <div class="td-wrapper"> {{ $prof->max_hours }}</div>
                        </td>
                        <td>
                            <div class="td-wrapper" > {{ $prof->assigned_hours }}</div>
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
            @if ($professors->hasPages())
                <div class="pagination">
                    <a href="{{ $professors->previousPageUrl() }}"
                       class="prev-btn {{ $professors->onFirstPage() ? 'disabled' : '' }}">← previous</a>
                    <span class="page-info">{{ $professors->currentPage() }} | {{ $professors->lastPage() }}</span>
                    <a href="{{ $professors->nextPageUrl() }}"
                       class="next-btn {{ $professors->hasMorePages() ? '' : 'disabled' }}">next →</a>
                </div>
            @endif
        </x-table>
    </div>
    </body>

</x-layout>
