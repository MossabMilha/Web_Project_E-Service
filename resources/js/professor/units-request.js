class UnitsRequest {
    constructor() {
        this.form = document.getElementById('units-request-form');
        this.unitsContainer = document.getElementById('requested-unit-container');
        this.unitSelector = document.getElementById('unit-selector');
        this.unitsInput = document.getElementById('unitsInput');
        this.requestedUnits = {};

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
    }

    handleUnitSelect() {
        const selectedId = this.unitSelector.value;
        const units = window.unitsData || {};

        if (selectedId !== "0" && !this.requestedUnits[selectedId]) {
            this.requestedUnits[selectedId] = units[selectedId];
            this.unitsContainer.appendChild(this.createUnitElement(selectedId, units[selectedId]));

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
            // Add option back to selector
            const option = new Option(unitData.name, unitId);
            this.unitSelector.add(option);

            // Remove from display
            container.remove();

            // Update state
            delete this.requestedUnits[unitId];
            this.updateUnitsInput();
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
