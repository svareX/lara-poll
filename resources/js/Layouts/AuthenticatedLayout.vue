<script setup>
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';

const showingNavigationDropdown = ref(false);

const page = usePage()
const flashSuccess = computed(
  () => page.props.flash.success,
)
const flashError = computed(
  () => page.props.flash.error,
)
const hidden = ref(false);

const notificationCount = ref(Math.min(page.props.auth.user.notificationCount, 9),
)
Echo.private('App.Models.User.' + page.props.auth.user.id)
    .notification((notification) => {
        if (notificationCount.value < 9) {
            notificationCount.value++;
        };
    });

function markAsRead() {
    axios.post(route('notifications.markAsRead'));
    notificationCount.value = 0;
}
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('polls.index')" :active="route().current('polls.index')">
                                    Polls
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Notifications Dropdown -->
                            <div class="ml-3 relative ">
                                <Dropdown align="right" width="48" overflow="true">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md ">
                                            <button
                                                type="button" @click="markAsRead"
                                                class="inline-flex items-center  px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                            🔔
                                            <div v-if="notificationCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
                                                {{ notificationCount }}
                                            </div>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div v-if="notificationCount">
                                            <div v-for="notification in page.props.auth.user.notifications">
                                                <DropdownLink :href="route('polls.show', notification.data.poll_id)">
                                                    <span v-if="notification.data.state == 'won'">You have won the {{ notification.data.poll_title }} poll.</span>
                                                    <span v-if="notification.data.state == 'lost'">You have lost the {{ notification.data.poll_title }} poll.</span>
                                                    <span v-if="notification.data.state == 'finished'">The {{ notification.data.poll_title }} poll has finished.</span>
                                                </DropdownLink>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <DropdownLink :href="route('polls.index')">
                                                No new notifications.
                                            </DropdownLink>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="32">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
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
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('polls.create')"> New poll </DropdownLink>
                                        <DropdownLink :href="route('users.polls.index', $page.props.auth.user.id)"> My polls </DropdownLink>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-2 space-y-1">
                        <ResponsiveNavLink :href="route('polls.index')" :active="route().current('polls.index')">
                            Polls
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Notifications Options -->
                    <div class="pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="mt-1 space-y-1">
                            <div v-if="notificationCount">
                                <div v-for="notification in page.props.auth.user.notifications">
                                        <DropdownLink :href="route('polls.show', notification.data.poll_id)">
                                            <span v-if="notification.data.state == 'won'">You have won the {{ notification.data.poll_title }} poll.</span>
                                            <span v-if="notification.data.state == 'lost'">You have lost the {{ notification.data.poll_title }} poll.</span>
                                            <span v-if="notification.data.state == 'finished'">The {{ notification.data.poll_title }} poll has finished.</span>
                                        </DropdownLink>
                                    </div>
                                </div>
                                <div v-else>
                                    <DropdownLink :href="route('polls.index')">
                                        No new notifications.
                                    </DropdownLink>
                                </div>
                            </div>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('polls.create')"> New poll </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('users.polls.index', $page.props.auth.user.id)"> My polls </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
                <div class="py-6 px-8 sm:px-12 lg:px-16">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div v-if="flashSuccess && !hidden" class="flex justify-between m-3 border rounded-md shadow-sm border-green-700 dark:border-green-800 bg-green-500 dark:bg-green-900 px-4 py-2">
                    <span class="pt-0.5">{{ flashSuccess }}</span>
                    <button type="button" @click="hidden = true" class="border border-black dark:border-white rounded-md p-0.5 px-2.5">X</button>
                </div>
                <div v-if="flashError && !hidden" class="flex justify-between m-3 border rounded-md shadow-sm border-red-700 dark:border-red-800 bg-red-500 dark:bg-red-900 px-4 py-2">
                    <span class="pt-0.5">{{ flashError }}</span>
                    <button type="button" @click="hidden = true" class="border border-black dark:border-white rounded-md p-0.5 px-2.5">X</button>
                </div>

                <slot />
            </main>
        </div>
    </div>
</template>
