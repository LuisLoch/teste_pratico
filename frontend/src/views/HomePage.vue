<!-- 
                    Todos os carros
Todos os carros por pessoa ordenado por nome de pessoa
Informação de quem tem mais carros (homens ou mulheres )
                    Todas as marcas ordenadas pelo número de carros - gráfico de colunas
Totais de marcas ordenados do maior para o menor, separados entre
homens e mulheres

                    Todas as pessoas
Todas as pessoas separadas por homens e mulheres ( com idade
média de homens e mulheres )

                    Todas as revisões dentro de um período - ChartLastMonthReviewsComparison - linhas
                    Marcas com maior número de revisões - ChartBrandsWithMostReviews - colunas
                    Pessoas com maior número de revisões
média de tempo entre uma revisão e outra de uma mesma pessoa
Próximas revisões baseado no tempo médio baseado na última
revisão
 -->

<template>
  <div class="main-container">
    <div class="grid-container">
      <div class="chart-container">
        <ChartLastMonthReviewsComparison />
      </div>
      <div class="chart-container">
        <ChartBrandsWithMostCars />
      </div>
      <div class="chart-container">
        <ChartBrandsWithMostReviews />
      </div>
      <div class="chart-container">
        <ChartCarsByGender />
      </div>
      <div class="chart-container">
        <ChartBiggerCustomers />
      </div>
      <div class="chart-container">
        <ChartExample />
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import ChartExample from '@/components/ChartExample.vue'
import ChartBrandsWithMostCars from '@/components/ChartBrandsWithMostCars.vue';
import ChartBrandsWithMostReviews from '@/components/ChartBrandsWithMostReviews.vue';
import ChartCarsByGender from '@/components/ChartCarsByGender.vue'
import ChartLastMonthReviewsComparison from '@/components/ChartLastMonthReviewsComparison.vue'
import ChartBiggerCustomers from '@/components/ChartBiggerCustomers.vue';

export default {
  name: 'HomePage',

  components: {
    ChartExample,
    ChartBrandsWithMostCars,
    ChartBrandsWithMostReviews,
    ChartCarsByGender,
    ChartLastMonthReviewsComparison,
    ChartBiggerCustomers
},

  computed: mapState([
  ]),

  methods: {
  },

  oncreate() {      
  },
}
</script>

<style scoped>
.grid-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: 1fr;
  grid-gap: 1rem;
}
</style>
