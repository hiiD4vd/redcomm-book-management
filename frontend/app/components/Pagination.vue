<template>
  <div class="flex items-center justify-between border-t border-apple-hairline px-4 py-4 sm:px-6 mt-4">
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-[14px] text-apple-ink tracking-tight-caption">
          Showing
          <span class="font-semibold">{{ meta?.from || 0 }}</span>
          to
          <span class="font-semibold">{{ meta?.to || 0 }}</span>
          of
          <span class="font-semibold">{{ meta?.total || 0 }}</span>
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px" aria-label="Pagination">
          <button
            @click="changePage(meta?.current_page - 1)"
            :disabled="!links?.prev"
            class="relative inline-flex items-center px-2 py-2 text-apple-ink hover:bg-apple-parchment focus:z-20 focus:outline-none disabled:opacity-30 disabled:cursor-not-allowed rounded-l-apple-sm transition-colors"
          >
            <span class="sr-only">Previous</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" /></svg>
          </button>
          
          <button
            v-for="page in totalPages"
            :key="page"
            @click="changePage(page)"
            :class="[
              page === meta?.current_page ? 'z-10 bg-apple-parchment font-semibold text-apple-ink' : 'text-apple-ink hover:bg-apple-parchment',
              'relative inline-flex items-center px-4 py-2 text-[14px] focus:z-20 rounded-apple-sm mx-1 transition-colors'
            ]"
          >
            {{ page }}
          </button>

          <button
            @click="changePage(meta?.current_page + 1)"
            :disabled="!links?.next"
            class="relative inline-flex items-center px-2 py-2 text-apple-ink hover:bg-apple-parchment focus:z-20 focus:outline-none disabled:opacity-30 disabled:cursor-not-allowed rounded-r-apple-sm transition-colors"
          >
            <span class="sr-only">Next</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>
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
