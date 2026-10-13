<script setup lang="ts">
import { useCounterStore } from '@/stores/counter'

const counter = useCounterStore()
</script>

<template>
  <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-lg font-semibold text-slate-950">Shared counter</h2>
    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600">
      This value lives in a Pinia store. Any component or page can read it and update it.
    </p>

    <dl class="mt-6 grid grid-cols-2 gap-4">
      <div class="rounded-lg bg-slate-50 px-4 py-3">
        <dt class="text-xs font-medium tracking-wide text-slate-500 uppercase">Count</dt>
        <dd class="mt-1 text-2xl font-semibold text-slate-950">{{ counter.count }}</dd>
      </div>
      <div class="rounded-lg bg-slate-50 px-4 py-3">
        <dt class="text-xs font-medium tracking-wide text-slate-500 uppercase">Double</dt>
        <dd class="mt-1 text-2xl font-semibold text-slate-950">{{ counter.doubleCount }}</dd>
      </div>
    </dl>

    <div class="mt-6 flex flex-wrap gap-3">
      <button
        type="button"
        class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700"
        @click="counter.increment()"
      >
        Increment
      </button>
      <button
        type="button"
        class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
        @click="counter.reset()"
      >
        Reset
      </button>
    </div>
  </section>
</template>
