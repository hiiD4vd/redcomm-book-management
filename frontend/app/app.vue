<template>
  <div class="min-h-screen bg-apple-parchment font-body text-apple-ink selection:bg-apple-primary selection:text-white pb-20">
    <!-- Global Nav -->
    <nav class="bg-apple-black text-white h-[44px] w-full flex items-center justify-between px-4 sm:px-8 z-50 fixed top-0">
      <div class="flex items-center space-x-8 max-w-[1000px] mx-auto w-full justify-center sm:justify-start">
        <NuxtLink to="/" class="text-[12px] opacity-90 hover:opacity-100 transition-opacity flex items-center font-semibold tracking-wide">
          <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
          RedComm
        </NuxtLink>
        <div class="hidden sm:flex space-x-8">
          <NuxtLink to="/books" class="text-[12px] tracking-tight opacity-80 hover:opacity-100 transition-opacity">Books</NuxtLink>
          <NuxtLink to="/authors" class="text-[12px] tracking-tight opacity-80 hover:opacity-100 transition-opacity">Authors</NuxtLink>
        </div>
      </div>
    </nav>

    <!-- Page Content Area -->
    <main class="pt-[44px]">
      <NuxtPage />
    </main>
  </div>
</template>
