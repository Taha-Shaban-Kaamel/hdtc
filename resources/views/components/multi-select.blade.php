@props(['items' => [], 'placeholder' => __('common.select_items'), 'name' => 'items[]', 'selectedItems' => '[]'])
{{-- @dd($selectedItems) --}}
<div x-data="multiSelect(
    @js($items),
    @js(json_decode($selectedItems, true))
)" x-id="['multi-select']" @click.away="expanded = false" class="relative">
    <div class="relative">
        <div @click="expanded = !expanded"
            class="flex flex-wrap items-center min-h-[38px] w-full rounded-md border border-gray-300 bg-white py-2 px-3 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 cursor-pointer">
            <template x-for="item in selectedItems" :key="item.id">
                <span
                    class="inline-flex items-center rounded bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800 mr-1 mb-1">
                    <span x-text="item.name"></span>
                    <button type="button" @click.stop="toggleItem(item)"
                        class="ml-1 inline-flex h-4 w-4 items-center justify-center rounded-full bg-indigo-200 text-indigo-600 hover:bg-indigo-300">
                        <span class="sr-only">{{ __('common.remove') }}</span>
                        <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                        </svg>
                    </button>
                </span>
            </template>
            <input type="text" x-model="search" @click.stop="expanded = true" @focus="expanded = true"
                :placeholder="selectedItems.length === 0 ? __('common.select_items') : ''"
                :class="{ 'opacity-0 w-0': selectedItems.length > 0, 'flex-1 min-w-[100px]': true }"
                class="border-0 p-0 text-sm focus:ring-0 focus:outline-none">
        </div>
        <button type="button" @click="expanded = !expanded" class="absolute inset-y-0 right-0 flex items-center pr-2">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor">
                <path
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <!-- Dropdown -->
    <div x-show="expanded" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="absolute z-10 mt-1 w-full rounded-md bg-white shadow-lg">
        <ul
            class="max-h-60 overflow-auto rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 focus:outline-none">
            <template x-for="item in filteredItems()" :key="item.id">
                <li @click="toggleItem(item)"
                    class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 hover:bg-indigo-50">
                    <div class="flex items-center">
                        <span x-text="item.name" class="font-normal ml-3 block truncate"></span>
                    </div>
                    <span x-show="isSelected(item.id)" class="absolute inset-y-0 right-0 flex items-center pr-4">
                        <svg class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
            </template>
        </ul>
    </div>

    <template x-for="(item, index) in selectedItems" :key="'input-' + index">
        <input type="hidden" :name="'{{ $name }}'" :value="item.id">
    </template>
</div>

<script>
    function multiSelect(initialItems = [], initialSelectedItems = []) {
        return {
            items: initialItems,
            selectedItems: initialSelectedItems || [],
            search: '',
            expanded: false,

            init() {
                // If we have selected items, ensure they are in the correct format
                if (this.selectedItems.length > 0 && !this.selectedItems[0].id) {
                    // If we have an array of IDs, map them to the full item objects
                    this.selectedItems = this.items.filter(item =>
                        this.selectedItems.includes(item.id)
                    );
                }
            },

            filteredItems() {
                return this.items.filter(item =>
                    item.name.toLowerCase().includes(this.search.toLowerCase()) &&
                    !this.selectedItems.some(selected => selected.id === item.id)
                );
            },

            toggleItem(item) {
                const index = this.selectedItems.findIndex(i => i.id === item.id);
                if (index === -1) {
                    this.selectedItems.push(item);
                } else {
                    this.selectedItems.splice(index, 1);
                }
                this.search = '';
            },

            isSelected(id) {
                return this.selectedItems.some(item => item.id === id);
            }
        }
    }
</script>
