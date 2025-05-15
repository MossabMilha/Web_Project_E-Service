<!doctype html>
<x-layout title="units requests">

    <x-slot:head>
        @vite([
        'resources/css/DepartmentHead/professors/unit-requests.css',
        'resources/js/department-head/professors/unit-requests.js',
        'resources/css/components/chips.css',
        'resources/js/components/chips.js',

        ])
    </x-slot:head>

    <x-nav/>

    <body>
        <div class="main-container">
            <div class="desktop">
                <x-table>
                    <table>
                        <tr>
                            {{--                        <th><div class="th-wrapper"></div></th>--}}
                            <th>
                                <div class="th-wrapper">request id</div>
                            </th>
                            <th>
                                <div class="th-wrapper">prof name</div>
                            </th>
                            <th>
                                <div class="th-wrapper">unit label</div>
                            </th>
                            <th>
                                <div class="th-wrapper">status</div>
                            </th>
                            <th>
                                <div class="th-wrapper">semester</div>
                            </th>
                            <th>
                                <div class="th-wrapper">academic year</div>
                            </th>
                            <th>
                                <div class="th-wrapper">workload hours</div>
                            </th>
                            <th>
                                <div class="th-wrapper">requested at</div>
                            </th>
                            <th>
                                <div class="th-wrapper">Action</div>
                            </th>
                        </tr>
                        @foreach($unit_requests as $unit_request)
                            <tr @if($unit_request->underloaded) class="underloaded" @endif>
                                {{--                            <td>--}}
                                {{--                                <div class="td-wrapper">--}}
                                {{--                                    @if($unit_request->underloaded)--}}
                                {{--                                        <x-tooltip text="underloaded">--}}
                                {{--                                            <img width="28px" src="{{asset('svg/warning.svg')}}" alt=""/>--}}
                                {{--                                        </x-tooltip>--}}
                                {{--                                    @endif--}}
                                {{--                                </div>--}}
                                {{--                            </td>--}}
                                <td>
                                    <div class="td-wrapper">
                                        {{$unit_request->id}}
                                    </div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{$unit_request->professor->name}}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{$unit_request->unit->name}}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">
                                                <span class="chip" data-status="{{ strtolower($unit_request->status) }}">
                                                    {{ $unit_request->status }}
                                                </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{$unit_request->semester}}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{$unit_request->academic_year}}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{$unit_request->assigned_hours}}
                                        @if($unit_request->assigned_hours < $unit_request->min_hours)
                                            <span class="bg-red-200 text-red-600 text-xs py-0.5 px-1.5 rounded-2xl">< {{$unit_request->min_hours}}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div
                                        class="td-wrapper">{{Carbon\Carbon::parse($unit_request->requested_at)->format('d/m/y H:i')}}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">
                                        <form
                                            action="{{route('department-head.professors.unit.request.handle', $unit_request->id)}}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" name="action" value="approve" class="btn"
                                                    style="display: flex; align-items: center">
                                                <x-svg-icon src="svg/correct-icon.svg" width="32px"
                                                            stroke="var(--color-success)" fill="var(--color-success)"
                                                            style="--stroke-color-dark: var(--color-success-dark); --fill-color-dark: var(--color-success-dark)"/>
                                            </button>
                                        </form>
                                        <form
                                            action="{{route('department-head.professors.unit.request.handle', $unit_request->id)}}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" name="action" value="reject" class="btn"
                                                    style="display: flex; align-items: center">
                                                <x-svg-icon src="svg/wrong-icon.svg" width="32px"
                                                            stroke="var(--color-danger)" fill="var(--color-danger)"
                                                            style="--stroke-color-dark: var(--color-danger-dark); --fill-color-dark: var(--color-danger-dark)"/>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if(!$unit_requests || $unit_requests->isEmpty())
                            <tr>
                                <td class="colspan-all">
                                    <div class="empty-table">
                                        <img src="{{asset('png/no-data-found.jpg')}}" alt="no data found img">
                                        <p><span><strong>Oops,</strong></span><br>No Data Found!</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </table>
                </x-table>
            </div>

            <div class="mobile">
                <div class="cards-grid">
                    @foreach($unit_requests as $unit_request)
                        <div class="card">
                            <div class="card-header">
                                <div class="card-id">#{{ $unit_request->id }}</div>
                                <span class="chip" data-status="{{ strtolower($unit_request->status) }}">
                                    {{ $unit_request->status }}
                                </span>
                            </div>

                            <div class="card-body">
                                <div class="info-row">
                                    <span class="label">Prof:</span>
                                    <span class="value">{{ $unit_request->professor->name }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Unit:</span>
                                    <span class="value">{{ $unit_request->unit->name }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Semester:</span>
                                    <span class="value">{{ $unit_request->semester }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Academic year:</span>
                                    <span class="value">{{ $unit_request->academic_year }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Assigned hours:</span>
                                    <span class="value">
                                        {{$unit_request->assigned_hours}}
                                        @if($unit_request->assigned_hours < $unit_request->min_hours)
                                            <span class="bg-red-200 text-red-600 text-xs py-0.5 px-1.5 rounded-2xl">< {{$unit_request->min_hours}}</span>
                                        @endif
                                    </span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Created:</span>
                                    <span class="value">{{ \Carbon\Carbon::parse($unit_request->created_at)->format('Y-m-d H:i') }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Updated:</span>
                                    <span class="value">{{ \Carbon\Carbon::parse($unit_request->updated_at)->format('Y-m-d H:i') }}</span>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="icons-wrapper flex">
                                    <form
                                        action="{{route('department-head.professors.unit.request.handle', $unit_request->id)}}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" name="action" value="approve" class="btn"
                                                style="display: flex; align-items: center">
                                            <x-svg-icon src="svg/correct-icon.svg" width="32px"
                                                        stroke="var(--color-success)" fill="var(--color-success)"
                                                        style="--stroke-color-dark: var(--color-success-dark); --fill-color-dark: var(--color-success-dark)"/>
                                        </button>
                                    </form>
                                    <form
                                        action="{{route('department-head.professors.unit.request.handle', $unit_request->id)}}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" name="action" value="reject" class="btn"
                                                style="display: flex; align-items: center">
                                            <x-svg-icon src="svg/wrong-icon.svg" width="32px"
                                                        stroke="var(--color-danger)" fill="var(--color-danger)"
                                                        style="--stroke-color-dark: var(--color-danger-dark); --fill-color-dark: var(--color-danger-dark)"/>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($unit_requests->hasPages())
                <div class="pagination">
                    <a href="{{ $unit_requests->previousPageUrl() }}" class="prev-btn {{ $unit_requests->onFirstPage() ? 'disabled' : '' }}">← previous</a>
                    <span class="page-info">{{ $unit_requests->currentPage() }} | {{ $unit_requests->lastPage() }}</span>
                    <a href="{{ $unit_requests->nextPageUrl() }}" class="next-btn {{ $unit_requests->hasMorePages() ? '' : 'disabled' }}">next →</a>
                </div>
            @endif

        </div>
    </body>
</x-layout>
