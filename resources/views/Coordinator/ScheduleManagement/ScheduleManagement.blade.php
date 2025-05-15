<x-layout title="Select Filière">
    <x-slot:head>
        @vite([
            'resources/js/Coordinator/ScheduleManagement/ScheduleManagement.js',
            'resources/css/Coordinator/ScheduleManagement/ScheduleManagement.css',
        ])
    </x-slot:head>

    <x-nav />

    <div class="main-container">
        <h1 class="text-xl font-bold mb-6">Please Select One Of Your Filière</h1>
        <div class="form-group mb-8">
{{--            <select id="filiereSelect" name="filiere_id" required class="form-select">--}}
{{--                <option value="" disabled selected>Select a filière</option>--}}
{{--                @foreach($filieres as $filiere)--}}
{{--                    <option value="{{ $filiere->id }}" data-name="{{ $filiere->name }}">{{ $filiere->name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
            <h1>Select a filière: </h1>
            <form method="GET" id="form" action="">
                @csrf
                <div id="filiereSelect" class="filiere-select-container">
                    @foreach($filieres as $filiere)
                        <div class="filiere-option" data-value="{{ $filiere->id }}" data-name="{{ $filiere->name }}">
                            <img src="{{asset('png/filieres/'.explode(' ', $filiere->name)[0].".jpg")}}" alt="{{$filiere->name}}" width="128px">
                            <span class="option-label"> {{$filiere->name}}</span>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="filiere_id" id="filiere_id">
            </form>
        </div>


    </div>

</x-layout>
