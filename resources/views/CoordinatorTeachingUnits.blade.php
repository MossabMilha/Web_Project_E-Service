<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/js/Coordinator/TeachingUnits.js', 'resources/css/Coordinator/TeachingUnits.css'])
    <title>Document</title>
</head>
<body>
    <div class="ShowTeachingUnits">
        <table>
            <tr>
                <th>UnitsId</th>
                <th>Name</th>
                <th>description</th>
                <th>hours</th>
                <th>type </th>
                <th>credits</th>
                <th>semester</th>
                <th>Units Created At</th>
                <th>Units Updated</th>
                <th>Actions</th>
            </tr>
            @foreach($allTeachingUnits as $unit)
                <tr>
                    <td>{{ $unit->id }}</td>
                    <td>{{ $unit->name }}</td>
                    <td>{{ $unit->description }}</td>
                    <td>{{$unit->hours}}</td>
                    <td>{{$unit->type}}</td>
                    <td>{{$unit->credits}}</td>
                    <td>{{$unit->semester}}</td>
                    <td>{{ $unit->created_at }}</td>
                    <td>{{ $unit->updated_at }}</td>
                    <td>
                        <button class="edit-btn">edit</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="modal-overlay" id="modal-overlay" style="display: none">
        <div class="Edit-Teaching-Unite" style="display: none;">
            <form>
                <h1 id="Unite-Title">Edit Information OF The Unit</h1>

                <div class="unit-info">
                    <label for="edit-name">Name: </label>
                    <span id="unit-name">Name</span>
                    <input type="text" name="name" id="edit-name">
                </div>

                <div class="unit-info">
                    <label for="edit-description">Description: </label>
                    <span id="unit-description">description</span>
                    <textarea name="description" id="edit-description"></textarea>
                </div>

                <div class="unit-info">
                    <label for="edit-hours">Hours: </label>
                    <span id="unit-hours">20</span>
                    <input type="number" name="hours" id="edit-hours">
                </div>

                <div class="unit-info">
                    <label for="edit-type">Type: </label>
                    <span id="unit-type">type</span>
                    <div id="edit-type">
                        <input type="radio" name="type" id="cm" value="CM">
                        <label for="cm">CM</label>

                        <input type="radio" name="type" id="td" value="TD">
                        <label for="td">TD</label>

                        <input type="radio" name="type" id="tp" value="TP">
                        <label for="tp">TP</label>
                    </div>
                </div>

                <div class="unit-info">
                    <label for="edit-credits">Credits: </label>
                    <span id="unit-credits">20</span>
                    <input type="number" name="credits" id="edit-credits">
                </div>

                <div class="unit-info">
                    <label for="edit-semester">Semester: </label>
                    <span id="unit-semester">20</span>
                    <input type="text" name="semester" id="edit-semester">
                </div>

                <div>
                    <button>Cancel</button>
                    <button>Edit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
