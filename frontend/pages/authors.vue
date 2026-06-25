<template>
  <div>
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-2xl font-semibold text-gray-900">Authors</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all the authors in your system including their name, bio, and birth date.</p>
      </div>
      <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <button @click="openCreateModal" type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
          Add author
        </button>
      </div>
    </div>

    <!-- Error State -->
    <div v-if="error" class="mt-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
      Error loading authors. Please try again later.
    </div>

    <!-- Loading State -->
    <div v-else-if="pending" class="mt-8">
      <Skeleton v-for="i in 5" :key="i" class="mb-4" />
    </div>

    <!-- Data Table -->
    <div v-else class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Bio</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Birth Date</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Books Count</th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="author in authors" :key="author.id">
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ author.name }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate max-w-xs">{{ author.bio || '-' }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ author.birth_date || '-' }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ author.books?.length || 0 }}</td>
                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <button @click="openEditModal(author)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                    <button @click="deleteAuthor(author.id)" class="text-red-600 hover:text-red-900">Delete</button>
                  </td>
                </tr>
                <tr v-if="authors.length === 0">
                  <td colspan="5" class="px-3 py-4 text-center text-sm text-gray-500">No authors found.</td>
                </tr>
              </tbody>
            </table>
            
            <!-- Pagination Component -->
            <Pagination 
              v-if="meta" 
              :meta="meta" 
              :links="links" 
              @page-changed="handlePageChange" 
            />
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Form -->
    <Modal :is-open="isModalOpen" :title="isEditing ? 'Edit Author' : 'Add Author'" @close="closeModal">
      <form @submit.prevent="submitForm">
        <div class="space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" v-model="form.name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border">
            <p v-if="validationErrors.name" class="mt-1 text-sm text-red-600">{{ validationErrors.name[0] }}</p>
          </div>
          <div>
            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
            <textarea id="bio" v-model="form.bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border"></textarea>
            <p v-if="validationErrors.bio" class="mt-1 text-sm text-red-600">{{ validationErrors.bio[0] }}</p>
          </div>
          <div>
            <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
            <input type="date" id="birth_date" v-model="form.birth_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border">
            <p v-if="validationErrors.birth_date" class="mt-1 text-sm text-red-600">{{ validationErrors.birth_date[0] }}</p>
          </div>
        </div>
      </form>
      <template #footer>
        <button type="button" @click="submitForm" :disabled="isSubmitting" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
          {{ isSubmitting ? 'Saving...' : 'Save' }}
        </button>
        <button type="button" @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Cancel
        </button>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'

const api = useApi()
const currentPage = ref(1)

// Fetch Authors Data
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

// Form State
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

// CRUD Operations
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
