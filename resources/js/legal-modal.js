/**
 * Legal Document Modal System with Scroll Detection
 * arabam.com tarzı zorunlu okuma mekanizması
 */

class LegalModal {
    constructor() {
        this.modal = null;
        this.currentCheckbox = null;
        this.hasScrolledToBottom = false;
        this.init();
    }

    init() {
        // Create modal HTML
        this.createModal();
        
        // Attach event listeners to all legal links
        document.addEventListener('DOMContentLoaded', () => {
            this.attachLinkListeners();
        });
    }

    createModal() {
        const modalHTML = `
            <div id="legal-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-[9999] opacity-0 invisible transition-all duration-300">
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl max-w-4xl w-full m-4 relative transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh] border border-gray-200 dark:border-neutral-800">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-neutral-800 flex items-center justify-between flex-shrink-0 bg-white dark:bg-neutral-950">
                        <h3 id="legal-modal-title" class="text-2xl font-bold text-gray-900 dark:text-white font-sans"></h3>
                        <button type="button" onclick="legalModal.close()" class="text-gray-400 dark:text-neutral-400 hover:text-gray-600 dark:hover:text-white transition-colors p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Content (Scrollable) - SİYAH TEMA -->
                    <div id="legal-modal-content" class="p-8 overflow-y-auto flex-1 prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-neutral-900 font-sans">
                        <div class="flex items-center justify-center py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-600"></div>
                        </div>
                    </div>

                    <!-- Scroll Indicator -->
                    <div id="scroll-indicator" class="px-6 py-4 bg-yellow-50 dark:bg-neutral-900 border-t border-yellow-200 dark:border-neutral-800 flex items-center gap-3 flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        <p class="text-sm text-yellow-800 dark:text-yellow-400 font-semibold font-sans">Lütfen metni sonuna kadar okuyun</p>
                    </div>

                    <!-- Footer -->
                    <div class="p-6 border-t border-gray-200 dark:border-neutral-800 flex justify-end gap-3 flex-shrink-0 bg-white dark:bg-neutral-950">
                        <button type="button" onclick="legalModal.close()" class="px-6 py-2.5 bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-neutral-600 transition-all font-semibold font-sans">
                            İptal
                        </button>
                        <button type="button" id="legal-accept-btn" onclick="legalModal.accept()" disabled class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all font-semibold disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2 font-sans shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Okudum, Onaylıyorum
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.modal = document.getElementById('legal-modal');
        
        // Add scroll detection
        const contentDiv = document.getElementById('legal-modal-content');
        contentDiv.addEventListener('scroll', () => this.checkScroll());

        // ESC key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('invisible')) {
                this.close();
            }
        });

        // Backdrop click to close
        this.modal.addEventListener('click', (e) => {
            if (e.target.id === 'legal-modal') {
                this.close();
            }
        });
    }

    attachLinkListeners() {
        document.querySelectorAll('[data-legal-slug]').forEach(link => {
            // Link click: open modal
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.open(link.dataset.legalSlug, link.dataset.checkboxId);
            });

            // Checkbox direct click: block if not yet read
            const cbId = link.dataset.checkboxId;
            if (cbId) {
                const checkbox = document.getElementById(cbId);
                if (checkbox) {
                    checkbox.addEventListener('click', () => {
                        // Browser already toggled checked at this point
                        if (checkbox.checked && checkbox.dataset.needsReading !== 'false') {
                            checkbox.checked = false; // revert
                            this.open(link.dataset.legalSlug, cbId);
                        }
                    });
                }
            }
        });
    }

    async open(slug, checkboxId = null) {
        this.currentCheckbox = checkboxId ? document.getElementById(checkboxId) : null;
        this.hasScrolledToBottom = false;
        this.isRequired = true; // Default true
        
        // Reset button state
        const acceptBtn = document.getElementById('legal-accept-btn');
        acceptBtn.disabled = true;
        
        // Show scroll indicator
        document.getElementById('scroll-indicator').classList.remove('hidden');
        
        // Show modal
        this.modal.classList.remove('invisible', 'opacity-0');
        this.modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
        document.body.style.overflow = 'hidden';

        // Fetch content
        try {
            const response = await fetch(`/api/legal/${slug}`);
            if (!response.ok) throw new Error('Failed to load content');
            
            const data = await response.json();
            
            // Store is_required flag
            this.isRequired = data.is_required !== undefined ? data.is_required : true;
            
            document.getElementById('legal-modal-title').textContent = data.title;
            document.getElementById('legal-modal-content').innerHTML = data.content;
            
            // If not required, enable button immediately and hide scroll indicator
            if (!this.isRequired) {
                acceptBtn.disabled = false;
                document.getElementById('scroll-indicator').classList.add('hidden');
            } else {
                // Check if content is short enough (no scroll needed)
                setTimeout(() => this.checkScroll(), 100);
            }
            
        } catch (error) {
            console.error('Error loading legal content:', error);
            document.getElementById('legal-modal-content').innerHTML = 
                '<p class="text-red-600 dark:text-red-400">İçerik yüklenirken bir hata oluştu. Lütfen sayfayı yenileyin.</p>';
        }
    }

    checkScroll() {
        // If not required, don't check scroll
        if (!this.isRequired) return;
        
        const contentDiv = document.getElementById('legal-modal-content');
        const scrollIndicator = document.getElementById('scroll-indicator');
        const acceptBtn = document.getElementById('legal-accept-btn');
        
        // Check if scrolled to bottom (with 50px tolerance)
        const isAtBottom = contentDiv.scrollHeight - contentDiv.scrollTop <= contentDiv.clientHeight + 50;
        
        // If content doesn't need scrolling (shorter than container)
        const needsScrolling = contentDiv.scrollHeight > contentDiv.clientHeight;
        
        if ((isAtBottom || !needsScrolling) && !this.hasScrolledToBottom) {
            this.hasScrolledToBottom = true;
            acceptBtn.disabled = false;
            scrollIndicator.classList.add('hidden');
            
            // Visual feedback
            acceptBtn.classList.add('animate-pulse');
            setTimeout(() => acceptBtn.classList.remove('animate-pulse'), 2000);
        }
    }

    accept() {
        // Only check scroll requirement if is_required is true
        if (this.currentCheckbox && this.isRequired && !this.hasScrolledToBottom) {
            alert('Lütfen önce metni sonuna kadar okuyun.');
            return;
        }
        
        // Unlock and check the associated checkbox
        if (this.currentCheckbox) {
            this.currentCheckbox.dataset.needsReading = 'false';
            this.currentCheckbox.checked = true;
            this.currentCheckbox.classList.remove('opacity-40', 'cursor-not-allowed');
            this.currentCheckbox.classList.add('cursor-pointer');

            // Trigger change event for validation listeners
            this.currentCheckbox.dispatchEvent(new Event('change', { bubbles: true }));
        }
        
        this.close();
    }

    close() {
        this.modal.classList.add('invisible', 'opacity-0');
        this.modal.querySelector('div').classList.add('scale-95', 'opacity-0');
        document.body.style.overflow = '';
        
        // Reset state
        this.currentCheckbox = null;
        this.hasScrolledToBottom = false;
    }
}

// Initialize global instance
const legalModal = new LegalModal();

// Export for use in other scripts
window.legalModal = legalModal;
