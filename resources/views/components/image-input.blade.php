@props(['name', 'preview' => null])

<div x-data="{
    preview: '{{ $preview }}',
    file: null,
    init() {
        if (this.preview) {
            this.$refs.previewImg.src = this.preview;
            this.$refs.previewContainer.classList.remove('hidden');
        }
        
        this.$watch('$store.formData.' + this.$refs.fileInput.name, value => {
            if (value && value instanceof File) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.preview = e.target.result;
                    this.file = value;
                    this.$refs.previewImg.src = this.preview;
                    this.$refs.previewContainer.classList.remove('hidden');
                    this.$dispatch('change', { detail: value });
                };
                reader.readAsDataURL(value);
            } else if (value === null) {
                this.preview = null;
                this.file = null;
                this.$refs.previewImg.src = '#';
                this.$refs.previewContainer.classList.add('hidden');
            }
        });
    },
    handleFileChange(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.preview = e.target.result;
                this.file = file;
                this.$refs.previewImg.src = this.preview;
                this.$refs.previewContainer.classList.remove('hidden');
                this.$dispatch('change', { detail: file });
            };
            reader.readAsDataURL(file);
        }
    },
    removeImage() {
        this.preview = null;
        this.file = null;
        this.$refs.fileInput.value = '';
        this.$refs.previewContainer.classList.add('hidden');
        this.$dispatch('change', { detail: null });
    }
}" class="space-y-2">
    <input x-ref="fileInput" 
           type="file" 
           name="{{ $name }}" 
           @change="handleFileChange" 
           class="hidden" 
           accept="image/*">

    <div class="flex flex-col space-x-4">
        <button type="button" 
                @click="$refs.fileInput.click()"
                class="flex-1 border-2 border-dashed border-gray-300 rounded-md p-4 text-center hover:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span class="mt-2 block text-sm font-medium text-gray-900">
                {{ $slot ?? 'Upload an image' }}
            </span>
            <span class="mt-1 text-xs text-gray-500">
                PNG, JPG, GIF up to 2MB
            </span>
        </button>

        <div x-ref="previewContainer" class="hidden">
            <div class="relative">
                <img x-ref="previewImg" class="h-24 w-24 object-cover rounded-md" :src="preview" alt="Preview" />
                <button type="button" 
                        @click="removeImage"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
