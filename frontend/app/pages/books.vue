<template>
  <div class="max-w-[1440px] mx-auto px-4 sm:px-8 py-10">
    <!-- Header Section -->
    <div class="sm:flex sm:items-center justify-between mb-12">
      <div>
        <h1 class="text-[40px] font-semibold text-apple-ink tracking-tight-display leading-tight">Books</h1>
        <p class="mt-1 text-[17px] text-apple-ink-muted-80 leading-apple-body">A complete catalog of all publications.</p>
      </div>
      <div class="mt-6 sm:mt-0">
        <button @click="openCreateModal" type="button" class="inline-flex items-center justify-center bg-apple-primary text-white text-[17px] font-body rounded-apple-pill px-[22px] py-[11px] hover:scale-95 transition-transform duration-200">
          Add book
        </button>
      </div>
    </div>

    <!-- Error State -->
    <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-apple-md">
      Error loading books. Please try again later.
    </div>

    <!-- Loading State -->
    <div v-else-if="pending" class="bg-white border border-apple-hairline rounded-apple-lg p-6">
      <Skeleton v-for="i in 5" :key="i" class="mb-4" />
    </div>

    <!-- Data Table Card -->
    <div v-else class="bg-white border border-apple-hairline rounded-apple-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-apple-hairline">
          <thead class="bg-apple-pearl">
            <tr>
              <th scope="col" class="py-4 pl-6 pr-3 text-left text-[14px] font-semibold text-apple-ink-muted-80 tracking-tight-caption">Title</th>
              <th scope="col" class="px-3 py-4 text-left text-[14px] font-semibold text-apple-ink-muted-80 tracking-tight-caption">Author</th>
              <th scope="col" class="px-3 py-4 text-left text-[14px] font-semibold text-apple-ink-muted-80 tracking-tight-caption">Description</th>
              <th scope="col" class="px-3 py-4 text-left text-[14px] font-semibold text-apple-ink-muted-80 tracking-tight-caption">Publish Date</th>
              <th scope="col" class="relative py-4 pl-3 pr-6 text-right">
                <span class="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-apple-hairline bg-white">
            <tr v-for="book in books" :key="book.id" class="hover:bg-apple-parchment transition-colors">
              <td class="whitespace-nowrap py-4 pl-6 pr-3 text-[17px] font-semibold text-apple-ink tracking-tight-display truncate max-w-[200px]">{{ book.title }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-[17px] text-apple-ink-muted-80">{{ book.author?.name || '-' }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-[17px] text-apple-ink-muted-80 truncate max-w-xs">{{ book.description || '-' }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-[17px] text-apple-ink-muted-80">{{ book.publish_date || '-' }}</td>
              <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-[17px]">
                <button @click="openEditModal(book)" class="text-apple-primary hover:text-apple-primary-focus mr-4">Edit</button>
                <button @click="deleteBook(book.id)" class="text-apple-primary hover:text-apple-primary-focus">Delete</button>
              </td>
            </tr>
            <tr v-if="books.length === 0">
              <td colspan="5" class="px-6 py-8 text-center text-[17px] text-apple-ink-muted-80">No books found.</td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      <Pagination 
        v-if="meta" 
        :meta="meta" 
        :links="links" 
        @page-changed="handlePageChange" 
      />
    </div>

    <!-- Modal Form -->
    <Modal :is-open="isModalOpen" :title="isEditing ? 'Edit Book' : 'Add Book'" @close="closeModal">
      <form @submit.prevent="submitForm">
        <div class="space-y-4">
          <div>
            <label for="title" class="block text-[14px] font-semibold text-apple-ink tracking-tight-caption mb-1">Title</label>
            <input type="text" id="title" v-model="form.title" required class="block w-full rounded-apple-sm border-apple-hairline bg-apple-parchment focus:bg-white focus:border-apple-primary focus:ring-1 focus:ring-apple-primary text-[17px] px-4 py-3 border outline-none transition-colors">
            <p v-if="validationErrors.title" class="mt-1 text-[14px] text-red-600">{{ validationErrors.title[0] }}</p>
          </div>
          <div>
            <label for="author_id" class="block text-[14px] font-semibold text-apple-ink tracking-tight-caption mb-1">Author</label>
            <select id="author_id" v-model="form.author_id" required class="block w-full rounded-apple-sm border-apple-hairline bg-apple-parchment focus:bg-white focus:border-apple-primary focus:ring-1 focus:ring-apple-primary text-[17px] px-4 py-3 border outline-none transition-colors appearance-none cursor-pointer">
              <option value="" disabled>Select an author</option>
              <option v-for="author in allAuthors" :key="author.id" :value="author.id">
                {{ author.name }}
              </option>
            </select>
            <p v-if="validationErrors.author_id" class="mt-1 text-[14px] text-red-600">{{ validationErrors.author_id[0] }}</p>
          </div>
          <div>
            <label for="description" class="block text-[14px] font-semibold text-apple-ink tracking-tight-caption mb-1">Description</label>
            <textarea id="description" v-model="form.description" rows="3" class="block w-full rounded-apple-sm border-apple-hairline bg-apple-parchment focus:bg-white focus:border-apple-primary focus:ring-1 focus:ring-apple-primary text-[17px] px-4 py-3 border outline-none transition-colors"></textarea>
            <p v-if="validationErrors.description" class="mt-1 text-[14px] text-red-600">{{ validationErrors.description[0] }}</p>
          </div>
          <div>
            <label for="publish_date" class="block text-[14px] font-semibold text-apple-ink tracking-tight-caption mb-1">Publish Date</label>
            <input type="date" id="publish_date" v-model="form.publish_date" class="block w-full rounded-apple-sm border-apple-hairline bg-apple-parchment focus:bg-white focus:border-apple-primary focus:ring-1 focus:ring-apple-primary text-[17px] px-4 py-3 border outline-none transition-colors">
            <p v-if="validationErrors.publish_date" class="mt-1 text-[14px] text-red-600">{{ validationErrors.publish_date[0] }}</p>
          </div>
        </div>
      </form>
      <template #footer>
        <button type="button" @click="submitForm" :disabled="isSubmitting" class="w-full sm:w-auto inline-flex justify-center bg-apple-primary text-white text-[17px] font-body rounded-apple-pill px-[22px] py-[11px] hover:scale-95 transition-transform duration-200 disabled:opacity-50">
          {{ isSubmitting ? 'Saving...' : 'Save' }}
        </button>
        <button type="button" @click="closeModal" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center bg-apple-pearl text-apple-ink-muted-80 border border-apple-hairline text-[17px] font-body rounded-apple-pill px-[22px] py-[11px] hover:bg-apple-parchment transition-colors">
          Cancel
        </button>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref, reactive, watch, onMounted } from 'vue'

const api = useApi()
const currentPage = ref(1)

const { data, pending, error, refresh } = await useAsyncData(
  'books', 
  () => api(`/books?page=${currentPage.value}`),
  { watch: [currentPage] }
)

const books = computed(() => data.value?.data || [])
const meta = computed(() => data.value?.meta || null)
const links = computed(() => data.value?.links || null)

const handlePageChange = (page) => {
  currentPage.value = page
}

const allAuthors = ref([])
const fetchAllAuthors = async () => {
  try {
    const res = await api('/authors?page=1')
    allAuthors.value = res.data
  } catch (e) {
    console.error('Failed to fetch authors')
  }
}

onMounted(() => {
  fetchAllAuthors()
})

const isModalOpen = ref(false)
const isEditing = ref(false)
const isSubmitting = ref(false)
const editId = ref(null)
const validationErrors = ref({})

const form = reactive({
  title: '',
  author_id: '',
  description: '',
  publish_date: ''
})

const resetForm = () => {
  form.title = ''
  form.author_id = ''
  form.description = ''
  form.publish_date = ''
  editId.value = null
  isEditing.value = false
  validationErrors.value = {}
}

const openCreateModal = () => {
  resetForm()
  isModalOpen.value = true
}

const openEditModal = (book) => {
  resetForm()
  isEditing.value = true
  editId.value = book.id
  form.title = book.title
  form.author_id = book.author_id
  form.description = book.description || ''
  form.publish_date = book.publish_date || ''
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}

const submitForm = async () => {
  isSubmitting.value = true
  validationErrors.value = {}
  
  try {
    if (isEditing.value) {
      await api(`/books/${editId.value}`, {
        method: 'PUT',
        body: form
      })
    } else {
      await api('/books', {
        method: 'POST',
        body: form
      })
    }
    closeModal()
    refresh()
  } catch (err) {
    if (err.response?.status === 422) {
      validationErrors.value = err.response._data.errors || {}
    } else {
      alert('An error occurred. Please try again.')
    }
  } finally {
    isSubmitting.value = false
  }
}

const deleteBook = async (id) => {
  if (!confirm('Are you sure you want to delete this book?')) return
  
  try {
    await api(`/books/${id}`, {
      method: 'DELETE'
    })
    refresh()
  } catch (err) {
    alert('An error occurred while deleting.')
  }
}
</script>
