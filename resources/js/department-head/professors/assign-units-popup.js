class UnitAssignment {
    constructor() {
        this.form = document.getElementById('units-assignment-form');  // Changed ID
        this.unitsContainer = document.getElementById('assigned-unit-container');  // Changed ID
        this.unitSelector = document.getElementById('unit-selector');
        this.unitsInput = document.getElementById('unitsInput');
        this.assignedUnits = {};

        if (this.unitSelector) {
            this.init();
        }
    }

    init() {
        this.unitSelector.value = "0";
        this.unitSelector.addEventListener('change', this.handleUnitSelect.bind(this));
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
    }

    handleUnitSelect() {
        const selectedId = this.unitSelector.value;
        const units = window.unitsData || {};

        if (selectedId !== "0" && !this.assignedUnits[selectedId]) {
            this.assignedUnits[selectedId] = units[selectedId];
            this.unitsContainer.appendChild(this.createUnitElement(selectedId, units[selectedId]));

            // Remove selected option
            this.unitSelector.remove(this.unitSelector.selectedIndex);
            this.unitSelector.value = "0";

            this.updateUnitsInput();
        }
    }

    createUnitElement(unitId, unitName) {
        const container = document.createElement('div');
        container.className = 'assigned-unit';  // Changed class

        const unitElement = document.createElement('span');
        unitElement.textContent = unitName;

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = 'Remove';
        removeBtn.addEventListener('click', () => {
            const option = new Option(unitName, unitId);
            this.unitSelector.add(option);
            container.remove();
            delete this.assignedUnits[unitId];
            this.updateUnitsInput();
        });

        container.append(unitElement, removeBtn);
        return container;
    }

    updateUnitsInput() {
        this.unitsInput.value = JSON.stringify(Object.keys(this.assignedUnits));
    }

    handleSubmit(e) {
        this.updateUnitsInput();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new UnitAssignment();
});
