<template>
  <div class="main-container">
    <ul class="carros">
      <li class="label">
        <span class="id">Id:</span>
        <span class="modelo">Modelo:</span>
        <span class="marca">Marca:</span>
        <span class="ano">Ano:</span>
        <div class="actions">
          <button class="create" @click="$router.push({ name: 'CarrosCadastroPage' })">Cadastrar</button>
        </div>
      </li>
      <hr>
      <li class="carro" v-for="(car, index) in cars" :class="{ par: !(index%2) }" v-bind:key="index">
        <span class="id">{{ car.id }}</span>
        <span class="modelo">{{ car.modelo }}</span>
        <span class="marca">{{ car.marca }}</span>
        <span class="ano">{{ car.ano }}</span>
        <div class="actions">
          <button  class="update">Editar</button>
          <button @click="deleteCar(car.id)" class="delete">Excluir</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { useRouter } from 'vue-router'

export default {
  name: 'CarrosPage',

  computed: mapState([
    'cars',
  ]),

  methods: {
    createCar() {
      const router = useRouter()
      router.push({ name: 'CarrosCadastroPage'})
    }
  }
}
</script>

<style lang="scss" scoped>
.carros {
  display: flex;
  flex-direction: column;
  list-style-type: none;
  padding: 0;
  width: 70%;
  border: 1px solid black;
  border-radius: 3px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
}

.carro, .label {
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
  border-radius: 5px;
}

.carros, .carro {

  span.id {
    width: 7%;
  }
  span.modelo {
    width: 44%;
  }
  span.marca {
    width: 20%;
  }
  span.ano {
    width: 7%;
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

.carros span {
    font-weight: bold;
}

.carro span {
    font-weight: 500;
    overflow: hidden;
}

.par {
  background-color: #fefefe;
}
</style>
