<template>
    <Head title="Last 10 polls"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Polls</h2>
        </template>

        <div class="w-full text-center my-10">
            <div v-for="poll in props.polls" class="flex flex-col gap-4">
                <div>
                    <Link :href="route('polls.show', poll.id)">
                        <b>{{ poll.title }}</b> #{{ poll.id }}
                    </Link>
                    <div v-for="option in poll.options">
                        <p class="mx-4">
                            {{ option.title }} <b>{{ option.users_count }}</b> hlasů
                            <Link :href="route('polls.vote', [poll.id, option.id])" method="post">Hlasovat</Link>
                        </p>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="h-64 w-64">
                        <PieChart :poll="poll"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, Head } from '@inertiajs/vue3'
import PieChart from '@/Components/PieChart.vue'
const props = defineProps({
    polls: Object,
})
</script>
