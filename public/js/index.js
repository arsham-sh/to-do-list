// Close mobile filters when clicking outside
document.addEventListener('click', function(event) {
    const mobileFilters = document.getElementById('mobileFilters');
    const filterBtn = document.querySelector('[data-bs-target="#mobileFilters"]');
    
    if (mobileFilters && !mobileFilters.contains(event.target) && !filterBtn.contains(event.target)) {
        const bsCollapse = new bootstrap.Collapse(mobileFilters);
        bsCollapse.hide();
    }
});

// Prevent body scroll when modal is open
document.addEventListener('livewire:init', function() {
    Livewire.on('showModal', (value) => {
        if (value) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });
});