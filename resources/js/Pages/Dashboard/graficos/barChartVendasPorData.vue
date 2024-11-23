<template>
  <label>{{ this.Label }}</label>
    <Bar
      id="my-chart-id"
      :options="chartOptions"
      :data="chartData"
    />
  </template>
  
  <script>
  import { Bar } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
  
  ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)
  
  export default {
    name: 'BarChart',
    components: { Bar },
    props:{
        DataInicial: Object,
        DataFinal: Object,
        Dados: Array
    },
    data() {
      return {
        chartData: {
          labels: this.labels,
          datasets: [ {
            backgroundColor: this.Colors, 
            label: this.labels,
            data: this.data } ]
        },
        chartOptions: {
          responsive: true
        }
      }
    },

  }
  </script>