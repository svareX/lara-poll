<template>
    {{ poll.title }}
    <PieChart :poll="poll"/>
</template>

<script setup>
import PieChart from '@/Components/PieChart.vue'

defineProps({
    poll: Object,
})
</script>
