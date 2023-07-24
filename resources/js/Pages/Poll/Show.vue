<template>
    <Head :title="poll.title"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ poll.title }}</h2>
        </template>

        <div class="flex justify-center mt-12">
            <div class="h-96 w-96">
                <PieChart :poll="poll"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import PieChart from '@/Components/PieChart.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

const props = defineProps({
    poll: Object,
})
Echo.private('my-channel')
    .listen('Voted', (e) => {
        router.get(
            route('polls.show', props.poll.id, { preserveState: true, preserveScroll: true })
        )
        // TODO: FIND A WAY TO UPDATE DATA WITHOUT REFRESHING THE ENTIRE PAGE
        // console.log(e.message.map(message => message.users_count));
        // PieChart.chartData.datasets[0].data = e.message.map(message => message.users_count);

    });
</script>
