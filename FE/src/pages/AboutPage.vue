<script setup lang="ts">
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL
</script>

<template>
  <section class="max-w-2xl space-y-6">
    <div class="space-y-3">
      <h1 class="text-3xl font-semibold tracking-tight text-slate-950">About</h1>
      <p class="text-base leading-7 text-slate-600">
        This shell stays free of a product domain so you can practice backend work against a stable
        frontend structure.
      </p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
      <h2 class="text-lg font-semibold text-slate-950">API base URL</h2>
      <p class="mt-2 text-sm leading-6 text-slate-600">
        The client reads
        <code class="rounded bg-slate-100 px-1.5 py-0.5 text-slate-800">VITE_API_BASE_URL</code>.
        Copy
        <code class="rounded bg-slate-100 px-1.5 py-0.5 text-slate-800">.env.example</code>
        to
        <code class="rounded bg-slate-100 px-1.5 py-0.5 text-slate-800">.env</code>
        before sending a request.
      </p>
      <p class="mt-4 text-sm text-slate-500">Configured value</p>
      <p class="mt-1 font-mono text-sm break-all text-slate-900">
        {{ apiBaseUrl || 'Not configured' }}
      </p>
    </div>
  </section>
</template>
