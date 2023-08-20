<template>
    <Head :title="'Viewing poll - ' + poll.title"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ poll.title }}</h2>
        </template>

        <div class="flex flex-col xl:flex-row justify-between mx-6 xl:mx-12 my-6 xl:my-10">
            <div class="flex flex-col justify-center items-center lg:mb-10 lg:mt-16">
                    <h2 class="text-4xl font-bold truncate">{{ poll.title }}</h2>
                <div v-for="option in poll.options" class="flex justify-start">
                        <p class="mr-2 text-lg">
                            {{ option.title }} <b> - {{ option.users_count }}</b> hlasů
                        </p>
                        <div v-if="canVote()">
                            <Link :href="route('polls.vote', [poll.id, option.id])" method="post">Hlasovat</Link>
                        </div>
                </div>
            </div>
                <div class="flex justify-center w-full xl:w-1/3">
                    <div class="w-full lg:w-1/3 xl:w-full">
                        <div class="my-4 w-full">
                            <PieChart :poll="poll"/>
                        </div>
                    </div>
                </div>
            <div class="flex flex-col justify-center overflow-y-auto max-h-[45rem] text-center">
                <p v-for="vote in history">
                    <span>
                        {{ new Date(vote.created_at).getDate() }}.{{ new Date(vote.created_at).getMonth() }}.{{ new Date(vote.created_at).getFullYear() }}
                        ve
                        {{ new Date(vote.created_at).getHours() }}:{{ new Date(vote.created_at).getMinutes() }}:{{ new Date(vote.created_at).getSeconds() }}
                    </span>
                    <span class="pl-1">
                        {{ vote.user.name }} hlasoval pro možnost
                    </span>
                    <span>
                        {{ vote.option.title }}
                    </span>
                </p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import PieChart from '@/Components/PieChart.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, usePage, Link } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const props = defineProps({
    poll: Object,
    history: Object,
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

function canVote() {
    if (page.props.auth.user.id == props.poll.user_id) {
        return false;
    }
    if (props.history.map(vote => vote.user_id).includes(page.props.auth.user.id)) {
        return false;
    }
    return true;
}
</script>
