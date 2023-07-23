<template>
    <div>
      <div class="relative">
        <!-- Dropdown toggle button -->
        <button
          class="flex items-center p-2"
          @click="isOpen"
        >
          <span class="mr-4">{{ user.name }}</span>
          <svg
            class="w-5 h-5 text-indigo-100 dark:text-white"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>

        <!-- Dropdown menu -->
        <div
          v-show="show"
          class="absolute right-0 py-2 mt-2 bg-gray-50 dark:bg-gray-800 rounded-md shadow-xl  w-36"
        >
          <Link :href="route('realtor.listing.create')" class="block w-full text-center px-4 py-2 text-sm hover:bg-gray-200 hover:dark:bg-gray-700">
            Create listing
          </Link>
          <Link :href="route('realtor.listing.index')" class="block w-full text-center px-4 py-2 text-sm hover:bg-gray-200 hover:dark:bg-gray-700">
            Manage listings
          </Link>
          <Link :href="route('logout')" method="delete" as="button" class="block w-full text-center px-4 py-2 text-sm hover:bg-gray-200 hover:dark:bg-gray-700">
            Log out
          </Link>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { Link } from '@inertiajs/vue3'
  defineProps({
    user: Object,
  })
  let show = ref(false)
  const isOpen = () => (show.value = !show.value)
  </script>
