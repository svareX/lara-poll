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
import { Head } from '@inertiajs/vue3'

defineProps({
    poll: Object,
})
</script>
