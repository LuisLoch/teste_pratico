<template>
  <canvas ref="chart"></canvas>
</template>

<script>
import { defineComponent } from 'vue';
import Chart from 'chart.js/auto';

export default defineComponent({
  data() {
    return {
      myChart: null,
      chartData: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
          label: 'Sales',
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
  mounted() {
    this.createChart();
  },
  methods: {
    createChart() {
      this.myChart = new Chart(this.$refs.chart, {
        type: 'bar',
        data: this.chartData,
        options: this.chartOptions
      });
    }
  },
  beforeUnmount() {
    if (this.myChart) {
      this.myChart.destroy();
    }
  }
});
</script>