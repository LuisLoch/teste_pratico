<template>
  <div>
    <canvas ref="chart"></canvas>
  </div>
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
        datasets: [
          {
            label: '',
            data: [
              {},
            ],
            backgroundColor: 'rgba(0, 0, 255, 0.2)',
            borderColor: 'rgba(0, 0, 255, 1)',
            borderWidth: 1,
          },
          {
            label: '',
            data: [
              {},
            ],
            backgroundColor: 'rgba(255, 192, 203, 0.2)',
            borderColor: 'rgba(255, 99, 0, 1)',
            borderWidth: 1,
          },
          {
            label: '',
            data: [
              {},
            ],
            backgroundColor: 'rgba(0, 102, 0, 0.2)',
            borderColor: 'rgba(0, 102, 0, 1)',
            borderWidth: 1,
          },
        ],
      },
      chartOptions: {
        scales: {
          y: {
            beginAtZero: true,
          },
          x: {
            beginAtZero: true,
          },
        },
      },
    };
  },
  async mounted() {
    await this.fetchData()
    this.createChart();
  },
  methods: {
    createChart() {
      this.myChart = new Chart(this.$refs.chart, {
        type: 'bubble',
        data: this.chartData,
        options: this.chartOptions,
      });
    },
    async fetchData() {
      const response = await axios.get('http://localhost/blegon/backend/api/cars/whatsexhasmorecars')
      const data = response.data
      this.chartOptions.scales.x.max = (data.data[0].numero_carros + data.data[1].numero_carros)/1.5
      this.chartOptions.scales.y.max = (data.data[0].numero_carros + data.data[1].numero_carros)/1.5
      this.chartData.datasets[0].label = 'Homens'
      this.chartData.datasets[0].data = [{ x: 5, y: 10, r: data.data[0].numero_carros}]
      this.chartData.datasets[1].label = 'Mulheres'
      this.chartData.datasets[1].data = [{ x: 10, y: 10, r: data.data[1].numero_carros}]
      this.chartData.datasets[2].label = 'Total'
      this.chartData.datasets[2].data = [{ x: 15, y: 10, r: (data.data[0].numero_carros + data.data[1].numero_carros)}]
      console.log(data.data)
    }
  },
  beforeUnmount() {
    if (this.myChart) {
      this.myChart.destroy();
    }
  },
});
</script>