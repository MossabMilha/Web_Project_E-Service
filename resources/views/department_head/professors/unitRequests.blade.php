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
                        <tr @if($unit_request->underloaded) style="background-color: #ffe5e5;" @endif>
                            <td><div class="td-wrapper">{{$unit_request->professor_id}}</div></td>
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
                                        <button type="submit" name="action" value="approve" class="btn btn-primary">approve</button>
                                    </form>
                                    <form action="{{route('department-head.professors.unit.request.handle', $unit_request->id)}}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" name="action" value="reject" class="btn btn-danger">reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </x-table>
        </div>
    </body>
</x-layout>
