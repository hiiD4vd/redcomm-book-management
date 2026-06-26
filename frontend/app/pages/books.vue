<template>
  <div>
    <!-- Header Section -->
    <div class="sm:flex sm:items-center justify-between mb-10 bg-neo-yellow p-6 rounded-neo border-neo border-neo-black shadow-neo">
      <div>
        <h1 class="text-4xl font-black text-neo-black uppercase tracking-wider">Books</h1>
        <p class="mt-2 text-lg font-bold text-neo-black">A complete catalog of all publications.</p>
      </div>
      <div class="mt-6 sm:mt-0">
        <button @click="openCreateModal" type="button" class="inline-flex items-center justify-center bg-neo-pink text-neo-black font-black uppercase tracking-wider border-neo border-neo-black rounded-neo px-6 py-3 shadow-neo hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all">
          + Add Book
        </button>
      </div>
    </div>

    <!-- Error State -->
    <div v-if="error" class="bg-neo-red border-neo border-neo-black shadow-neo text-neo-black font-bold px-6 py-4 rounded-neo mb-8 text-lg">
      ERROR! Could not load books. Please try again.
    </div>

    <!-- Loading State -->
    <div v-else-if="pending" class="bg-white border-neo border-neo-black rounded-neo shadow-neo overflow-hidden">
      <Skeleton v-for="i in 5" :key="i" />
    </div>

    <!-- Data Table Card -->
    <div v-else class="bg-white border-neo border-neo-black rounded-neo shadow-neo overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-neo-green border-b-neo border-neo-black">
            <tr>
              <th scope="col" class="py-4 pl-6 pr-3 text-left text-lg font-black text-neo-black uppercase tracking-wider border-r-neo border-neo-black">Title</th>
              <th scope="col" class="px-4 py-4 text-left text-lg font-black text-neo-black uppercase tracking-wider border-r-neo border-neo-black">Author</th>
              <th scope="col" class="px-4 py-4 text-left text-lg font-black text-neo-black uppercase tracking-wider border-r-neo border-neo-black">Description</th>
              <th scope="col" class="px-4 py-4 text-left text-lg font-black text-neo-black uppercase tracking-wider border-r-neo border-neo-black">Publish Date</th>
              <th scope="col" class="py-4 px-6 text-center text-lg font-black text-neo-black uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <tr v-for="book in books" :key="book.id" class="border-b-neo border-neo-black last:border-b-0 hover:bg-neo-bg transition-colors">
              <td class="whitespace-nowrap py-4 pl-6 pr-3 text-lg font-bold text-neo-black border-r-neo border-neo-black truncate max-w-[200px]">{{ book.title }}</td>
              <td class="whitespace-nowrap px-4 py-4 text-lg font-bold text-neo-black border-r-neo border-neo-black">{{ book.author?.name || '-' }}</td>
              <td class="px-4 py-4 text-base font-bold text-neo-black border-r-neo border-neo-black truncate max-w-xs">{{ book.description || '-' }}</td>
              <td class="whitespace-nowrap px-4 py-4 text-lg font-bold text-neo-black border-r-neo border-neo-black">{{ book.publish_date || '-' }}</td>
              <td class="whitespace-nowrap py-4 px-4 flex justify-center space-x-3">
                <button @click="openEditModal(book)" class="bg-neo-blue text-white font-black uppercase text-sm border-2 border-neo-black rounded-neo px-3 py-1 shadow-neo-sm hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">Edit</button>
                <button @click="deleteBook(book.id)" class="bg-neo-red text-white font-black uppercase text-sm border-2 border-neo-black rounded-neo px-3 py-1 shadow-neo-sm hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">Delete</button>
              </td>
            </tr>
            <tr v-if="books.length === 0">
              <td colspan="5" class="px-6 py-12 text-center text-xl font-black text-neo-black uppercase">NO BOOKS FOUND!</td>
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
        <div class="space-y-6">
          <div>
            <label for="title" class="block text-lg font-black text-neo-black uppercase mb-2">Title</label>
            <input type="text" id="title" v-model="form.title" required class="block w-full border-neo border-neo-black rounded-neo bg-white px-4 py-3 text-lg font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[2px] focus:translate-y-[2px] focus:shadow-none outline-none transition-all">
            <p v-if="validationErrors.title" class="mt-2 text-base font-bold text-neo-red bg-neo-black px-2 py-1 inline-block">{{ validationErrors.title[0] }}</p>
          </div>
          <div>
            <label for="author_id" class="block text-lg font-black text-neo-black uppercase mb-2">Author</label>
            <select id="author_id" v-model="form.author_id" required class="block w-full border-neo border-neo-black rounded-neo bg-white px-4 py-3 text-lg font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[2px] focus:translate-y-[2px] focus:shadow-none outline-none transition-all appearance-none cursor-pointer">
              <option value="" disabled>Select an author...</option>
              <option v-for="author in allAuthors" :key="author.id" :value="author.id">
                {{ author.name }}
              </option>
            </select>
            <p v-if="validationErrors.author_id" class="mt-2 text-base font-bold text-neo-red bg-neo-black px-2 py-1 inline-block">{{ validationErrors.author_id[0] }}</p>
          </div>
          <div>
            <label for="description" class="block text-lg font-black text-neo-black uppercase mb-2">Description</label>
            <textarea id="description" v-model="form.description" rows="3" class="block w-full border-neo border-neo-black rounded-neo bg-white px-4 py-3 text-lg font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[2px] focus:translate-y-[2px] focus:shadow-none outline-none transition-all"></textarea>
            <p v-if="validationErrors.description" class="mt-2 text-base font-bold text-neo-red bg-neo-black px-2 py-1 inline-block">{{ validationErrors.description[0] }}</p>
          </div>
          <div>
            <label for="publish_date" class="block text-lg font-black text-neo-black uppercase mb-2">Publish Date</label>
            <input type="date" id="publish_date" v-model="form.publish_date" class="block w-full border-neo border-neo-black rounded-neo bg-white px-4 py-3 text-lg font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[2px] focus:translate-y-[2px] focus:shadow-none outline-none transition-all">
            <p v-if="validationErrors.publish_date" class="mt-2 text-base font-bold text-neo-red bg-neo-black px-2 py-1 inline-block">{{ validationErrors.publish_date[0] }}</p>
          </div>
        </div>
      </form>
      <template #footer>
        <button type="button" @click="submitForm" :disabled="isSubmitting" class="w-full sm:w-auto inline-flex justify-center bg-neo-green text-neo-black font-black uppercase tracking-wider border-neo border-neo-black rounded-neo px-8 py-3 shadow-neo hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all disabled:opacity-50">
          {{ isSubmitting ? 'SAVING...' : 'SAVE!' }}
        </button>
        <button type="button" @click="closeModal" class="mt-4 sm:mt-0 w-full sm:w-auto inline-flex justify-center bg-white text-neo-black font-black uppercase tracking-wider border-neo border-neo-black rounded-neo px-8 py-3 shadow-neo hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all">
          CANCEL
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
    const res = await api('/authors?per_page=all')
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
