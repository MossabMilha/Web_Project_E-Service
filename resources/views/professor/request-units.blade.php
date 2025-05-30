@php use Carbon\Carbon; @endphp

<x-layout title="request units">

    <x-slot:head>
        @vite([
            'resources/css/professor/units-request.css',
            'resources/js/professor/units-request.js',
            'resources/css/components/popup.css',
            'resources/js/components/popup.js',
            'resources/css/components/chips.css',
            'resources/js/components/chips.js',
        ])
    </x-slot:head>

    <x-nav/>
    <body>
    <div class="main-container">

        <!-- Trigger button -->
        <div>
            <button type="button" class="open-popup-btn">
                Request Units
            </button>
        </div>

        <div class="desktop">
            <x-table>
                <table>
                    <tr>
                        <th>
                            <div class="th-wrapper">ID</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Unit label</div>
                        </th>
                        <th>
                            <div class="th-wrapper">semester</div>
                        </th>
                        <th>
                            <div class="th-wrapper">academic year</div>
                        </th>
                        <th>
                            <div class="th-wrapper">status</div>
                        </th>
                        <th>
                            <div class="th-wrapper">requested At</div>
                        </th>
                    </tr>
                    @foreach($requests as $request)
                        <tr>
                            <td>
                                <div class="td-wrapper">{{$request->id}}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">{{$request->unit->name}}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">{{$request->semester}}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">{{$request->academic_year}}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">
                                            <span class="chip" data-status="{{ strtolower($request->status) }}">
                                                {{ $request->status }}
                                            </span>
                                </div>
                            </td>
                            <td>
                                <div
                                    class="td-wrapper">{{Carbon::parse($request->requested_at)->format('j M Y, H:i')}}</div>
                            </td>
                        </tr>
                    @endforeach
                    @if(!$requests || $requests->isEmpty())
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
                @foreach($requests as $request)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-id">#{{ $request->id }}</div>
                            <span class="chip" data-status="{{$request->status}}">
                            {{ $request->status}}
                            </span>
                        </div>

                        <div class="card-body">
                            <div class="info-row">
                                <span class="label">Label:</span>
                                <span class="value">{{ $request->unit->name }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Semester:</span>
                                <span class="value">{{ $request->semester }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Academic year:</span>
                                <span class="value">{{ $request->academic_year }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Type:</span>
                                <span class="value">
                                    <span class="unit-type-indicator" data-type="{{ $request->unit->type }}"> {{ $request->unit->type }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="card">
                    <div class="card-body">
                        @if(!$requests || $requests->isEmpty())
                            <div class="empty-table">
                                <img src="{{asset('png/no-data-found.jpg')}}" alt="no data found img">
                                <p><span><strong>Oops,</strong></span><br>No Data Found!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($requests->hasPages())
            <div class="pagination">
                <a href="{{ $requests->previousPageUrl() }}"
                   class="prev-btn {{ $requests->onFirstPage() ? 'disabled' : '' }}">← previous</a>
                <span class="page-info">{{ $requests->currentPage() }} | {{ $requests->lastPage() }}</span>
                <a href="{{ $requests->nextPageUrl() }}"
                   class="next-btn {{ $requests->hasMorePages() ? '' : 'disabled' }}">next →</a>
            </div>
        @endif
    </div>

    <x-popup>
        <form id="units-request-form" action="{{ route('professor.units.request.store', $professor->id) }}"
              method="post">
            @csrf
{{--            <img src="{{asset('png/warning.jpg')}}" alt="alert image" class="popup-img-top">--}}
            <h2>Request Units</h2>

            <div class="form-group">
                <label for="type">Select Unit Type:</label>
                <div class="unit-types">
                    <label for="checkbox">
                        <input type="checkbox" name="type[]" value="CM">
                        <span>CM</span>
                    </label>
                    <label for="checkbox">
                        <input type="checkbox" name="type[]" value="TD">
                        <span>TD</span>
                    </label>
                    <label for="checkbox">
                        <input type="checkbox" name="type[]" value="TP">
                        <span>TP</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="unit-selector">Select Unit:</label>
                <select id="unit-selector" name="unit_id" class="form-select">
                    <option value="0" selected disabled>Select a unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <div class="selected-units-header">
                    <h3>Selected Units:</h3>
                </div>
                <div id="requested-unit-container" class="requested-units-container"></div>
            </div>

            <input type="hidden" name="requested_units" id="unitsInput">
            <input type="hidden" name="semester" value="1">
            <input type="hidden" name="academic_year" value="2024-2025">

            <div class="form-actions">
                <button type="submit" class="btn-submit">Submit Request</button>
            </div>
        </form>
    </x-popup>

    <script>
        window.unitsData = @json($units->map(function($unit) {
        return [
            'id' => $unit->id,
            'name' => $unit->name,
            'type' => $unit->type
        ];
    })->keyBy('id'));
</script>

    </body>

</x-layout>
