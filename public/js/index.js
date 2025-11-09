// Simple JavaScript for toggling task completion
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const taskCard = this.closest('.task-card');
                if (this.checked) {
                    taskCard.classList.add('completed-task');
                } else {
                    taskCard.classList.remove('completed-task');
                }
            });
        });

        // Mobile filter options
        document.querySelectorAll('.filter-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from siblings
                this.parentElement.querySelectorAll('.filter-option').forEach(el => {
                    el.classList.remove('active');
                });
                // Add active class to clicked option
                this.classList.add('active');
            });
        });