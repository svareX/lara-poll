<template>
        <Pie
          id="PieChart"
          :options="chartOptions"
          :data="chartData"
        />
</template>

<script setup>
const props = defineProps({
    poll: Object,
})
Echo.private('poll.' + props.poll.id)
    .listen('Voted', (e) => {
        props.poll.options.map(option => option.id === e.option.id ? option.users_count++ : option.users_count);
    }
);
</script>

<script>
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale)

export default {
    name: 'PieChart',
    components: { Pie },
    computed: {
      chartData() { return {
        labels: this.poll.options.map(option => option.title),
        datasets: [{
          data: this.poll.options.map(option => option.users_count).every(item => item === 0) ? this.poll.options.map(option => option.users_count+1) : this.poll.options.map(option => option.users_count),
          backgroundColor: this.poll.options.map(option => option.color),
        }]
      } },
      chartOptions() { return {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: this.poll.title,
          }
        }
      } }
    }
}
</script>
