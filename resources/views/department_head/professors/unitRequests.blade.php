<!doctype html>
<x-layout title="units requests">

    <x-slot:head>
        @vite([
        'resources/css/DepartmentHead/professors/unit-requests.css',
        'resources/js/department-head/professors/unit-requests.js'
        ])
    </x-slot:head>

    <x-nav/>

    <body>
        <div class="main-container">
        <x-table>
                <table>
                    <tr>
                        <th><div class="th-wrapper"></div></th>
                        <th><div class="th-wrapper">professor id</div></th>
                        <th><div class="th-wrapper">professor name</div></th>
                        <th><div class="th-wrapper">unit id</div></th>
                        <th><div class="th-wrapper">unit label</div></th>
                        <th><div class="th-wrapper">status</div></th>
                        <th><div class="th-wrapper">semester</div></th>
                        <th><div class="th-wrapper">academic year</div></th>
                        <th><div class="th-wrapper">workload hours</div></th>
                        <th><div class="th-wrapper">min required hours</div></th>
                        <th><div class="th-wrapper">requested at</div></th>
{{--                        <th><div class="th-wrapper">reviewed at</div></th>--}}
{{--                        <th><div class="th-wrapper">reviewed by</div></th>--}}
                        <th><div class="th-wrapper">Action</div></th>
                    </tr>
                    @foreach($unit_requests as $unit_request)
                        <tr @if($unit_request->underloaded) style="background: var(--bg-gradient-2)" @endif>
                            <td><div class="td-wrapper">
                                    @if($unit_request->underloaded) <img width="75px" src="{{asset('svg/warning.svg')}}" alt=""/> @endif
                                </div>
                            </td>
                            <td><div class="td-wrapper">
                                    {{$unit_request->professor_id}}
                                </div>
                            </td>
                            <td><div class="td-wrapper">{{$unit_request->professor->name}}</div></td>
                            <td><div class="td-wrapper">{{$unit_request->unit_id}}</div></td>
                            <td><div class="td-wrapper">{{$unit_request->unit->name}}</div></td>
                            <td><div class="td-wrapper">{{$unit_request->status}}</div></td>
                            <td><div class="td-wrapper">{{$unit_request->semester}}</div></td>
                            <td><div class="td-wrapper">{{$unit_request->academic_year}}</div></td>
                            <td><div class="td-wrapper">{{$unit_request->assigned_hours}}</div></td>
                            <td><div class="td-wrapper">{{$unit_request->min_hours}}</div></td>
                            <td><div class="td-wrapper">{{$unit_request->requested_at}}</div></td>
{{--                            <td><div class="td-wrapper">{{$unit_request->reviewed_at}}</div></td>--}}
{{--                            <td>--}}
{{--                                <div class="td-wrapper">--}}
{{--                                    @if($unit_request->reviewed_by != null)--}}
{{--                                        {{$unit_request->reviewed_by}}--}}
{{--                                    @else--}}
{{--                                        not reviewed--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </td>--}}
                            <td>
                                <div class="td-wrapper">
                                    <form action="{{route('department-head.professors.unit.request.handle', $unit_request->id)}}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" name="action" value="approve" class="btn"
                                                style="display: flex; align-items: center">
                                            <x-svg-icon src="svg/correct-icon.svg" width="32px" stroke="var(--color-success)" fill="var(--color-success)"
                                                        style="--stroke-color-dark: var(--color-success-dark); --fill-color-dark: var(--color-success-dark)"/>
                                        </button>
                                    </form>
                                    <form action="{{route('department-head.professors.unit.request.handle', $unit_request->id)}}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" name="action" value="reject" class="btn"
                                                style="display: flex; align-items: center">
                                            <x-svg-icon src="svg/wrong-icon.svg" width="32px" stroke="var(--color-danger)" fill="var(--color-danger)"
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
    </body>
</x-layout>
