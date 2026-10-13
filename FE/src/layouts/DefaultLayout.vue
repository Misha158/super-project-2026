<script setup lang="ts">
import AppHeader from '@/components/common/AppHeader.vue'
</script>

<template>
  <div class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <AppHeader />
    <main class="mx-auto w-full max-w-5xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
      <slot />
    </main>
  </div>
</template>
