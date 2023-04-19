<template>
  <canvas ref="chart"></canvas>
</template>

<script>
import { defineComponent } from 'vue';
import Chart from 'chart.js/auto';
import axios from 'axios';

export default defineComponent({


  data() {
    return {
      myChart: null,
      chartData: {
        labels: [],
        datasets: [{
          label: 'Número de revisões',
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1,
          data: [12, 19, 3, 5, 2, 3, 7],
        }]
      },
      chartOptions: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    };
  },
  async mounted() {
    await this.fetchData();
    this.createChart();
  },
  methods: {
    createChart() {
      this.myChart = new Chart(this.$refs.chart, {
        type: 'bar',
        data: this.chartData,
        options: this.chartOptions
      });
    },
    async fetchData() {
      const response = await axios.get('http://localhost/blegon/backend/api/reviews/brandswithmostreviews')
      const data = response.data.data
      this.chartData.labels = data.map(item => item.marca)
      this.chartData.datasets[0].data = data.map(item => item.quantidade_revisoes)
    }
  },
  beforeUnmount() {
    if (this.myChart) {
      this.myChart.destroy();
    }
  }
});
</script>