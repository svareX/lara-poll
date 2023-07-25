<template>
    <Head title="Edit a poll" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit the '{{ poll.title }}' poll</h2>
        </template>
        <div>
            test
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
    poll: Object,
})
</script>
