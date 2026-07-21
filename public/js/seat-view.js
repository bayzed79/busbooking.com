// Enhanced Seat View JavaScript

class SeatViewManager {
    constructor() {
        this.selectedSeats = [];
        this.totalPrice = 0;
        this.seatPrice = 0;
        this.isAdmin = false;
        this.hasChanges = false;
        this.originalView = '';
        this.currentView = '';

        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updateDisplay();

        // Add keyboard shortcuts for admin
        if (this.isAdmin) {
            this.setupKeyboardShortcuts();
        }
    }

    setupEventListeners() {
        // Seat selection events
        document.querySelectorAll('.seat.available').forEach(seat => {
            seat.addEventListener('click', (e) => this.handleSeatClick(e));
        });

        // Form submission
        const bookingForm = document.getElementById('booking-form');
        if (bookingForm) {
            bookingForm.addEventListener('submit', (e) => this.handleFormSubmit(e));
        }

        // Admin-specific events
        if (this.isAdmin) {
            this.setupAdminEvents();
        }
    }

    setupAdminEvents() {
        // Drag and drop for admin
        this.setupDragAndDrop();

        // Quick action buttons
        const quickActions = document.querySelectorAll('.quick-actions button');
        quickActions.forEach(btn => {
            btn.addEventListener('click', (e) => this.handleQuickAction(e));
        });
    }

    setupDragAndDrop() {
        const seatWrappers = document.querySelectorAll('.seat-wrapper');

        seatWrappers.forEach(wrapper => {
            wrapper.addEventListener('dragstart', (e) => this.handleDragStart(e));
            wrapper.addEventListener('dragend', (e) => this.handleDragEnd(e));
            wrapper.addEventListener('dragover', (e) => this.handleDragOver(e));
            wrapper.addEventListener('drop', (e) => this.handleDrop(e));
            wrapper.addEventListener('dragenter', (e) => this.handleDragEnter(e));
            wrapper.addEventListener('dragleave', (e) => this.handleDragLeave(e));
        });
    }

    handleSeatClick(e) {
        const seat = e.currentTarget;
        const seatName = seat.dataset.seat;
        const checkbox = seat.querySelector('.seat-checkbox');

        if (checkbox) {
            if (checkbox.checked) {
                this.deselectSeat(seat, seatName, checkbox);
            } else {
                this.selectSeat(seat, seatName, checkbox);
            }
        }

        this.updateDisplay();
    }

    selectSeat(seat, seatName, checkbox) {
        checkbox.checked = true;
        seat.classList.add('selected');
        this.selectedSeats.push(seatName);
        this.totalPrice += this.seatPrice;

        // Add success animation
        seat.classList.add('success-animation');
        setTimeout(() => seat.classList.remove('success-animation'), 600);
    }

    deselectSeat(seat, seatName, checkbox) {
        checkbox.checked = false;
        seat.classList.remove('selected');
        this.selectedSeats = this.selectedSeats.filter(s => s !== seatName);
        this.totalPrice -= this.seatPrice;
    }

    updateDisplay() {
        this.updateSelectedSeatsList();
        this.updatePriceDisplay();
        this.updateProceedButton();
    }

    updateSelectedSeatsList() {
        const selectedSeatsList = document.getElementById('selected-seats-list');
        if (!selectedSeatsList) return;

        if (this.selectedSeats.length === 0) {
            selectedSeatsList.innerHTML = '<p class="text-muted">No seats selected</p>';
        } else {
            selectedSeatsList.innerHTML = this.selectedSeats.map(seat =>
                `<span class="selected-seat-tag">${seat}</span>`
            ).join('');
        }
    }

    updatePriceDisplay() {
        const seatQuantity = document.getElementById('seat-quantity');
        const totalAmount = document.getElementById('total-amount');

        if (seatQuantity) {
            seatQuantity.textContent = this.selectedSeats.length;
        }

        if (totalAmount) {
            totalAmount.textContent = `৳${this.totalPrice.toFixed(2)}`;
        }
    }

    updateProceedButton() {
        const proceedBtn = document.getElementById('proceed-btn');
        if (!proceedBtn) return;

        proceedBtn.disabled = this.selectedSeats.length === 0;

        if (this.selectedSeats.length > 0) {
            proceedBtn.classList.add('btn-success');
            proceedBtn.classList.remove('btn-primary');
        } else {
            proceedBtn.classList.remove('btn-success');
            proceedBtn.classList.add('btn-primary');
        }
    }

    handleFormSubmit(e) {
        if (this.selectedSeats.length === 0) {
            e.preventDefault();
            this.showNotification('Please select at least one seat before proceeding.', 'warning');
        }
    }

    // Admin-specific methods
    handleDragStart(e) {
        e.target.classList.add('dragging');
        e.dataTransfer.setData('text/plain', e.target.dataset.seat);
    }

    handleDragEnd(e) {
        e.target.classList.remove('dragging');
    }

    handleDragOver(e) {
        e.preventDefault();
    }

    handleDragEnter(e) {
        e.preventDefault();
        e.target.closest('.seat-wrapper')?.classList.add('drag-over');
    }

    handleDragLeave(e) {
        e.target.closest('.seat-wrapper')?.classList.remove('drag-over');
    }

    handleDrop(e) {
        e.preventDefault();
        const draggedSeat = e.dataTransfer.getData('text/plain');
        const targetWrapper = e.target.closest('.seat-wrapper');

        if (targetWrapper && targetWrapper.dataset.seat !== draggedSeat) {
            this.swapSeats(draggedSeat, targetWrapper.dataset.seat);
        }

        targetWrapper?.classList.remove('drag-over');
    }

    swapSeats(seat1, seat2) {
        const wrapper1 = document.querySelector(`[data-seat="${seat1}"]`);
        const wrapper2 = document.querySelector(`[data-seat="${seat2}"]`);

        if (wrapper1 && wrapper2) {
            const temp = wrapper1.innerHTML;
            wrapper1.innerHTML = wrapper2.innerHTML;
            wrapper2.innerHTML = temp;

            // Update data attributes
            wrapper1.dataset.seat = seat2;
            wrapper2.dataset.seat = seat1;

            this.hasChanges = true;
            this.updateSaveButton();
        }
    }

    handleQuickAction(e) {
        const action = e.target.closest('button').getAttribute('onclick');

        if (action.includes('markAllAvailable')) {
            this.markAllAvailable();
        } else if (action.includes('markAllMaintenance')) {
            this.markAllMaintenance();
        } else if (action.includes('resetLayout')) {
            this.resetLayout();
        }
    }

    markAllAvailable() {
        if (confirm('Mark all seats as available?')) {
            document.querySelectorAll('.seat').forEach(seat => {
                seat.className = 'seat available';
                this.updateSeatContent(seat, '0');
            });

            this.currentView = '0'.repeat(this.currentView.length);
            this.hasChanges = true;
            this.updateSaveButton();
            this.updateStatistics();
        }
    }

    markAllMaintenance() {
        if (confirm('Mark all seats as maintenance?')) {
            document.querySelectorAll('.seat').forEach(seat => {
                seat.className = 'seat broken';
                this.updateSeatContent(seat, '2');
            });

            this.currentView = '2'.repeat(this.currentView.length);
            this.hasChanges = true;
            this.updateSaveButton();
            this.updateStatistics();
        }
    }

    resetLayout() {
        if (confirm('Reset to original layout?')) {
            location.reload();
        }
    }

    updateSeatContent(seat, status) {
        const seatName = seat.closest('.seat-wrapper').dataset.seat;
        const index = seat.closest('.seat-wrapper').dataset.index;

        const icon = status === '0' ? 'fas fa-chair' :
                    status === '1' ? 'fas fa-user' : 'fas fa-tools';

        seat.innerHTML = `
            <i class="${icon}"></i>
            <span class="seat-number">${seatName}</span>
            <div class="seat-actions">
                <button class="btn btn-sm btn-outline-light seat-action-btn" onclick="editSeat('${seatName}', ${index}, '${status}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-light seat-action-btn" onclick="deleteSeat('${seatName}', ${index})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
    }

    updateSaveButton() {
        const saveBtn = document.getElementById('save-changes-btn');
        if (!saveBtn) return;

        if (this.hasChanges) {
            saveBtn.classList.add('btn-warning');
            saveBtn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Save Changes (Modified)';
        } else {
            saveBtn.classList.remove('btn-warning');
            saveBtn.innerHTML = '<i class="fas fa-save"></i> Save All Changes';
        }
    }

    updateStatistics() {
        const available = (this.currentView.match(/0/g) || []).length;
        const booked = (this.currentView.match(/1/g) || []).length;
        const maintenance = (this.currentView.match(/2/g) || []).length;

        const statAvailable = document.getElementById('stat-available');
        const statBooked = document.getElementById('stat-booked');
        const statMaintenance = document.getElementById('stat-maintenance');

        if (statAvailable) statAvailable.textContent = available;
        if (statBooked) statBooked.textContent = booked;
        if (statMaintenance) statMaintenance.textContent = maintenance;
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl+S to save
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                this.saveAllChanges();
            }

            // Escape to cancel edit
            if (e.key === 'Escape') {
                this.cancelSeatEdit();
            }
        });
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Public methods for external use
    setSeatPrice(price) {
        this.seatPrice = parseFloat(price);
    }

    setIsAdmin(admin) {
        this.isAdmin = admin;
    }

    setOriginalView(view) {
        this.originalView = view;
        this.currentView = view;
    }
}

// Initialize seat view manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.seatViewManager = new SeatViewManager();
});

// Global functions for admin seat view
function editSeat(seatName, index, currentStatus) {
    if (window.seatViewManager) {
        window.seatViewManager.editSeat(seatName, index, currentStatus);
    }
}

function saveSeatChanges() {
    if (window.seatViewManager) {
        window.seatViewManager.saveSeatChanges();
    }
}

function cancelSeatEdit() {
    if (window.seatViewManager) {
        window.seatViewManager.cancelSeatEdit();
    }
}

function deleteSeat(seatName, index) {
    if (window.seatViewManager) {
        window.seatViewManager.deleteSeat(seatName, index);
    }
}

function saveAllChanges() {
    if (window.seatViewManager) {
        window.seatViewManager.saveAllChanges();
    }
}
