<script setup lang="ts">
import CounterDemo from '@/components/CounterDemo.vue'
</script>

<template>
  <section class="space-y-8">
    <div class="max-w-2xl space-y-3">
      <p class="text-sm font-medium text-slate-500">Frontend starter</p>
      <h1 class="text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
        A clean Vue workspace for full-stack practice
      </h1>
      <p class="text-base leading-7 text-slate-600">
        Routing, shared state, and an API client are ready. Add a backend when you want the
        interface to load real data.
      </p>
    </div>

    <CounterDemo />
  </section>
</template>
