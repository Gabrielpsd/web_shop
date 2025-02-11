<template>
    <label>{{ this.Label }}</label>
    <Doughnut
    id="my-chart-id"
    :options="chartOptions"
    :data="chartData"
    />
  </template>
  
  <script>

  import { Doughnut } from 'vue-chartjs'
  import { Chart as ChartJS, Tooltip,ArcElement, Legend } from 'chart.js'

  ChartJS.register(ArcElement, Tooltip, Legend)

  export default {
    name: 'graficoDonut',
    components: { Doughnut },
    props:{
        data: Array,
        labels: Array,
        Label: String,
        Colors: Array
    },
    data() {
      return {
        chartData: {
          labels: this.labels,
          datasets: [ {
            backgroundColor: this.Colors, 
            label: this.Label,
            data: this.data } ]
        },
        chartOptions: {
          responsive: true,
        }
      }
    }
  }
  </script>

<style scoped>
label{
  justify-self: center;
}
</style>