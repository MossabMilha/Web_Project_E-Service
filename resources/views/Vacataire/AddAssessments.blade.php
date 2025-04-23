<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/js/Vacataire/AddAssessments.js')
    <title>Document</title>
</head>
<body>
<form class="add-assessment-form" action="{{ route('Vacataire.AddAssessmentsDB') }}" method="post">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="name-wrapper wrapper">
        <label for="name">Assessments Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="description-wrapper wrapper">
        <label for="description">Assessments Description:</label>
        <input type="text" id="description" name="description" required>
    </div>
    <div class="filiere-wrapper wrapper">
        <label for="filiere_id">Filiere:</label>
        <select id="filiere_id" name="filiere_id" required>
            <option value="" selected disabled>Select Filiere</option> <!-- Default option -->
            @foreach($filieres as $filiere)
                <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="unit-wrapper wrapper" style="display:none;"> <!-- Initially hidden -->
        <label for="unit_id">Unit:</label>
        <select id="unit_id" name="unit_id" required>
            <option value="">Select Unit</option>
        </select>
    </div>
    <div class="semester-wrapper wrapper" style="display:none;">
        <label for="semester">Semester:</label>
        <input type="text" id="semester" name="semester" readonly>
    </div>
    <div class="submit-wrapper" style="display: none;">
        <button type="submit">Add Assessment</button>
    </div>
</form>



<script>
    var filieres = @json($filieres);
</script>
</body>
</html>
