<template>
  <div class="main-container">
    <ul class="reviews">
      <li class="label">
        <span class="id">Id:</span>
        <span class="carro_id">Carro:</span>
        <span class="data_review">Data:</span>
        <span class="descricao">Descrição:</span>
        <span class="preco">Preço:</span>
        <div class="actions">
          <button class="create" @click="$router.push({ name: 'ReviewsCadastroPage' })">Cadastrar</button>
        </div>
      </li>
      <hr>
      <li class="review" v-for="(review, index) in reviews" :class="{ par: !(index%2) }" v-bind:key="index">
        <span class="id">{{ review.id }}</span>
        <span class="carro_id">{{ review.carro_id }}</span>
        <span class="data_review">{{ review.data_review }}</span>
        <span class="descricao">{{ review.descricao }}</span>
        <span class="preco">{{ review.preco }}</span>
        <div class="actions">
          <button @click="updateReview(review)" class="update">Editar</button>
          <button @click="deleteReview(review.id)" class="delete">Excluir</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import axios from 'axios';
export default {
  name: 'ReviewsPage',

  created() {
    this.$store.dispatch('loadReviews');
  },

  mounted() {
    if (this.$store.state.props.reloadFlag) {
      this.$store.dispatch('bindReloadFlag');
      window.location.reload();
    }
  },

  computed: mapState([
    'reviews',
  ]),

  methods: {
    deleteReview(id) {
      if (confirm("Excluir revisão?")) {
        const formData = new FormData()
        formData.append('_method', 'delete');

        axios.post(`http://localhost/blegon/backend/api/reviews/${id}`, formData)
          .then(response => {
            console.log(response.data);
          })
          .catch(error => {
            console.log(error);
          });

        location.reload()
      }
    },
    updateReview(review) {
      this.$store.dispatch('setReviewsProps', { reviewId: review.id, reviewDate: review.data_review, reviewCarId: review.carro_id, reviewDescription: review.descricao, reviewPrice: review.preco });
      this.$router.push({ name: 'ReviewsEditarPage' })
    }
  }
}
</script>

<style lang="scss" scoped>
.reviews {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  list-style-type: none;
  padding: 0;
  width: 70%;
  border: 1px solid black;
  border-radius: 3px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
}
.review, .label {
  padding: 0.5vh 0 0.5vh;
  display: flex;
}
hr {
  margin: 0 !important;
}
span {
  padding-left: 5px;
  text-align: left;
  background-color: transparent;
}
.reviews, .review {
  span.id {
    width: 7%;
  }
  span.data_review {
    width: 12%;
  }
  span.carro_id {
    width: 7%;
  }
  span.descricao {
    width: 43%;
  }
  span.preco {
    width: 9%;
  }
  .actions {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    width: 22%;
    margin-right: 2px;
    
    
    button {
      border-radius: 5px;
      text-align: center;
      width: 49%;
      font-weight: bold;
      max-height: 30px;
      margin-left: 2%;
    }
    .delete{
      background-color: #FF4500;
    }
    .update {
      background-color: #00BFFF;
    }
    .create {
      background-color: #00FF7F;
    }
  }
}
.reviews span {
    font-weight: bold;
}
.review span {
    font-weight: 500;
    overflow: hidden;
}
.par {
  background-color: #fefefe;
}
</style>