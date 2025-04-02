<form action="{{route('department-head.professors.units.store', $professor->id)}}" method="post">
    @csrf
    <label>prof name: </label>
    <label>{{$professor->name}}</label>
    <br>
    <select id="unit-selector" name="unit_id">
        <option disabled>select an option</option>
        @foreach($units as $unit)
            @php
            $units_id_name[$unit->id] = $unit->name;
            @endphp
            <option value="{{$unit->id}}">{{$unit->name}}</option>
        @endforeach
    </select>
    <div id="selected-unit-container">

    </div>
    <script>
        const units_container = document.getElementById('selected-unit-container');
        const unit_selector = document.getElementById('unit-selector');

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

                let remove_btn = document.createElement("button");
                remove_btn.textContent = "remove";
                remove_btn.addEventListener("click", function (){
                    unit_container.remove();
                    delete selected_units[selectedValue];
                });

                unit_container.appendChild(unit_element);
                unit_container.appendChild(remove_btn);
                units_container.appendChild(unit_container);
            }
        });
    </script>
    <input type="submit" value="submit">
</form>
