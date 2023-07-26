<template>
    <div class="mx-2 flex gap-1 relative inset-x-0 bottom-0 md:bottom-4 justify-center">
      <Link
        v-for="(link, index) in links"
        :key="index" class="py-2 px-4 rounded-md"
        :href="link.url"
        :class="{'bg-indigo-500 dark:bg-indigo-800 text-gray-300': link.active}"
        v-html="link.label"
      />
    </div>
  </template>

  <script setup>
  import {Link} from '@inertiajs/vue3'
  defineProps({links: Array})
  </script>
