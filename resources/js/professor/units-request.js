class UnitsRequest {
    constructor() {
        this.form = document.getElementById('units-request-form');
        this.unitsContainer = document.getElementById('requested-unit-container');
        this.unitSelector = document.getElementById('unit-selector');
        this.unitsInput = document.getElementById('unitsInput');
        this.typeCheckboxes = document.querySelectorAll('input[name="type[]"]');
        this.requestedUnits = {};
        this.allUnits = window.unitsData || {};
        this.selectedTypes = [];

        if (this.unitSelector) {
            this.init();
        }
    }

    init() {
        // Initialize with first option selected
        this.unitSelector.value = "0";

        // Event listeners
        this.unitSelector.addEventListener('change', this.handleUnitSelect.bind(this));
        this.form.addEventListener('submit', this.handleSubmit.bind(this));

        // Add event listeners to type checkboxes
        this.typeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', this.handleTypeFilterChange.bind(this));
        });
    }

    handleTypeFilterChange() {
        // Update selected types array based on checked checkboxes
        this.selectedTypes = Array.from(this.typeCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        // Update the unit selector options based on selected types
        this.updateUnitSelectorOptions();
    }

    updateUnitSelectorOptions() {
        // Clear current options, except the first one
        while (this.unitSelector.options.length > 1) {
            this.unitSelector.remove(1);
        }

        // Get all units that haven't been selected yet
        const availableUnits = Object.entries(this.allUnits).filter(
            ([unitId]) => !this.requestedUnits[unitId]
        );

        // Add filtered units to selector
        availableUnits.forEach(([unitId, unitData]) => {
            // If no types are selected, show all units
            // Otherwise, only show units matching the selected types
            if (this.selectedTypes.length === 0 || this.selectedTypes.includes(unitData.type)) {
                const option = new Option(unitData.name, unitId);
                this.unitSelector.add(option);
            }
        });
    }

    handleUnitSelect() {
        const selectedId = this.unitSelector.value;

        if (selectedId !== "0" && !this.requestedUnits[selectedId]) {
            this.requestedUnits[selectedId] = this.allUnits[selectedId];
            this.unitsContainer.appendChild(this.createUnitElement(selectedId, this.allUnits[selectedId]));

            // Remove selected option
            this.unitSelector.remove(this.unitSelector.selectedIndex);
            this.unitSelector.value = "0";

            this.updateUnitsInput();
        }
    }

    createUnitElement(unitId, unitData) {
        const container = document.createElement('div');
        container.className = 'requested-unit';

        const unitElement = document.createElement('span');
        unitElement.textContent = unitData.name;

        // Create unit type indicator
        const typeIndicator = document.createElement('div');
        typeIndicator.className = 'unit-type-indicator';
        typeIndicator.textContent = unitData.type;
        typeIndicator.dataset.type = unitData.type;

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '⨯';
        removeBtn.addEventListener('click', () => {
            // Remove from display
            container.remove();

            // Update state
            delete this.requestedUnits[unitId];
            this.updateUnitsInput();

            // Update the unit selector options to include this unit again if it matches current filter
            this.updateUnitSelectorOptions();
        });

        container.append(unitElement, typeIndicator, removeBtn);
        return container;
    }

    updateUnitsInput() {
        this.unitsInput.value = JSON.stringify(Object.keys(this.requestedUnits));
    }

    handleSubmit(e) {
        this.updateUnitsInput();
        // Form will submit normally after this
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new UnitsRequest();
});
