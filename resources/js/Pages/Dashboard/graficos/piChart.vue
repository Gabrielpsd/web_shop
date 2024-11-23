<template>
   <label>{{ this.Label }}</label>
    <Pie
      id="my-chart-id"
      :options="chartOptions"
      :data="chartData"
    />
  </template>
  
  <script>
  import { Pie } from 'vue-chartjs'
  import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
  
  ChartJS.register(ArcElement, Tooltip, Legend)
  
  export default {
    name: 'PieChart',
    components: { Pie },
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
          responsive: true
        }
      }
    }
  }
  </script>