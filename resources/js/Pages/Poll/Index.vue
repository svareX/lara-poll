<template>
    <div class="w-full text-center my-10">
        <div class="flex flex-col gap-4">
            <div v-for="poll in props.polls">
                <p><b>{{ poll.title }}</b> #{{ poll.id }}</p>
                <div v-for="option in poll.options">
                    <p class="mx-4">
                        {{ option.title }} <b>{{ option.users_count }}</b> hlasů
                        <Link :href="route('polls.vote', [poll.id, option.id])" method="post">Hlasovat</Link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({
    polls: Object,
})
</script>
