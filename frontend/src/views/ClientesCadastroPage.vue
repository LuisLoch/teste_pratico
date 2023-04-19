<template>
  <div class="main-container">
    <h1>NOVO CLIENTE</h1>
    <form @submit.prevent="submit" id="customer-form">
      <div class="input-container">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" v-model="nome" placeholder="Digite o nome do cliente">
      </div>
      <div class="input-container">
        <label>Data de nascimento:</label>
        <VueDatePicker v-model="dataNasc" :show-time="false" :format="'yyyy-MM-dd'"/>
      </div>
      <div class="input-container">
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" v-model="sexo">
          <option value="" selected disabled>Selecione o sexo</option>
          <option value="masc">Masculino</option>
          <option value="fem">Feminino</option>
        </select>
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
  name: 'ClientesCadastroPage',

  data() {
    return {
      nome: '',
      dataNasc: '',
      sexo: ''
    }
  },

  components: {
    VueDatePicker
  },

  computed: mapState([
  ]),

  methods: {
    submit() {
      //checagem da existência das variáveis
      if (!this.nome || !this.dataNasc || !this.sexo) {
        alert("Preencha todos os campos corretamente.")
        return
      }

      //validação da data de nascimento
      const data = new Date(this.dataNasc)
      this.dataNasc = data.getFullYear() + '-'
      this.dataNasc += String(data.getMonth() + 1).padStart(2, "0") + '-'
      this.dataNasc += String(data.getDate()).padStart(2, "0")
      const data1 = new Date()
      const data2 = new Date(this.dataNasc);
      if (data1 < data2) {
        alert("Informe uma data de nascimento válida.")
        return
      }
      
      //validação do sexo
      if (this.sexo != "masc" && this.sexo != "fem") {
        alert("Informe uma data de nascimento válida.")
        return
      }

      //preenchimento de uma variável de conteúdo formulário para envio
      const formData = new FormData();
      formData.append('name', this.nome);
      formData.append('birth_date', this.dataNasc);
      formData.append('sex', this.sexo);

      axios.post('http://localhost/blegon/backend/api/customers', formData)
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
#customer-form {
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
</style>