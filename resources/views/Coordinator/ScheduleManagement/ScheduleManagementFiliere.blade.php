<x-layout title="Schedule Management - {{ $filiere->name }}">
    <x-slot:head>
        @vite([
            'resources/js/Coordinator/ScheduleManagement/ScheduleManagementFiliere.js',
            'resources/css/Coordinator/ScheduleManagement/ScheduleManagementFiliere.css',
            'resources/css/components/popup.css',
            'resources/js/components/popup.js',
        ])
    </x-slot:head>

    <x-nav />

    <div class="main-container">
        <h1 class="text-xl font-bold mb-4">Schedule Management - {{ $filiere->name }}</h1>

        <!-- Trigger button for popup -->
        <div>
            <button type="button" class="open-popup-btn">
                Importer un emploi du temps
            </button>
        </div>

        <x-popup>
            <form id="schedule-import-form"
                  action="{{ route('Coordinator.ScheduleManagementFiliere.import', ['filiere' => $filiere->id]) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                <h2>Importer un emploi du temps</h2>
                <div class="form-group">
                    <label for="semestre">Choisir le semestre :</label>
                    <select name="semestre" id="semestre" required class="form-select">
                        <option value="1">Semestre 1</option>
                        <option value="2">Semestre 2</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">Fichier Excel :</label>
                    <input type="file" id="file" name="file" accept=".xlsx,.csv" required class="form-control-file">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Importer</button>
                </div>
            </form>
        </x-popup>


        <div class="schedule-container">
            <div class="flex flex-col gap-0.5 py-2 px-3 rounded-md " style="background-color: var(--color-tertiary);">
                <h2 style="color: var(--color-white);" class="text-2xl font-semibold ">Semestre 1</h2>
            </div>
            @if($semester1Schedules->isNotEmpty())
                <x-table>
                @include('Coordinator.ScheduleManagement.WeeklyScheduleRenderer', ['schedules' => $semester1Schedules])
                </x-table>
            @else
                <p class="empty-schedule-message">No schedule available for Semestre 1.</p>
            @endif
        </div>

        <div class="schedule-container">
            <div class="flex flex-col gap-0.5 py-2 px-3 rounded-md " style="background-color: var(--color-tertiary);">
                <h2 style="color: var(--color-white);" class="text-2xl font-semibold ">Semestre 2</h2>
            </div>
            @if($semester2Schedules->isNotEmpty())
                <x-table>
                @include('Coordinator.ScheduleManagement.WeeklyScheduleRenderer', ['schedules' => $semester2Schedules])
                </x-table>
            @else
                <p class="empty-schedule-message">No schedule available for Semestre 2.</p>
            @endif
        </div>
    </div>
</x-layout>
