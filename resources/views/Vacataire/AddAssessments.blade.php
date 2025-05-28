<x-layout title="Add Assessment">
    <x-slot:head>
        @vite([
            'resources/js/Vacataire/AddAssessments.js',
            'resources/css/vacataire/add-assessments.css'
        ])
    </x-slot:head>

    <x-nav/>

    <div class="main-container">

        @if ($errors->any())
            <div class="error-messages-holder">
                <div class="error-messages">
                    <h1>Invalid Information</h1>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form class="add-assessment-form" action="{{ route('Vacataire.AddAssessmentsDB') }}" method="post">
            @csrf

            <h1>Add Assessment Information</h1>
            <div class="name-wrapper wrapper">
                <label for="name">Assessment Name:</label>
                @if($errors->has('name'))
                    <p class="error-text">{{ $errors->first('name') }}</p>
                @endif
                <input type="text" id="name" name="name" required>
            </div>

            <div class="description-wrapper wrapper">
                <label for="description">Assessment Description:</label>
                @if($errors->has('description'))
                    <p class="error-text">{{ $errors->first('description') }}</p>
                @endif
                <input type="text" id="description" name="description" required>
            </div>

            <div class="filiere-wrapper wrapper">
                <label for="filiere_id">Filière:</label>
                @if($errors->has('filiere_id'))
                    <p class="error-text">{{ $errors->first('filiere_id') }}</p>
                @endif
                <select id="filiere_id" name="filiere_id" required>
                    <option value="" selected disabled>Select Filiere</option>
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="unit-wrapper wrapper" style="display:none;">
                <label for="unit_id">Unit:</label>
                @if($errors->has('unit_id'))
                    <p class="error-text">{{ $errors->first('unit_id') }}</p>
                @endif
                <select id="unit_id" name="unit_id" required>
                    <option value="">Select Unit</option>
                </select>
            </div>

            <div class="semester-wrapper wrapper" style="display:none;">
                <label for="semester">Semester:</label>
                @if($errors->has('semester'))
                    <p class="error-text">{{ $errors->first('semester') }}</p>
                @endif
                <input type="text" id="semester" name="semester" readonly>
            </div>

            <div class="btns-wrapper">
                <a class="back-btn" href="{{ route('Vacataire.assessments') }}">Back</a>
                <input type="submit" value="Add Assessment">
            </div>
        </form>
    </div>

    <script>
        var filieres = @json($filieres);
    </script>

</x-layout>
