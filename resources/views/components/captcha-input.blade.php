<div class="space-y-2">
    <div class="flex items-center justify-between">
        <label class="inline-flex items-center space-x-3">
            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                驗證碼 <span class="text-danger-600">*</span>
            </span>
        </label>
    </div>

    <div class="flex items-center space-x-2">
        <div class="flex-1">
            <input type="text" name="data[captcha]" wire:model="data.captcha" required placeholder="請輸入驗證碼"
                class="block w-full rounded-lg border-gray-300 bg-white text-gray-950 shadow-sm outline-none transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500">
        </div>

        <div class="flex items-center space-x-2">
            <img src="{{ route('captcha.generate') }}" alt="驗證碼" class="h-10 cursor-pointer rounded"
                onclick="this.src='{{ route('captcha.generate') }}?' + Math.random()">
            <button type="button" class="rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-800"
                onclick="document.querySelector('img[alt=驗證碼]').click()">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </button>
        </div>
    </div>
</div>
