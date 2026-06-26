<template>
  <div class="flex items-center justify-between border-t-neo border-neo-black bg-white px-6 py-4 rounded-b-neo">
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-base font-bold text-neo-black">
          Showing
          <span class="bg-neo-yellow px-1 border-neo-black border shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">{{ meta?.from || 0 }}</span>
          to
          <span class="bg-neo-yellow px-1 border-neo-black border shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">{{ meta?.to || 0 }}</span>
          of
          <span class="bg-neo-yellow px-1 border-neo-black border shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">{{ meta?.total || 0 }}</span>
        </p>
      </div>
      <div>
        <nav class="flex space-x-2" aria-label="Pagination">
          <button
            @click="changePage(meta?.current_page - 1)"
            :disabled="!links?.prev"
            class="flex items-center justify-center size-10 rounded-neo border-neo border-neo-black bg-white shadow-neo-sm hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-x-0 disabled:hover:translate-y-0 disabled:hover:shadow-neo-sm"
          >
            <span class="sr-only">Previous</span>
            <svg class="h-6 w-6 font-bold" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" /></svg>
          </button>
          
          <button
            v-for="page in totalPages"
            :key="page"
            @click="changePage(page)"
            :class="[
              page === meta?.current_page ? 'bg-neo-green translate-x-[2px] translate-y-[2px] shadow-none' : 'bg-white shadow-neo-sm hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none',
              'flex items-center justify-center size-10 rounded-neo border-neo border-neo-black font-black text-lg transition-all focus:outline-none'
            ]"
          >
            {{ page }}
          </button>

          <button
            @click="changePage(meta?.current_page + 1)"
            :disabled="!links?.next"
            class="flex items-center justify-center size-10 rounded-neo border-neo border-neo-black bg-white shadow-neo-sm hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-x-0 disabled:hover:translate-y-0 disabled:hover:shadow-neo-sm"
          >
            <span class="sr-only">Next</span>
            <svg class="h-6 w-6 font-bold" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>
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
  if (!props.meta?.last_page) return []
  return Array.from({ length: props.meta.last_page }, (_, i) => i + 1)
})

const changePage = (page) => {
  if (page >= 1 && page <= props.meta?.last_page) {
    emit('page-changed', page)
  }
}
</script>
