<template>
    <Head title="Ongoing polls"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Currently ongoing polls</h2>
        </template>

        <div class="mx-6 md:mx-12 my-6 md:my-12">
            <div v-if="props.polls.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 ">
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
                                        <div v-if="canVote(poll)">
                                            <Link :href="route('polls.vote', [poll.id, option.id])" method="post">Hlasovat</Link>
                                        </div>
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
            <div v-else>
                <div class="mt-20 sm:mt-24 md:mt-32 lg:mt-48 text-center">
                    <h1 class="text-6xl font-bold my-2">We are very sorry however</h1>
                    <h2 class="text-5xl my-2 mb-10">there are no ongoing polls currently...</h2>
                    <Link :href="route('polls.create')" class="btn-primary text-3xl">Create a new poll!</Link>
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
import { Link, Head, usePage } from '@inertiajs/vue3'
import PieChart from '@/Components/PieChart.vue'
import VueCountdown from '@chenfengyuan/vue-countdown';
import Pagination from '@/Components/Pagination.vue'
import { defineProps } from 'vue'

const page = usePage()
const props = defineProps({
    polls: Object,
    history: Object,
})

const now = new Date();
// now.setMinutes(now.getTimezoneOffset());

function canVote(poll) {
    if (page.props.auth.user.id == poll.user_id) {
        return false;
    }
    return !poll.voted;
}
</script>
