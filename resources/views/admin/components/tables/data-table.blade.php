@props([
    'items' => [],
    'columns' => [],
    'actions' => ['view', 'edit', 'delete'],
    'bulkActions' => [],
    'sortable' => true,
    'searchable' => true,
    'emptyMessage' => 'Kayıt bulunamadı',
    'emptyIcon' => 'inbox'
])

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" x-data="dataTable()">
    <!-- Table Toolbar -->
    @if(count($bulkActions) > 0 || $searchable)
    <div class="border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Bulk Actions -->
            @if(count($bulkActions) > 0)
            <div x-show="selectedItems.length > 0" x-cloak class="flex items-center space-x-3">
                <span class="text-sm text-gray-600 font-medium">
                    <span x-text="selectedItems.length"></span> öğe seçildi
                </span>
                <select 
                    x-model="bulkAction"
                    @change="handleBulkAction()"
                    class="text-sm border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                >
                    <option value="">Toplu İşlem Seç</option>
                    @foreach($bulkActions as $action)
                        <option value="{{ $action }}">
                            {{ match($action) {
                                'delete' => 'Seçilenleri Sil',
                                'activate' => 'Aktif Yap',
                                'deactivate' => 'Pasif Yap',
                                'export' => 'Dışa Aktar',
                                default => ucfirst($action)
                            } }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- Search -->
            @if($searchable)
            <div class="flex-1 max-w-md" :class="selectedItems.length > 0 ? 'ml-auto' : ''">
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="search"
                        placeholder="Ara..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                    >
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    @if(count($bulkActions) > 0)
                    <th class="px-6 py-3 text-left w-12">
                        <input 
                            type="checkbox" 
                            @change="toggleAll($event)"
                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                        >
                    </th>
                    @endif

                    @foreach($columns as $column)
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        @if($sortable && ($column['sortable'] ?? true))
                        <button 
                            @click="sort('{{ $column['key'] }}')"
                            class="flex items-center space-x-1 hover:text-primary-600 transition-colors"
                        >
                            <span>{{ $column['label'] }}</span>
                            <svg 
                                class="w-4 h-4 transition-transform"
                                :class="{ 
                                    'rotate-180': sortColumn === '{{ $column['key'] }}' && sortDirection === 'desc',
                                    'text-primary-600': sortColumn === '{{ $column['key'] }}'
                                }"
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </button>
                        @else
                        {{ $column['label'] }}
                        @endif
                    </th>
                    @endforeach

                    @if(count($actions) > 0)
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                        İşlemler
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <template x-if="filteredItems.length === 0">
                    <tr>
                        <td :colspan="{{ count($columns) + (count($bulkActions) > 0 ? 1 : 0) + (count($actions) > 0 ? 1 : 0) }}" class="px-6 py-12">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($emptyIcon === 'inbox')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    @endif
                                </svg>
                                <p class="text-gray-500 font-medium">{{ $emptyMessage }}</p>
                            </div>
                        </td>
                    </tr>
                </template>

                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
function dataTable() {
    return {
        selectedItems: [],
        bulkAction: '',
        search: '',
        sortColumn: '',
        sortDirection: 'asc',
        
        get filteredItems() {
            // This will be handled by the parent component
            return [];
        },
        
        toggleAll(event) {
            if (event.target.checked) {
                // Select all visible items
                this.selectedItems = Array.from(document.querySelectorAll('tbody input[type="checkbox"]'))
                    .map(cb => cb.value);
            } else {
                this.selectedItems = [];
            }
        },
        
        sort(column) {
            if (this.sortColumn === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortColumn = column;
                this.sortDirection = 'asc';
            }
            
            // Trigger sort via URL parameter
            const url = new URL(window.location.href);
            url.searchParams.set('sort', column);
            url.searchParams.set('direction', this.sortDirection);
            window.location.href = url.toString();
        },
        
        handleBulkAction() {
            if (!this.bulkAction || this.selectedItems.length === 0) return;
            
            if (this.bulkAction === 'delete') {
                if (!confirm(`${this.selectedItems.length} öğeyi silmek istediğinize emin misiniz?`)) {
                    this.bulkAction = '';
                    return;
                }
            }
            
            // Submit bulk action form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = window.location.pathname + '/bulk-action';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfInput);
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = this.bulkAction;
            form.appendChild(actionInput);
            
            this.selectedItems.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    }
}
</script>
@endpush
