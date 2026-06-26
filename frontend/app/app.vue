<template>
  <div class="min-h-screen bg-neo-bg font-sans text-neo-black pb-20 selection:bg-neo-pink selection:text-neo-black">
    <!-- Global Nav -->
    <nav class="bg-neo-yellow border-b-neo border-neo-black h-[70px] w-full flex items-center justify-between px-4 sm:px-8 z-50 fixed top-0">
      <div class="flex items-center space-x-8 max-w-[1300px] mx-auto w-full justify-between sm:justify-start">
        <NuxtLink to="/" class="flex items-center justify-center size-10 bg-neo-red text-white border-neo border-neo-black shadow-neo-sm hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all font-black text-xl">
          R
        </NuxtLink>
        <div class="hidden sm:flex space-x-6 items-center">
          <NuxtLink to="/books" class="text-base font-bold uppercase tracking-wider hover:underline underline-offset-4 decoration-4">Books</NuxtLink>
          <NuxtLink to="/authors" class="text-base font-bold uppercase tracking-wider hover:underline underline-offset-4 decoration-4">Authors</NuxtLink>
        </div>
      </div>
    </nav>

    <!-- Page Content Area -->
    <main class="pt-[100px] px-5 max-w-[1300px] mx-auto">
      <NuxtPage />
    </main>
  </div>
</template>
