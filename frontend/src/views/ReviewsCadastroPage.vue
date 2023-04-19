<template>
  <div class="main-container">
    <h1>NOVA REVISÃO</h1>
    <form @submit.prevent="submit" id="review-form">
      <div class="input-container">
        <label for="carro">revisao</label>
        <select id="carro" name="carro" v-model="carroId">
          <option value="" selected disabled>Selecione o carro</option>
          <option v-for="(car, index) in cars" :key="index" :class="{ par: (index % 2) }" :value="car.id">
            {{ car.modelo+" - "+customers.find((customer) => car.dono == customer.id).nome }}
          </option>
        </select>
      </div>
      <div class="input-container">
        <label>Data da revisão:</label>
        <VueDatePicker v-model="data" :show-time="false" :format="'yyyy-MM-dd'" />
      </div>
      <div class="input-container">
        <label for="nome">Descrição</label>
        <!-- <input type="text" id="nome" name="nome" v-model="nome" placeholder="Digite o nome do revisao"> -->
        <textarea name="descricao" id="descricao" v-model="descricao" placeholder="Quais foram os serviços prestados?"></textarea>
      </div>
      <div class="input-container">
        <label for="preco">Preço:</label>
        <input type="text" id="preco" name="preco" v-model="preco" placeholder="Digite o preço">
      </div>
      <button id="submit-btn" type="submit">Cadastrar</button>
      <button @click="$router.go(-1)" id="cancel-btn" type="button">Cancelar</button>
    </form>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import axios from 'axios';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
  name: 'ReviewsCadastroPage',

  data() {
    return {
      carroId: '',
      data: '',
      descricao: '',
      preco: ''
    }
  },

  components: {
    VueDatePicker
  },

  computed: mapState([
    'cars', 'customers'
  ]),

  methods: {
    submit() {
      //checagem da existência das variáveis
      if (!this.carroId || !this.data || !this.descricao || !this.preco) {
        alert("Preencha todos os campos corretamente.")
        return
      }

      //validação da data de nascimento
      const data = new Date(this.data)
      this.data = data.getFullYear() + '-'
      this.data += String(data.getMonth() + 1).padStart(2, "0") + '-'
      this.data += String(data.getDate()).padStart(2, "0")
      const data1 = new Date()
      const data2 = new Date(this.data);
      if (data1 < data2) {
        alert("Informe uma data válida.")
        return
      }

      //formatação do preço
      this.preco = this.preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
      if(isNaN(this.preco)){
        alert("Informe um valor de preço válido.")
        return
      }
      
      //preenchimento de uma variável de conteúdo formulário para envio
      const formData = new FormData();
      formData.append('date_review', this.data);
      formData.append('car_id', this.carroId);
      formData.append('description', this.descricao);
      formData.append('price', this.preco);

      axios.post('http://localhost/blegon/backend/api/reviews', formData)
        .then(response => {
          console.log(response.data);
        })
        .catch(error => {
          console.log(error);
        });

      location.reload()
    }
  }
}

</script>

<style lang="scss" scoped>
#review-form {
  margin: 0 auto;
  border-radius: 5px;
}

.input-container {
  display: flex;
  flex-direction: column;
  margin-bottom: 1vh;
}

label {
  font-weight: bold;
  height: 30px;
  margin-bottom: 15px;
  color: #222;
  padding: 5px 10px;
  border-left: 4px solid black;
}

input,
select {
  padding: 5px 10px;
}

h1 {
  width: 90%;
  text-align: center;
  border-bottom: 1px solid;
  padding-bottom: 5px;
  margin-bottom: 20px;
}

#submit-btn {
  background-color: #98FB98;
  margin-top: 10px;
  width: 100%;
  border-radius: 5px;
  font-weight: bold;
}

#cancel-btn {
  background-color: #FF6347;
  margin-top: 5px;
  width: 100%;
  border-radius: 5px;
  font-weight: bold;
}

.par {
  background-color: #fff;
}
</style>