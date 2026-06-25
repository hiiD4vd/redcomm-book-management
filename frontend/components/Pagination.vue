<template>
  <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-4">
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          <span class="font-medium">{{ meta?.from || 0 }}</span>
          to
          <span class="font-medium">{{ meta?.to || 0 }}</span>
          of
          <span class="font-medium">{{ meta?.total || 0 }}</span>
          results
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <button
            @click="changePage(meta?.current_page - 1)"
            :disabled="!links?.prev"
            class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span class="sr-only">Previous</span>
            &laquo;
          </button>
          
          <button
            v-for="page in totalPages"
            :key="page"
            @click="changePage(page)"
            :class="[
              page === meta?.current_page ? 'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0',
              'relative inline-flex items-center px-4 py-2 text-sm font-semibold focus:z-20'
            ]"
          >
            {{ page }}
          </button>

          <button
            @click="changePage(meta?.current_page + 1)"
            :disabled="!links?.next"
            class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span class="sr-only">Next</span>
            &raquo;
          </button>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  meta: Object,
  links: Object
})

const emit = defineEmits(['page-changed'])

const totalPages = computed(() => {
  return props.meta?.last_page || 1
})

const changePage = (page) => {
  if (page < 1 || page > totalPages.value || page === props.meta?.current_page) {
    return
  }
  emit('page-changed', page)
}
</script>
