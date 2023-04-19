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
          label: 'Três maiores clientes',
          backgroundColor: 'rgba(200, 200, 0, 0.2)',
          borderColor: 'rgba(200, 200, 0, 1)',
          borderWidth: 1,
          data: [],
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
      const response = await axios.get('http://localhost/blegon/backend/api/reviews/customerswithmostreviews')
      const data = response.data.data
      const limitedData = data.slice(0, 3)
      this.chartData.labels = [limitedData[1].nome,limitedData[0].nome,limitedData[2].nome]
      this.chartData.datasets[0].data = [limitedData[1].quantidade_revisoes,limitedData[0].quantidade_revisoes,limitedData[2].quantidade_revisoes]
    }
  },
  beforeUnmount() {
    if (this.myChart) {
      this.myChart.destroy();
    }
  }
});
</script>