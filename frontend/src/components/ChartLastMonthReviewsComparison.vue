<template>
  <div>
    <canvas ref="lineChart"></canvas>
  </div>
</template>

<script>
import { defineComponent } from 'vue';
import Chart from 'chart.js/auto';
import axios from 'axios';

export default defineComponent({
  data() {
    return {
      lineChart: null,
      lineData: {
        labels: [],
        datasets: [{
          label: 'Revisões nos últimos meses',
          backgroundColor: 'rgba(19, 90, 255, 0.2)',
          borderColor: 'rgba(19, 90, 255, 1)',
          borderWidth: 1,
          data: [],
          fill: false
        }]
      },
      lineOptions: {
        scales: {
          y: {
            ticks: {
              beginAtZero: true
            }
          }
        }
      }
    };
  },
  async mounted() {
    await this.fetchData();
    this.createLineChart();
  },
  methods: {
    createLineChart() {
      this.lineChart = new Chart(this.$refs.lineChart, {
        type: 'line',
        data: this.lineData,
        options: this.lineOptions
      });
    },
    async fetchData() {
      //coletando as datas deste e dos últimos 2 meses
      const thisMonthDate = new Date();
      let oneMonthAgoDate = new Date();
      let twoMonthsAgoDate = new Date();
      let threeMonthsAgoDate = new Date();
      let fourMonthsAgoDate = new Date();
      if (thisMonthDate.getMonth() == 3) {
        oneMonthAgoDate.setMonth(thisMonthDate.getMonth() - 1)
        twoMonthsAgoDate.setMonth(thisMonthDate.getMonth() - 2)
        threeMonthsAgoDate.setMonth(thisMonthDate.getMonth() - 3)
        fourMonthsAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        fourMonthsAgoDate.setMonth(11)
      } else if (thisMonthDate.getMonth() == 2) {
        oneMonthAgoDate.setMonth(thisMonthDate.getMonth() - 1)
        twoMonthsAgoDate.setMonth(thisMonthDate.getMonth() - 2)
        fourMonthsAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        fourMonthsAgoDate.setMonth(10)
        threeMonthsAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        threeMonthsAgoDate.setMonth(11)
      } else if (thisMonthDate.getMonth() == 1) {
        oneMonthAgoDate.setMonth(thisMonthDate.getMonth() - 1)
        fourMonthsAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        fourMonthsAgoDate.setMonth(9)
        threeMonthsAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        threeMonthsAgoDate.setMonth(10)
        twoMonthsAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        twoMonthsAgoDate.setMonth(11)
      } else if (thisMonthDate.getMonth() == 0) {
        fourMonthsAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        fourMonthsAgoDate.setMonth(8)
        threeMonthsAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        threeMonthsAgoDate.setMonth(9)
        twoMonthsAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        twoMonthsAgoDate.setMonth(10)
        oneMonthAgoDate.setFullYear(oneMonthAgoDate.getFullYear() - 1)
        oneMonthAgoDate.setMonth(11)
      } else {
        oneMonthAgoDate.setMonth(thisMonthDate.getMonth() - 1)
        twoMonthsAgoDate.setMonth(thisMonthDate.getMonth() - 2)
        threeMonthsAgoDate.setMonth(thisMonthDate.getMonth() - 3)
        fourMonthsAgoDate.setMonth(thisMonthDate.getMonth() - 4)
      }

      //definindo os ranges das consultas
      const thisMonthPeriod = `${thisMonthDate.getFullYear()}-${thisMonthDate.getMonth() + 1}-01_${thisMonthDate.getFullYear()}-${thisMonthDate.getMonth() + 1}-31`
      const oneMonthAgoPeriod = `${oneMonthAgoDate.getFullYear()}-${oneMonthAgoDate.getMonth() + 1}-01_${oneMonthAgoDate.getFullYear()}-${oneMonthAgoDate.getMonth() + 1}-31`
      const twoMonthsAgoPeriod = `${twoMonthsAgoDate.getFullYear()}-${twoMonthsAgoDate.getMonth() + 1}-01_${twoMonthsAgoDate.getFullYear()}-${twoMonthsAgoDate.getMonth() + 1}-31`
      const threeMonthsAgoPeriod = `${threeMonthsAgoDate.getFullYear()}-${threeMonthsAgoDate.getMonth() + 1}-01_${threeMonthsAgoDate.getFullYear()}-${threeMonthsAgoDate.getMonth() + 1}-31`
      const fourMonthsAgoPeriod = `${fourMonthsAgoDate.getFullYear()}-${fourMonthsAgoDate.getMonth() + 1}-01_${fourMonthsAgoDate.getFullYear()}-${fourMonthsAgoDate.getMonth() + 1}-31`


      let thisMonthReviews
      try {
        thisMonthReviews = await axios.get(`http://localhost/blegon/backend/api/reviews/inperiod/${thisMonthPeriod}`)
      } catch (error) {
        thisMonthReviews = {}
        console.log("O mês atual ainda não possui nenhuma revisão.")
      }
      let oneMonthAgoReviews
      try {
        oneMonthAgoReviews = await axios.get(`http://localhost/blegon/backend/api/reviews/inperiod/${oneMonthAgoPeriod}`)
      } catch (error) {
        oneMonthAgoReviews = {}
        console.log("O mês passado não possui nenhuma revisão.")
      }
      let twoMonthsAgoReviews
      try {
        twoMonthsAgoReviews = await axios.get(`http://localhost/blegon/backend/api/reviews/inperiod/${twoMonthsAgoPeriod}`)
      } catch (error) {
        twoMonthsAgoReviews = {}
        console.log("O mês retrasado não possui nenhuma revisão.")
      }
      let threeMonthsAgoReviews
      try {
        threeMonthsAgoReviews = await axios.get(`http://localhost/blegon/backend/api/reviews/inperiod/${threeMonthsAgoPeriod}`)
      } catch (error) {
        threeMonthsAgoReviews = {}
        console.log("O mês de 3 meses atrás não possui nenhuma revisão.")
      }
      let fourMonthsAgoReviews
      try {
        fourMonthsAgoReviews = await axios.get(`http://localhost/blegon/backend/api/reviews/inperiod/${fourMonthsAgoPeriod}`)
      } catch (error) {
        fourMonthsAgoReviews = {}
        console.log("O mês retrasado não possui nenhuma revisão.")
      }

      let arg1=0, arg2=0, arg3=0, arg4=0, arg5=0
      arg1 = thisMonthReviews?.data?.data ? Object.keys(thisMonthReviews.data.data).length : 0;
      arg2 = oneMonthAgoReviews?.data?.data ? Object.keys(oneMonthAgoReviews.data.data).length : 0;
      arg3 = twoMonthsAgoReviews?.data?.data ? Object.keys(twoMonthsAgoReviews.data.data).length : 0;
      arg4 = threeMonthsAgoReviews?.data?.data ? Object.keys(threeMonthsAgoReviews.data.data).length : 0;
      arg5 = fourMonthsAgoReviews?.data?.data ? Object.keys(fourMonthsAgoReviews.data.data).length : 0;

      const months = [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
      ]

      this.lineData.labels = [
        months[fourMonthsAgoDate.getMonth()],
        months[threeMonthsAgoDate.getMonth()],
        months[twoMonthsAgoDate.getMonth()],
        months[oneMonthAgoDate.getMonth()],
        'Este mês'
      ]

      this.lineData.datasets[0].data = [
        arg5, arg4, arg3, arg2, arg1
      ]
    },
  },
  beforeUnmount() {
    if (this.lineChart) {
      this.lineChart.destroy();
    }
  }
});
</script>