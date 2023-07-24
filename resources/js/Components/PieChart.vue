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
</script>

<script>
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale)

export default {
    name: 'PieChart',
    components: { Pie },
    data(props) {
      return {
        chartData: {
        //   labels: props.poll.options.map(option => option.title),
          datasets: [{
            data: props.poll.options.map(option => option.users_count),
            backgroundColor: props.poll.options.map(option => option.color),
            }]
        },
        chartOptions: {
          responsive: true,
        //   plugins: {
        //     title: {
        //         display: true,
        //         text: props.poll.title,
        //     }
        //   }
        }
      }
    }
}
</script>
