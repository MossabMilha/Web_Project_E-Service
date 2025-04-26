<x-layout title="request units">

    <x-slot:head>
        @vite([
            'resources/css/professor/units-request.css',
            'resources/js/professor/units-request.js',
            'resources/css/components/popup.css',
            'resources/js/components/popup.js'
        ])
    </x-slot:head>

    <x-nav/>
    <body>
        <div class="main-container">

            <!-- Trigger button -->
            <button type="button" class="open-popup-btn">
                Request Units
            </button>


            <x-table>
                <table>
                    <tr>
                        <th><div class="th-wrapper">ID</div></th>
                        <th><div class="th-wrapper">Unit label</div></th>
                        <th><div class="th-wrapper">semester</div></th>
                        <th><div class="th-wrapper">academic year</div></th>
                        <th><div class="th-wrapper">status</div></th>
                        <th><div class="th-wrapper">requested At</div></th>
                    </tr>
                    @foreach($requests as $request)
                        <tr>
                            <td><div class="td-wrapper">{{$request->id}}</div></td>
                            <td><div class="td-wrapper">{{$request->unit->name}}</div></td>
                            <td><div class="td-wrapper">{{$request->semester}}</div></td>
                            <td><div class="td-wrapper">{{$request->academic_year}}</div></td>
                            <td><div class="td-wrapper">{{$request->status}}</div></td>
                            <td><div class="td-wrapper">{{$request->requested_at}}</div></td>
                        </tr>
                    @endforeach
                </table>
            </x-table>
        </div>

        <x-popup>
            <form id="units-request-form" action="{{ route('professor.units.request.store', $professor->id) }}" method="post">
                @csrf
                <h2>Request Units</h2>

                <div class="form-group">
                    <label for="unit-selector">Select Unit:</label>
                    <select id="unit-selector" name="unit_id" class="form-select">
                        <option value="0" selected disabled>Select a unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="selected-units-header">
                    <h3>Selected Units:</h3>
                </div>

                <div id="requested-unit-container" class="requested-units-container"></div>

                <input type="hidden" name="requested_units" id="unitsInput">
                <input type="hidden" name="semester" value="1">
                <input type="hidden" name="academic_year" value="2024-2025">

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Submit Request</button>
                </div>
            </form>
        </x-popup>

        <script>
            window.unitsData = @json($units->pluck('name', 'id'));
        </script>

    </body>

</x-layout>
