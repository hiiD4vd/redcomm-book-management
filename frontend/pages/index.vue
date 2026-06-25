<template>
  <div>
    <div class="text-center py-12">
      <h1 class="text-4xl font-extrabold text-slate-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
        Welcome to RedComm Books
      </h1>
      <p class="max-w-xl mt-5 mx-auto text-xl text-slate-500">
        A simple system to manage authors and their books. Built with Nuxt.js and Laravel.
      </p>
      <div class="mt-8 flex justify-center gap-4">
        <NuxtLink to="/books" class="px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors">
          Manage Books
        </NuxtLink>
        <NuxtLink to="/authors" class="px-6 py-3 border border-slate-300 text-base font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 shadow-sm transition-colors">
          Manage Authors
        </NuxtLink>
      </div>
    </div>
  </div>
</template>
