{{-- Component Value Recommendation --}}
<style>
.value-recommendation {
    position: relative;
    width: 100%;
    display: block;
}

/* PERBAIKI: Pastikan input dalam input-group tidak hilang */
.input-group .value-recommendation {
    position: relative;
    flex: 1 1 auto;
    width: 1%;
    min-width: 0;
    display: flex;
    align-items: stretch;
}

.input-group .value-recommendation .form-control {
    position: relative;
    flex: 1 1 auto;
    width: 100%;
    min-width: 0;
    margin-bottom: 0;
    border-radius: 0.375rem;
}

/* PERBAIKI: Border radius untuk input dalam input-group */
.input-group .value-recommendation:not(:first-child) .form-control {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.input-group .value-recommendation:not(:last-child) .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

/* TAMBAHAN: Perbaikan khusus untuk material search input di sebelah kanan button */
.input-group .material-search-recommendation {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

/* TAMBAHAN: Perbaikan khusus untuk alt bom input yang berada di tengah (antara 2 button) */
.input-group .alt-bom-input-recommendation {
    border-radius: 0 !important;
}

/* TAMBAHAN: Pastikan input dalam input-group tidak memiliki border radius yang salah */
.input-group .value-recommendation .form-control,
.input-group .material-search-recommendation,
.input-group .alt-bom-input-recommendation {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

/* TAMBAHAN: Untuk input yang berada di tengah input-group (antara 2 elemen) */
.input-group .input-group-text + .value-recommendation .form-control,
.input-group .input-group-text + .alt-bom-input-recommendation {
    border-radius: 0 !important;
}

/* PERBAIKI: Untuk input dalam input-group dengan recommendation active */
.input-group .value-recommendation input.recommendation-active:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group .value-recommendation input.recommendation-active:not(:last-child) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

/* TAMBAHAN: Spesifik untuk material dan alt-bom input yang active */
.input-group .material-search-recommendation.recommendation-active,
.input-group .alt-bom-input-recommendation.recommendation-active {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

.input-group .alt-bom-input-recommendation.recommendation-active {
    border-radius: 0 !important;
}

.recommendation-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 0.375rem 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    max-height: 200px;
    overflow-y: auto;
    z-index: 1050;
    display: none;
    margin-top: 0;
}

/* TAMBAHAN: Pastikan dropdown berada di posisi yang tepat dalam input-group */
.input-group .value-recommendation .recommendation-dropdown {
    left: 0;
    right: 0;
}

.recommendation-item {
    padding: 0.5rem 0.75rem;
    cursor: pointer;
    border-bottom: 1px solid #f8f9fa;
    transition: background-color 0.15s ease-in-out;
    font-size: 0.875rem;
}

.recommendation-item:hover {
    background-color: #f8f9fa;
}

.recommendation-item:last-child {
    border-bottom: none;
}

.recommendation-item.selected {
    background-color: #e7f3ff;
    color: #0d6efd;
}

.recommendation-item .value-text {
    font-weight: 500;
    color: #495057;
}

.recommendation-item .description-text {
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.recommendation-loading {
    padding: 0.75rem;
    text-align: center;
    color: #6c757d;
    font-style: italic;
}

.recommendation-no-data {
    padding: 0.75rem;
    text-align: center;
    color: #6c757d;
    font-style: italic;
}

/* Scroll styling */
.recommendation-dropdown::-webkit-scrollbar {
    width: 6px;
}

.recommendation-dropdown::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.recommendation-dropdown::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.recommendation-dropdown::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Animation */
.recommendation-dropdown.show {
    display: block;
    animation: fadeInDown 0.2s ease-out;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Input focus styling when recommendation is active */
.value-recommendation input.recommendation-active {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-color: #0d6efd;
}

/* PERBAIKI: Untuk input dalam input-group dengan recommendation active */
.input-group .value-recommendation input.recommendation-active:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group .value-recommendation input.recommendation-active:not(:last-child) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

/* TAMBAHAN: Spesifik untuk material dan alt-bom input yang active */
.input-group .material-search-recommendation.recommendation-active,
.input-group .alt-bom-input-recommendation.recommendation-active {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

.input-group .alt-bom-input-recommendation.recommendation-active {
    border-radius: 0 !important;
}

/* Responsive */
@media (max-width: 576px) {
    .recommendation-dropdown {
        max-height: 150px;
    }
    
    .recommendation-item {
        padding: 0.4rem 0.6rem;
    }
}

/* TAMBAHAN: Reset dan proteksi */
.value-recommendation * {
    box-sizing: border-box;
}

.recommendation-dropdown {
    position: absolute !important;
    z-index: 1050 !important;
}

/* PERBAIKI: Pastikan input tidak ter-override */
.value-recommendation .form-control {
    display: block !important;
    width: 100% !important;
    padding: 0.375rem 0.75rem !important;
    font-size: 1rem !important;
    font-weight: 400 !important;
    line-height: 1.5 !important;
    color: #212529 !important;
    background-color: #fff !important;
    background-image: none !important;
    border: 1px solid #dee2e6 !important;
    border-radius: 0.375rem !important;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
}
</style>

<script>
// Value Recommendation Component JavaScript
class ValueRecommendation {
    constructor(options) {
        this.inputSelector = options.inputSelector;
        this.apiUrl = options.apiUrl;
        this.type = options.type; // 'material' or 'altbom'
        this.onSelect = options.onSelect || function() {};
        this.minLength = options.minLength || 1;
        this.debounceTime = options.debounceTime || 200;
        
        this.init();
    }
    
    init() {
        // PERBAIKI: Gunakan setTimeout untuk memastikan DOM sudah loaded
        setTimeout(() => {
            const inputs = document.querySelectorAll(this.inputSelector);
            inputs.forEach(input => {
                this.setupInput(input);
            });
        }, 100);
    }
    
    setupInput(input) {
        // PERBAIKI: Jangan buat wrapper jika input sudah dalam input-group
        const inputGroup = input.closest('.input-group');
        let wrapper;
        
        if (inputGroup) {
            // Jika input sudah dalam input-group, buat wrapper di dalam input-group
            wrapper = input.parentNode.querySelector('.value-recommendation');
            if (!wrapper) {
                wrapper = document.createElement('div');
                wrapper.className = 'value-recommendation';
                wrapper.style.position = 'relative';
                wrapper.style.flex = '1 1 auto';
                wrapper.style.width = '1%';
                wrapper.style.minWidth = '0';
                
                // Insert wrapper sebelum input dan pindahkan input ke dalam wrapper
                input.parentNode.insertBefore(wrapper, input);
                wrapper.appendChild(input);
            }
        } else {
            // Jika input tidak dalam input-group, buat wrapper normal
            wrapper = input.closest('.value-recommendation');
            if (!wrapper) {
                wrapper = this.createWrapper(input);
            }
        }
        
        let dropdown = wrapper.querySelector('.recommendation-dropdown');
        if (!dropdown) {
            dropdown = this.createDropdown();
            wrapper.appendChild(dropdown);
        }
        
        // Pastikan input tidak hilang
        if (!wrapper.contains(input)) {
            wrapper.appendChild(input);
        }
        
        let debounceTimer;
        let selectedIndex = -1;
        
        // Input event listener
        input.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            const value = e.target.value.trim();
            
            if (value.length >= this.minLength) {
                debounceTimer = setTimeout(() => {
                    this.fetchRecommendations(value, dropdown, input);
                }, this.debounceTime);
            } else {
                this.hideDropdown(dropdown, input);
            }
        });
        
        // Keyboard navigation
        input.addEventListener('keydown', (e) => {
            const items = dropdown.querySelectorAll('.recommendation-item');
            
            if (items.length === 0) return;
            
            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
                    this.updateSelection(items, selectedIndex);
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    selectedIndex = Math.max(selectedIndex - 1, -1);
                    this.updateSelection(items, selectedIndex);
                    break;
                    
                case 'Enter':
                    if (selectedIndex >= 0) {
                        e.preventDefault();
                        items[selectedIndex].click();
                    }
                    break;
                    
                case 'Escape':
                    this.hideDropdown(dropdown, input);
                    selectedIndex = -1;
                    break;
            }
        });
        
        // Hide dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) {
                this.hideDropdown(dropdown, input);
                selectedIndex = -1;
            }
        });
        
        // Focus and blur events
        input.addEventListener('focus', () => {
            const value = input.value.trim();
            if (value.length >= this.minLength) {
                this.fetchRecommendations(value, dropdown, input);
            }
        });
        
        input.addEventListener('blur', () => {
            // Delay hiding to allow click on dropdown items
            setTimeout(() => {
                if (!wrapper.querySelector('.recommendation-dropdown:hover')) {
                    this.hideDropdown(dropdown, input);
                    selectedIndex = -1;
                }
            }, 150);
        });
    }
    
    createWrapper(input) {
        const wrapper = document.createElement('div');
        wrapper.className = 'value-recommendation';
        
        // PERBAIKI: Pastikan parent element tidak rusak
        const parent = input.parentNode;
        parent.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        
        return wrapper;
    }
    
    createDropdown() {
        const dropdown = document.createElement('div');
        dropdown.className = 'recommendation-dropdown';
        return dropdown;
    }
    
    fetchRecommendations(query, dropdown, input) {
        this.showLoading(dropdown, input);
        
        const url = `${this.apiUrl}?action=get_recommendations&type=${this.type}&q=${encodeURIComponent(query)}`;
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            this.renderRecommendations(data, dropdown, input, query);
        })
        .catch(error => {
            console.error('Error fetching recommendations:', error);
            this.showError(dropdown, input);
        });
    }
    
    showLoading(dropdown, input) {
        dropdown.innerHTML = '<div class="recommendation-loading">Mencari rekomendasi...</div>';
        this.showDropdown(dropdown, input);
    }
    
    showError(dropdown, input) {
        dropdown.innerHTML = '<div class="recommendation-no-data">Error mengambil data</div>';
        this.showDropdown(dropdown, input);
    }
    
    renderRecommendations(data, dropdown, input, query) {
        if (!data || data.length === 0) {
            dropdown.innerHTML = '<div class="recommendation-no-data">Tidak ada rekomendasi</div>';
            this.showDropdown(dropdown, input);
            return;
        }
        
        let html = '';
        data.forEach((item, index) => {
            const value = this.type === 'material' ? item.material_fg_sfg : item.alt_bom_text;
            const description = this.type === 'material' ? item.product : '';
            
            // Highlight matching text
            const highlightedValue = this.highlightText(value, query);
            
            html += `
                <div class="recommendation-item" data-value="${value}" data-index="${index}">
                    <div class="value-text">${highlightedValue}</div>
                    ${description ? `<div class="description-text">${description}</div>` : ''}
                </div>
            `;
        });
        
        dropdown.innerHTML = html;
        
        // Add click event listeners
        dropdown.querySelectorAll('.recommendation-item').forEach(item => {
            item.addEventListener('click', () => {
                const value = item.getAttribute('data-value');
                input.value = value;
                this.hideDropdown(dropdown, input);
                this.onSelect(value, input);
                
                // Trigger change event
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            });
        });
        
        this.showDropdown(dropdown, input);
    }
    
    highlightText(text, query) {
        if (!query) return text;
        
        const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
        return text.replace(regex, '<mark style="background-color: #fff3cd; padding: 0;">$1</mark>');
    }
    
    updateSelection(items, selectedIndex) {
        items.forEach((item, index) => {
            item.classList.toggle('selected', index === selectedIndex);
        });
        
        if (selectedIndex >= 0) {
            items[selectedIndex].scrollIntoView({ block: 'nearest' });
        }
    }
    
    showDropdown(dropdown, input) {
        dropdown.classList.add('show');
        input.classList.add('recommendation-active');
    }
    
    hideDropdown(dropdown, input) {
        dropdown.classList.remove('show');
        input.classList.remove('recommendation-active');
    }
}

// Export for use in other files
window.ValueRecommendation = ValueRecommendation;
</script>