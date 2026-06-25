<template>
  <div v-if="isOpen" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-black/60 transition-opacity backdrop-blur-sm" aria-hidden="true" @click="$emit('close')"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-neo text-left transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border-neo border-neo-black shadow-neo">
        <div class="bg-white px-6 pt-6 pb-4 rounded-t-neo">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-3xl font-black text-neo-black mb-4 uppercase" id="modal-title">
                {{ title }}
              </h3>
              <div class="mt-2 font-medium">
                <slot></slot>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-neo-bg px-6 py-4 flex flex-col sm:flex-row-reverse sm:space-x-reverse sm:space-x-4 border-t-neo border-neo-black rounded-b-neo">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  isOpen: Boolean,
  title: String
})
</script>
