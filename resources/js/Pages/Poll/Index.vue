<template>
    <Head title="Last 10 polls"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Polls</h2>
        </template>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mx-6 md:mx-12 my-6 md:my-12">
            <div class="flex flex-col md:flex-row justify-center mb-8" v-for="poll in props.polls">
                <div class="flex flex-col items-center md:mr-10 md:mt-10">
                    <Link :href="route('polls.show', poll.id)" class="md:mb-4">
                        <b>{{ poll.title }}</b>
                    </Link>
                    <div v-for="option in poll.options" class="flex justify-start">
                            <p class="mr-2">
                                {{ option.title }} <b> - {{ option.users_count }}</b> hlasů
                            </p>
                            <Link :href="route('polls.vote', [poll.id, option.id])" method="post">Hlasovat</Link>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="ml-10 h-60 w-60">
                        <PieChart :poll="poll"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, Head, router } from '@inertiajs/vue3'
import PieChart from '@/Components/PieChart.vue'
const props = defineProps({
    polls: Object,
})

Echo.private('my-channel')
    .listen('Voted', (e) => {
        router.get(
            route('polls.index', { preserveState: true, preserveScroll: true })
        )
        // TODO: FIND A WAY TO UPDATE DATA WITHOUT REFRESHING THE ENTIRE PAGE
        // console.log(e.message.map(message => message.users_count));
        // PieChart.chartData.datasets[0].data = e.message.map(message => message.users_count);

    });
</script>
