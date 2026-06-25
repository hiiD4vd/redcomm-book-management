<template>
  <div class="min-h-screen bg-slate-50 font-sans text-slate-900">
    <header class="bg-white shadow-sm border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <NuxtLink to="/" class="text-2xl font-bold text-indigo-600 tracking-tight">RedComm Books</NuxtLink>
            </div>
            <nav class="hidden sm:ml-8 sm:flex sm:space-x-8">
              <NuxtLink to="/books" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-indigo-500 text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Books</NuxtLink>
              <NuxtLink to="/authors" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-indigo-500 text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Authors</NuxtLink>
            </nav>
          </div>
        </div>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <slot />
    </main>
  </div>
</template>
