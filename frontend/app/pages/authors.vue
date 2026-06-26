<template>
  <div>
    <!-- Header Section -->
    <div class="sm:flex sm:items-center justify-between mb-10 bg-neo-yellow p-6 rounded-neo border-neo border-neo-black shadow-neo">
      <div>
        <h1 class="text-4xl font-black text-neo-black uppercase tracking-wider">Authors</h1>
        <p class="mt-2 text-lg font-bold text-neo-black">Manage your authors catalog with brutal style.</p>
      </div>
      <div class="mt-6 sm:mt-0">
        <button @click="openCreateModal" type="button" class="inline-flex items-center justify-center bg-neo-pink text-neo-black font-black uppercase tracking-wider border-neo border-neo-black rounded-neo px-6 py-3 shadow-neo hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all">
          + Add Author
        </button>
      </div>
    </div>

    <!-- Error State -->
    <div v-if="error" class="bg-neo-red border-neo border-neo-black shadow-neo text-neo-black font-bold px-6 py-4 rounded-neo mb-8 text-lg">
      ERROR! Could not load authors. Please try again.
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
              <th scope="col" class="py-4 pl-6 pr-3 text-left text-lg font-black text-neo-black uppercase tracking-wider border-r-neo border-neo-black">Name</th>
              <th scope="col" class="px-4 py-4 text-left text-lg font-black text-neo-black uppercase tracking-wider border-r-neo border-neo-black">Bio</th>
              <th scope="col" class="px-4 py-4 text-left text-lg font-black text-neo-black uppercase tracking-wider border-r-neo border-neo-black">Birth Date</th>
              <th scope="col" class="px-4 py-4 text-left text-lg font-black text-neo-black uppercase tracking-wider border-r-neo border-neo-black">Books</th>
              <th scope="col" class="py-4 px-6 text-center text-lg font-black text-neo-black uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <tr v-for="author in authors" :key="author.id" class="border-b-neo border-neo-black last:border-b-0 hover:bg-neo-bg transition-colors">
              <td class="whitespace-nowrap py-4 pl-6 pr-3 text-lg font-bold text-neo-black border-r-neo border-neo-black">{{ author.name }}</td>
              <td class="px-4 py-4 text-base font-bold text-neo-black border-r-neo border-neo-black max-w-xs truncate">{{ author.bio || '-' }}</td>
              <td class="whitespace-nowrap px-4 py-4 text-lg font-bold text-neo-black border-r-neo border-neo-black">{{ author.birth_date || '-' }}</td>
              <td class="whitespace-nowrap px-4 py-4 text-lg font-black text-neo-black border-r-neo border-neo-black text-center">{{ author.books_count ?? author.books?.length ?? 0 }}</td>
              <td class="whitespace-nowrap py-4 px-4 flex justify-center space-x-3">
                <button @click="openEditModal(author)" class="bg-neo-blue text-white font-black uppercase text-sm border-2 border-neo-black rounded-neo px-3 py-1 shadow-neo-sm hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">Edit</button>
                <button @click="deleteAuthor(author.id)" class="bg-neo-red text-white font-black uppercase text-sm border-2 border-neo-black rounded-neo px-3 py-1 shadow-neo-sm hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">Delete</button>
              </td>
            </tr>
            <tr v-if="authors.length === 0">
              <td colspan="5" class="px-6 py-12 text-center text-xl font-black text-neo-black uppercase">NO AUTHORS FOUND!</td>
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
    <Modal :is-open="isModalOpen" :title="isEditing ? 'Edit Author' : 'Add Author'" @close="closeModal">
      <form @submit.prevent="submitForm">
        <div class="space-y-6">
          <div>
            <label for="name" class="block text-lg font-black text-neo-black uppercase mb-2">Name</label>
            <input type="text" id="name" v-model="form.name" required class="block w-full border-neo border-neo-black rounded-neo bg-white px-4 py-3 text-lg font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[2px] focus:translate-y-[2px] focus:shadow-none outline-none transition-all">
            <p v-if="validationErrors.name" class="mt-2 text-base font-bold text-neo-red bg-neo-black px-2 py-1 inline-block">{{ validationErrors.name[0] }}</p>
          </div>
          <div>
            <label for="bio" class="block text-lg font-black text-neo-black uppercase mb-2">Bio</label>
            <textarea id="bio" v-model="form.bio" rows="3" class="block w-full border-neo border-neo-black rounded-neo bg-white px-4 py-3 text-lg font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[2px] focus:translate-y-[2px] focus:shadow-none outline-none transition-all"></textarea>
            <p v-if="validationErrors.bio" class="mt-2 text-base font-bold text-neo-red bg-neo-black px-2 py-1 inline-block">{{ validationErrors.bio[0] }}</p>
          </div>
          <div>
            <label for="birth_date" class="block text-lg font-black text-neo-black uppercase mb-2">Birth Date</label>
            <input type="date" id="birth_date" v-model="form.birth_date" class="block w-full border-neo border-neo-black rounded-neo bg-white px-4 py-3 text-lg font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[2px] focus:translate-y-[2px] focus:shadow-none outline-none transition-all">
            <p v-if="validationErrors.birth_date" class="mt-2 text-base font-bold text-neo-red bg-neo-black px-2 py-1 inline-block">{{ validationErrors.birth_date[0] }}</p>
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
import { ref, reactive, watch } from 'vue'

const api = useApi()
const currentPage = ref(1)

const { data, pending, error, refresh } = await useAsyncData(
  'authors', 
  () => api(`/authors?page=${currentPage.value}`),
  { watch: [currentPage] }
)

const authors = computed(() => data.value?.data || [])
const meta = computed(() => data.value?.meta || null)
const links = computed(() => data.value?.links || null)

const handlePageChange = (page) => {
  currentPage.value = page
}

const isModalOpen = ref(false)
const isEditing = ref(false)
const isSubmitting = ref(false)
const editId = ref(null)
const validationErrors = ref({})

const form = reactive({
  name: '',
  bio: '',
  birth_date: ''
})

const resetForm = () => {
  form.name = ''
  form.bio = ''
  form.birth_date = ''
  editId.value = null
  isEditing.value = false
  validationErrors.value = {}
}

const openCreateModal = () => {
  resetForm()
  isModalOpen.value = true
}

const openEditModal = (author) => {
  resetForm()
  isEditing.value = true
  editId.value = author.id
  form.name = author.name
  form.bio = author.bio || ''
  form.birth_date = author.birth_date || ''
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
      await api(`/authors/${editId.value}`, {
        method: 'PUT',
        body: form
      })
    } else {
      await api('/authors', {
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

const deleteAuthor = async (id) => {
  if (!confirm('Are you sure you want to delete this author? All their books will also be deleted.')) return
  
  try {
    await api(`/authors/${id}`, {
      method: 'DELETE'
    })
    refresh()
  } catch (err) {
    alert('An error occurred while deleting.')
  }
}
</script>
