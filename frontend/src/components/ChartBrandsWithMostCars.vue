<!-- 
Todos os carros
Todos os carros por pessoa ordenado por nome de pessoa
Informação de quem tem mais carros (homens ou mulheres )
                    Todas as marcas ordenadas pelo número de carros
Totais de marcas ordenados do maior para o menor, separados entre
homens e mulheres

Todas as pessoas
Todas as pessoas separadas por homens e mulheres ( com idade
média de homens e mulheres )

Todas as revisões dentro de um período
Marcas com maior número de revisões
Pessoas com maior número de revisões
média de tempo entre uma revisão e outra de uma mesma pessoa
Próximas revisões baseado no tempo médio baseado na última
revisão
 -->
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
          label: 'Número de carros registrados',
          backgroundColor: 'rgba(128, 255, 0, 0.2)',
          borderColor: 'rgba(128, 255, 0, 1.0)',
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
      const response = await axios.get('http://localhost/blegon/backend/api/cars/orderbrandsbycarnumber')
      const data = response.data.data
      this.chartData.labels = data.map(item => item.brand)
      this.chartData.datasets[0].data = data.map(item => item.numero_carros)
    }
  },
  beforeUnmount() {
    if (this.myChart) {
      this.myChart.destroy();
    }
  }
});
</script>