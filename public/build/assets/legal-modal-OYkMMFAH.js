class n{constructor(){this.modal=null,this.currentCheckbox=null,this.hasScrolledToBottom=!1,this.init()}init(){this.createModal(),document.addEventListener("DOMContentLoaded",()=>{this.attachLinkListeners()})}createModal(){document.body.insertAdjacentHTML("beforeend",`
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
        `),this.modal=document.getElementById("legal-modal"),document.getElementById("legal-modal-content").addEventListener("scroll",()=>this.checkScroll()),document.addEventListener("keydown",e=>{e.key==="Escape"&&!this.modal.classList.contains("invisible")&&this.close()}),this.modal.addEventListener("click",e=>{e.target.id==="legal-modal"&&this.close()})}attachLinkListeners(){document.querySelectorAll("[data-legal-slug]").forEach(t=>{t.addEventListener("click",e=>{e.preventDefault(),this.open(t.dataset.legalSlug,t.dataset.checkboxId)});const l=t.dataset.checkboxId;if(l){const e=document.getElementById(l);e&&e.addEventListener("click",()=>{e.checked&&e.dataset.needsReading!=="false"&&(e.checked=!1,this.open(t.dataset.legalSlug,l))})}})}async open(t,l=null){this.currentCheckbox=l?document.getElementById(l):null,this.hasScrolledToBottom=!1,this.isRequired=!0;const e=document.getElementById("legal-accept-btn");e.disabled=!0,document.getElementById("scroll-indicator").classList.remove("hidden"),this.modal.classList.remove("invisible","opacity-0"),this.modal.querySelector("div").classList.remove("scale-95","opacity-0"),document.body.style.overflow="hidden";try{const o=await fetch(`/api/legal/${t}`);if(!o.ok)throw new Error("Failed to load content");const a=await o.json();this.isRequired=a.is_required!==void 0?a.is_required:!0,document.getElementById("legal-modal-title").textContent=a.title,document.getElementById("legal-modal-content").innerHTML=a.content,this.isRequired?setTimeout(()=>this.checkScroll(),100):(e.disabled=!1,document.getElementById("scroll-indicator").classList.add("hidden"))}catch(o){console.error("Error loading legal content:",o),document.getElementById("legal-modal-content").innerHTML='<p class="text-red-600 dark:text-red-400">İçerik yüklenirken bir hata oluştu. Lütfen sayfayı yenileyin.</p>'}}checkScroll(){if(!this.isRequired)return;const t=document.getElementById("legal-modal-content"),l=document.getElementById("scroll-indicator"),e=document.getElementById("legal-accept-btn"),o=t.scrollHeight-t.scrollTop<=t.clientHeight+50,a=t.scrollHeight>t.clientHeight;(o||!a)&&!this.hasScrolledToBottom&&(this.hasScrolledToBottom=!0,e.disabled=!1,l.classList.add("hidden"),e.classList.add("animate-pulse"),setTimeout(()=>e.classList.remove("animate-pulse"),2e3))}accept(){if(this.currentCheckbox&&this.isRequired&&!this.hasScrolledToBottom){alert("Lütfen önce metni sonuna kadar okuyun.");return}this.currentCheckbox&&(this.currentCheckbox.dataset.needsReading="false",this.currentCheckbox.checked=!0,this.currentCheckbox.classList.remove("opacity-40","cursor-not-allowed"),this.currentCheckbox.classList.add("cursor-pointer"),this.currentCheckbox.dispatchEvent(new Event("change",{bubbles:!0}))),this.close()}close(){this.modal.classList.add("invisible","opacity-0"),this.modal.querySelector("div").classList.add("scale-95","opacity-0"),document.body.style.overflow="",this.currentCheckbox=null,this.hasScrolledToBottom=!1}}const s=new n;window.legalModal=s;
