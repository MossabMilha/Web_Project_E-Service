<x-layout title="Select Filière">
    <x-slot:head>
        @vite([
            'resources/js/Coordinator/ScheduleManagement/ScheduleManagement.js',
            'resources/css/Coordinator/ScheduleManagement/ScheduleManagement.css',
        ])
    </x-slot:head>

    <x-nav />

    <div class="main-container">
        <h1 class="text-xl font-bold mb-6">Please Select One Of Your Major</h1>
        <div class="form-group mb-8">
            <form method="GET" id="filiere-select-form" action="">
                @csrf
                <div id="filiereSelect" class="filiere-select-container">
                    @foreach($filieres as $filiere)
                        <div class="filiere-option" data-value="{{ $filiere->id }}" data-name="{{ $filiere->name }}">
                            <img src="{{asset('png/filieres/'.explode(' ', $filiere->name)[0].".jpg")}}" alt="{{$filiere->name}}">
{{--                            <span class="option-label"> {{$filiere->name}}</span>--}}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="filiere_id" id="filiere_id">
            </form>
        </div>


    </div>

</x-layout>
