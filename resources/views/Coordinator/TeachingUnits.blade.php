<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/js/Coordinator/TeachingUnits.js', 'resources/css/Coordinator/TeachingUnits.css'])
    <title>Document</title>
</head>
<body>

    <div class="Add-modal-overlay" id="Add-modal-overlay" style="display: none;">
        <div class="Add-Teaching-Unite" >
            <form method="POST" action="{{ route('Coordinator.AddUnit',['id' => $coordinatorId]) }}">
                @csrf
                <h1>Add New Unit</h1>

                <div class="add-unit-info">
                    <label for="add-name">Name: </label>
                    <input type="text" name="add-name" id="add-name" required>
                </div>

                <div class="add-unit-info">
                    <label for="add-description">Description: </label>
                    <textarea name="add-description" id="add-description" required></textarea>
                </div>

                <div class="add-unit-info">
                    <label for="add-hours">Hours: </label>
                    <input type="number" name="add-hours" id="add-hours" required>
                </div>

                <div class="add-unit-info">
                    <label for="add-type">Type: </label>
                    <div id="add-type">
                        <input type="radio" name="add-type" id="add-cm" value="CM" required>
                        <label for="add-cm">CM</label>

                        <input type="radio" name="add-type" id="add-td" value="TD">
                        <label for="add-td">TD</label>

                        <input type="radio" name="add-type" id="add-tp" value="TP">
                        <label for="add-tp">TP</label>
                    </div>
                </div>

                <div class="add-unit-info">
                    <label for="add-credits">Credits: </label>
                    <input type="number" name="add-credits" id="add-credits" required>
                </div>

                <div class="add-unit-info">
                    <label for="add-filiere">Filiere: </label>
                    <select name="add-filiere" id="add-filiere" required>
                        @foreach($filieres as $filiere)
                            <option value="{{$filiere->id}}">{{$filiere->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="add-unit-info">
                    <label for="add-semester">Semester: </label>
                    <select name="add-semester" id="add-semester" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>

                <div>
                    <button type="button" id="add-Unit-Cancel" >Cancel</button>
                    <button type="submit" id="add-Unit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="ShowTeachingUnits">
        <button id="add-unit-btn">Add New Unit</button>
        <table>
            <tr>
                <th>UnitsId</th>
                <th>Name</th>
                <th>description</th>
                <th>hours</th>
                <th>type </th>
                <th>credits</th>
                <th>filliere</th>
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
                    <td>{{$unit->filiere_id}}</td>
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
            <form method="POST" action="{{ route('Coordinator.EditUnit', ['id' => $coordinatorId]) }}" id="editUnitForm">
                @csrf
                <h1 id="Unite-Title"></h1>
                <input type="text" name="UnitID" id="UnitID" style="display: none">

                <div class="unit-info">
                    <label for="edit-name">Name: </label>
                    <span id="unit-name"></span>
                    <input type="text" name="name" id="edit-name">
                </div>

                <div class="unit-info">
                    <label for="edit-description">Description: </label>
                    <span id="unit-description"></span>
                    <textarea name="description" id="edit-description"></textarea>
                </div>

                <div class="unit-info">
                    <label for="edit-hours">Hours: </label>
                    <span id="unit-hours"></span>
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
                    <span id="unit-credits"></span>
                    <input type="number" name="credits" id="edit-credits">
                </div>

                <div class="unit-info">
                    <label for="edit-filiere'">filiere: </label>
                    <span id="unit-filiere"></span>
                    <input type="text" name="filiere" id="edit-filiere">
                </div>

                <div class="unit-info">
                    <label for="edit-semester">Semester: </label>
                    <span id="unit-semester"></span>
                    <input type="text" name="semester" id="edit-semester">
                </div>

                <div class="unit-info" id="password-confirmation" style="display: none">
                    <label for="password-confirmation">Enter Your Password For Confirmation : </label>
                    <input type="password" name="password" id="password">
                </div>

                <div>
                    <button type="button" id="Edit-Unit-Cancel">Cancel</button>
                    <button type="button" id="Edit-Unit">Edit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
