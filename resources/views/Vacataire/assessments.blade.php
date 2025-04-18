<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <h1>Hello To The Assasement Page</h1>
    <p>Welcome to the assessment page. Here you can find all the information related to your assessments.</p>
    <button onclick="window.location='{{ route('Vacataire.AddAssessments') }}'">Add New Assessments</button>
    @if ($assessments->isEmpty())
        <p>You have no assessments available at the moment.</p>
    @else
        <table >
            <thead>
            <tr>
                <th>Assessment ID</th>
                <th>Assessment Name</th>
                <th>Assessment Description</th>
                <th>Filiere</th>
                <th>Semester</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($assessments as $assessment)
                <tr>
                    <td>{{ $assessment->id }}</td>
                    <td>{{ $assessment->name }}</td>
                    <td>{{ $assessment->description }}</td>
                    <td>{{ $assessment->filiere->name }}</td>
                    <td>{{ $assessment->semester }}</td>
                    <td>
                        <button>h</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
