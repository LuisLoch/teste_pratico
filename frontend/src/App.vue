<template>
  <div id="app">
    <div>
      <NavBar />
      <router-view />
    </div>
    <FooterComponent />
  </div>
</template>

<script>
import { mapState } from 'vuex';
import NavBar from '@/components/NavBar.vue'
import FooterComponent from '@/components/FooterComponent.vue'

export default {
  components: {
    NavBar,
    FooterComponent
  },
  computed: mapState([
  ]),
  created() {
    this.$store.dispatch('loadCars');
    this.$store.dispatch('loadCustomers');
    this.$store.dispatch('loadReviews');
  },
}

</script>

<style scoped>
/* estilo global do app */
#app {
  font-family: sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  background-color: #efefef;
}

/* estilo global das páginas */
.main-container {
  min-height: calc(100vh - 125px);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: top;
}
</style>
