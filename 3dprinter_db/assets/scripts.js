document.addEventListener('DOMContentLoaded', function() {
    // Dynamische Komponentenauswahl
    document.querySelectorAll('[data-component-select]').forEach(select => {
        select.addEventListener('change', function() {
            const printerId = this.dataset.printerId;
            const componentType = this.dataset.componentType;
            
            fetch(`api/get_components.php?printer_id=${printerId}&type=${componentType}`)
                .then(response => response.json())
                .then(data => {
                    const targetSelect = document.querySelector(this.dataset.targetSelect);
                    targetSelect.innerHTML = '';
                    
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        targetSelect.appendChild(option);
                    });
                });
        });
    });
    
    // Formularvalidierung
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            let valid = true;
            
            this.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Bitte füllen Sie alle erforderlichen Felder aus.');
            }
        });
    });
});