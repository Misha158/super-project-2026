<script setup lang="ts">
import { ref, watch } from 'vue'
import { RouterLink, useRoute } from 'vue-router'

const route = useRoute()
const isMenuOpen = ref(false)

const links = [
  { to: '/', label: 'Home' },
  { to: '/about', label: 'About' },
] as const

watch(
  () => route.fullPath,
  () => {
    isMenuOpen.value = false
  },
)

function toggleMenu(): void {
  isMenuOpen.value = !isMenuOpen.value
}
</script>

<template>
  <header class="relative border-b border-slate-200 bg-white">
    <div
      class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8"
    >
      <RouterLink
        to="/"
        class="flex items-center gap-2 font-semibold tracking-tight text-slate-900"
      >
        <img alt="" class="size-8" height="32" src="@/assets/logo.svg" width="32" />
        <span>Super Project</span>
      </RouterLink>

      <button
        type="button"
        class="rounded-md border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 sm:hidden"
        :aria-expanded="isMenuOpen"
        aria-controls="site-navigation"
        @click="toggleMenu"
      >
        {{ isMenuOpen ? 'Close' : 'Menu' }}
      </button>

      <nav
        id="site-navigation"
        aria-label="Main"
        class="sm:block"
        :class="
          isMenuOpen
            ? 'absolute inset-x-0 top-full z-10 border-b border-slate-200 bg-white px-4 py-3 sm:static sm:z-auto sm:border-0 sm:bg-transparent sm:p-0'
            : 'hidden'
        "
      >
        <ul class="flex flex-col gap-1 sm:flex-row sm:items-center sm:gap-2">
          <li v-for="link in links" :key="link.to">
            <RouterLink v-slot="{ href, navigate, isExactActive }" :to="link.to" custom>
              <a
                :href="href"
                class="block rounded-md px-3 py-2 text-sm font-medium"
                :class="
                  isExactActive
                    ? 'bg-slate-900 text-white'
                    : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                "
                :aria-current="isExactActive ? 'page' : undefined"
                @click="navigate"
              >
                {{ link.label }}
              </a>
            </RouterLink>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>
