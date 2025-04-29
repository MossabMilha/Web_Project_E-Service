class Popup {
    constructor() {
        this.overlay = document.getElementById('popup-overlay');
        this.closeBtn = document.getElementById('popup-close-btn');
        this.isOpen = false;

        this.init();
    }

    init() {
        // Event listeners
        document.addEventListener('click', (e) => {
            if (e.target.closest('.open-popup-btn')) {
                this.open();
            }
        });

        this.closeBtn.addEventListener('click', () => this.close());

        // Close when clicking outside content
        this.overlay.addEventListener('click', (e) => {
            if (e.target === this.overlay) {
                this.close();
            }
        });

        // Close with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
            }
        });
    }

    open() {
        this.overlay.style.display = 'flex';
        setTimeout(() => {
            this.overlay.classList.add('active');
        }, 10);
        this.isOpen = true;
    }

    close() {
        this.overlay.classList.remove('active');
        setTimeout(() => {
            this.overlay.style.display = 'none';
        }, 300);
        this.isOpen = false;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new Popup();
});
