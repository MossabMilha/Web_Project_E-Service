<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
<form id="store-assignment-form" action="{{route('department-head.professors.units.store', $professor->id)}}" method="post">
    @csrf
    <label>prof name: </label>
    <label>{{$professor->name}}</label>
    <br>
    <select id="unit-selector" name="unit_id">
        <option value="0" disabled>select an option</option>
        @foreach($units as $unit)
            @php
                $units_id_name[$unit->id] = $unit->name;
            @endphp
            <option value="{{$unit->id}}">{{$unit->name}}</option>
        @endforeach
    </select>
    <div id="selected-unit-container"></div>
    <input type="hidden" name="selected_units" id="unitsInput">
    <input type="submit" value="submit">
    <script>
        const units_container = document.getElementById('selected-unit-container');
        const unit_selector = document.getElementById('unit-selector');
        unit_selector.value = "0";

        const units = @json($units_id_name);
        let selected_units = {};

        unit_selector.addEventListener("change", function() {
            let selectedValue = this.value;

            if (!selected_units[selectedValue]) {
                selected_units[selectedValue] = units[this.value];

                let unit_container = document.createElement("div");

                let unit_element = document.createElement("p");
                unit_element.innerHTML = `${selected_units[selectedValue]}`;
                unit_element.setAttribute('id', `${selectedValue}`);

                // remove the selected option form the list
                let selectedOption = unit_selector.options[unit_selector.selectedIndex];
                selectedOption.remove();
                unit_selector.value = "0"; // reset the value of selector

                let remove_btn = document.createElement("button");
                remove_btn.textContent = "remove";
                remove_btn.addEventListener("click", function (){
                    let option = document.createElement('option');
                    option.setAttribute('value', `${selectedValue}`);
                    option.textContent = `${selected_units[selectedValue]}`;

                    unit_selector.appendChild(option);
                    unit_container.remove();

                    delete selected_units[selectedValue];
                });

                unit_container.appendChild(unit_element);
                unit_container.appendChild(remove_btn);
                units_container.appendChild(unit_container);
            }
            console.log(Object.keys(selected_units));
        });

        document.getElementById("store-assignment-form").addEventListener("submit", function () {
            document.getElementById("unitsInput").value = JSON.stringify(Object.keys(selected_units));
        });
    </script>
</form>

</body>
</html>
