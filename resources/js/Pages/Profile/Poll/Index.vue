<template>
    <Head :title="$page.props.auth.user.name + '\'s polls'"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $page.props.auth.user.name }}'s polls'</h2>
        </template>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 mx-6 md:mx-12 my-6 md:my-12">
            <div class="flex flex-col justify-center mb-8" v-for="poll in props.polls.data">
                <div class="h-5/6">
                    <div class="flex flex-col md:flex-row justify-center md:justify-around">
                        <div class="flex flex-col items-center text:xs lg:text-base md:mt-10">
                            <Link :href="route('polls.show', poll.id)" class="md:mb-2">
                                <b>{{ poll.title }}</b>
                            </Link>

                            <div v-for="option in poll.options" class="flex justify-start">
                                    <p class="mr-2">
                                        {{ option.title }} <b> - {{ option.users_count }}</b> hlasů
                                    </p>
                            </div>

                            <div class="flex justify-row pt-4 gap-4 justify-between">
                                <Link :href="route('polls.edit', poll.id)" method="get" as="button"
                                class="p-2 rounded-md border shadow-sm border-gray-300 dark:border-gray-800 hover:border-gray-400 hover:bg-gray-50 dark:hover:border-gray-700 dark:hover:bg-gray-800"
                                >
                                    Edit
                                </Link>
                                <Link :href="route('polls.destroy', poll.id)" method="delete" as="button"
                                class="p-2 rounded-md border shadow-sm border-gray-300 dark:border-gray-800 hover:border-gray-400 hover:bg-gray-50 dark:hover:border-gray-700 dark:hover:bg-gray-800"
                                >
                                    Delete
                                </Link>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex justify-center">
                                <div class="h-60 w-60">
                                    <PieChart :poll="poll"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center h-1/6 pt-6">
                    <vue-countdown :time="new Date(poll.ends_at)-now" :interval="100" v-slot="{ days, hours, minutes, seconds, milliseconds }">
                        {{ days }} days, {{ hours }} hours, {{ minutes }} minutes, {{ seconds }}.{{ Math.floor(milliseconds / 100) }} seconds left.
                    </vue-countdown>
                </div>
            </div>
        </div>

        <section v-if="polls.data.length" class="w-full flex justify-center mt-4 mb-4">
            <Pagination :links="polls.links" />
        </section>

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, Head, router } from '@inertiajs/vue3'
import PieChart from '@/Components/PieChart.vue'
import VueCountdown from '@chenfengyuan/vue-countdown';
import Pagination from '@/Components/Pagination.vue';


const props = defineProps({
    polls: Object,
})

const now = new Date();
// now.setMinutes(now.getTimezoneOffset());

Echo.private('my-channel')
    .listen('Voted', (e) => {
        router.get(
            route('polls.index', { preserveState: true, preserveScroll: true })
        )
    });
</script>

