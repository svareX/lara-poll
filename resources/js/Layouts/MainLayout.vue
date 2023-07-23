<template>
    <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white w-full">
      <div class="container mx-auto">
        <nav class="p-4 flex items-center justify-between">
          <div class="text-lg font-medium">
            <Link :href="route('polls.index')">Polls</Link>
          </div>
          <div class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center">
            <Link :href="route('polls.index')">Lara-Poll</Link>
          </div>
          <div v-if="user" class="flex items-center gap-4">
            <div class="text-gray-500 relative pr-2 py-2 text-lg">
              <Link :href="route('polls.index')">
                🔔
                <div v-if="notificationCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
                  {{ notificationCount }}
                </div>
              </Link>
            </div>
            <Dropdown :user="user" />
          </div>
          <div v-else>
            <Link :href="route('polls.index')">Log in</Link>
          </div>
        </nav>
      </div>
    </header>

    <main class="container mx-auto p-4">
      <!-- <div v-if="flashSuccess" class="mb-4 border rounded-md shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2">
        {{ flashSuccess }}
      </div> -->
      <slot>Default</slot>
    </main>
  </template>

  <script setup>
  import { computed } from 'vue'
  import { Link, usePage } from '@inertiajs/vue3'
  import Dropdown from '@/Components/Dropdown.vue'

  const page = usePage()
  const user = computed(
    () => page.props.user,
  )
//   const flashSuccess = computed(
//     () => page.props.flash.success,
//   )

  const notificationCount = computed(
    () => Math.min(page.props.user.notificationCount, 9),
  )
  </script>
