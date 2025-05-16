/**
 * UnitsRequest Class
 * This class manages a form that allows users to select and request multiple units.
 * It includes functionality for filtering units by type, selecting units, and
 * displaying them in a container.
 */
class UnitsRequest {
    /**
     * Constructor - initializes the component by grabbing DOM references and setting up initial state
     */
    constructor() {
        // DOM element references
        this.form = document.getElementById('units-request-form');               // The main form element
        this.unitsContainer = document.getElementById('requested-unit-container'); // Container for selected units
        this.unitSelector = document.getElementById('unit-selector');            // Dropdown to select units
        this.unitsInput = document.getElementById('unitsInput');                 // Hidden input to store selected unit IDs for form submission
        this.typeCheckboxes = document.querySelectorAll('input[name="type[]"]'); // Checkboxes for filtering by unit type

        // State variables
        this.requestedUnits = {};                // Object to store currently selected units (key: unitId, value: unitData)
        this.allUnits = window.unitsData || {};  // All available units data from global variable, fallback to empty object if not found
        this.selectedTypes = [];                 // Array to track which type filters are currently selected

        // Only initialize if the selector element is found in the DOM
        if (this.unitSelector) {
            this.init();
        }
    }

    /**
     * Initialize the component by setting up event listeners and default states
     */
    init() {
        // Set dropdown to default "select" option (assuming first option has value "0")
        this.unitSelector.value = "0";

        // Attach event handlers to form elements
        this.unitSelector.addEventListener('change', this.handleUnitSelect.bind(this));  // When a unit is selected
        this.form.addEventListener('submit', this.handleSubmit.bind(this));              // When form is submitted

        // Set up filtering - add listeners to type checkboxes
        this.typeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', this.handleTypeFilterChange.bind(this));
        });
    }

    /**
     * Handles changes to the type filter checkboxes
     * Updates the internal state and refreshes the unit selector options
     */
    handleTypeFilterChange() {
        // Create array of selected type values from checked checkboxes
        this.selectedTypes = Array.from(this.typeCheckboxes)
            .filter(checkbox => checkbox.checked)  // Only include checked boxes
            .map(checkbox => checkbox.value);      // Extract the value attributes

        // Refresh the dropdown with filtered options
        this.updateUnitSelectorOptions();
    }

    /**
     * Updates the unit selector dropdown options based on:
     * 1. Units not already selected
     * 2. Units matching the selected type filters (if any)
     */
    updateUnitSelectorOptions() {
        // Clear all options except the first one (which is likely "Select a unit" or similar)
        while (this.unitSelector.options.length > 1) {
            this.unitSelector.remove(1);
        }

        // Get units that haven't been selected yet
        const availableUnits = Object.entries(this.allUnits).filter(
            ([unitId]) => !this.requestedUnits[unitId]  // Filter out units that are already in requestedUnits
        );

        // Add filtered units to the dropdown selector
        availableUnits.forEach(([unitId, unitData]) => {
            // Show all units if no filters are applied,
            // otherwise only show units that match the selected type(s)
            if (this.selectedTypes.length === 0 || this.selectedTypes.includes(unitData.type)) {
                const option = new Option(unitData.name, unitId);  // Create new option element
                this.unitSelector.add(option);                     // Add to selector
            }
        });
    }

    /**
     * Handles when a user selects a unit from the dropdown
     * Adds the selected unit to the display and updates internal state
     */
    handleUnitSelect() {
        const selectedId = this.unitSelector.value;

        // Only proceed if a valid unit is selected (not the default option)
        // and it hasn't already been added
        if (selectedId !== "0" && !this.requestedUnits[selectedId]) {
            // Add to state
            this.requestedUnits[selectedId] = this.allUnits[selectedId];

            // Add to DOM display
            this.unitsContainer.appendChild(this.createUnitElement(selectedId, this.allUnits[selectedId]));

            // Remove option from dropdown to prevent selecting it again
            this.unitSelector.remove(this.unitSelector.selectedIndex);

            // Reset dropdown to default option
            this.unitSelector.value = "0";

            // Update hidden input with current selections
            this.updateUnitsInput();
        }
    }

    /**
     * Creates a DOM element to display a selected unit with remove functionality
     * @param {string} unitId - The ID of the unit
     * @param {Object} unitData - Data object containing unit properties
     * @returns {HTMLElement} - The created DOM element
     */
    createUnitElement(unitId, unitData) {
        // Create container for the unit display item
        const container = document.createElement('div');
        container.className = 'requested-unit';

        // Create element to display unit name
        const unitElement = document.createElement('span');
        unitElement.textContent = unitData.name;

        // Create tag/badge to display unit type
        const typeIndicator = document.createElement('div');
        typeIndicator.className = 'unit-type-indicator';
        typeIndicator.textContent = unitData.type;
        typeIndicator.dataset.type = unitData.type;  // Store type as data attribute for potential CSS styling

        // Create remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '⨯';  // "×" character for delete/close
        removeBtn.addEventListener('click', () => {
            // Remove the unit display from DOM
            container.remove();

            // Remove from the internal state
            delete this.requestedUnits[unitId];

            // Update the hidden form input
            this.updateUnitsInput();

            // Refresh dropdown to include this unit again if it matches current filters
            this.updateUnitSelectorOptions();
        });

        // Assemble the elements
        container.append(unitElement, typeIndicator, removeBtn);
        return container;
    }

    /**
     * Updates the hidden input field with the current selected unit IDs
     * This ensures the server gets the correct data when the form submits
     */
    updateUnitsInput() {
        // Store just the unit IDs (keys of requestedUnits) as a JSON string
        this.unitsInput.value = JSON.stringify(Object.keys(this.requestedUnits));
    }

    /**
     * Form submit handler - ensures the hidden input has the latest data
     * @param {Event} e - The submit event object
     */
    handleSubmit(e) {
        // Make sure hidden input is updated before submission
        this.updateUnitsInput();
        // Form will submit normally after this
    }
}

// Initialize the UnitsRequest component when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    new UnitsRequest();
});
