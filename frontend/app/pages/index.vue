<template>
  <div class="flex flex-col items-center justify-center min-h-[calc(100vh-100px)] text-center">
    <div class="bg-neo-yellow border-neo border-neo-black p-10 sm:p-16 rounded-neo shadow-neo max-w-4xl w-full mx-auto space-y-8">
      <h1 class="text-5xl sm:text-7xl font-black text-neo-black uppercase tracking-tight leading-tight">
        Welcome to<br/>
        <span class="text-neo-red inline-block -rotate-2 bg-neo-black text-white px-4 py-2 mt-2 border-neo border-neo-black shadow-[4px_4px_0px_0px_#ff5c5c]">RedComm Books</span>
      </h1>
      
      <p class="text-xl sm:text-2xl font-bold text-neo-black max-w-2xl mx-auto border-t-neo border-neo-black pt-6">
        A brutalist system to manage authors and their books. Built with Nuxt.js and Laravel.
      </p>

      <div class="flex flex-col sm:flex-row justify-center items-center gap-6 pt-6">
        <NuxtLink to="/books" class="w-full sm:w-auto text-center bg-neo-blue text-white text-xl font-black uppercase border-neo border-neo-black rounded-neo px-8 py-4 shadow-neo hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all">
          Manage Books
        </NuxtLink>
        <NuxtLink to="/authors" class="w-full sm:w-auto text-center bg-neo-green text-neo-black text-xl font-black uppercase border-neo border-neo-black rounded-neo px-8 py-4 shadow-neo hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all">
          Manage Authors
        </NuxtLink>
      </div>
    </div>
  </div>
</template>
