<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/js/Vacataire/AddAssessments.js') <!-- Include your JS file correctly -->
    <title>Document</title>
</head>
<body>
<form>
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
</form>



<script>

    var filieres = @json($filieres);
</script>
</body>
</html>
