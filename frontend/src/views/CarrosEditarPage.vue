<template>
  <div class="main-container">
    <h1>EDITAR CARRO</h1>
    <form @submit.prevent="submit" id="car-form">
      <div class="input-container">
        <label for="modelo">Modelo</label>
        <input type="text" id="modelo" name="modelo" v-model="modelo" placeholder="Digite o nome do modelo">
      </div>
      <div class="input-container">
        <label for="marca">Marca</label>
        <input type="text" id="marca" name="marca" v-model="marca" placeholder="Digite o nome da marca">
      </div>
      <div class="input-container">
        <label for="ano">Ano</label>
        <input type="text" id="ano" name="ano" v-model="ano" placeholder="Digite o ano de fabricação">
      </div>
      <div class="input-container">
        <label for="clienteId">Cliente</label>
        <input disabled type="text" id="clienteId" name="clienteId" v-model="clienteId">
      </div>
      <button id="submit-btn" type="submit">Editar</button>
      <button @click="cancel()" id="cancel-btn" type="button">Cancelar</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'CarrosCadastroPage',

  data() {
    return {
      modelo: this.$store.state.props.cars.carModel,
      marca: this.$store.state.props.cars.carBrand,
      ano: this.$store.state.props.cars.carYear,
      clienteId: this.$store.state.props.cars.carOwner
    }
  },

  created() {
  },

  methods: {
    submit() {
      console.log("modelo: "+this.modelo, "marca: "+this.marca, "ano: "+this.ano, "cliente: "+this.clienteId)
      //checagem da existência das variáveis
      if (!this.modelo || !this.marca || !this.ano || !this.clienteId) {
        alert("Preencha todos os campos corretamente.")
        return
      }

      //validação do ano
      const year = new Date().getFullYear();
      if (isNaN(this.ano) || this.ano > (year + 1) || !(this.ano > 1900)) {
        alert("Informe um ano válido.")
        return
      }

      //preenchimento de uma variável de conteúdo formulário para envio
      const formData = new FormData();
      formData.append('model', this.modelo);
      formData.append('brand', this.marca);
      formData.append('year', this.ano);
      formData.append('owner_id', this.clienteId);
      formData.append('_method', 'put')

      const idUrl = this.$store.state.props.cars.carId

      axios.post(`http://localhost/blegon/backend/api/cars/${idUrl}`, formData)
        .then(response => {
          console.log(response.data);
        })
        .catch(error => {
          console.log(error);
        });

      this.$store.dispatch('setCarsProps', {});
      this.$router.push({ name: 'CarrosPage' });
      this.$store.dispatch('bindReloadFlag');
    },
    cancel() {
      this.$store.dispatch('setCarsProps', {});
      this.$router.go(-1)
    }
  }
}

</script>

<style lang="scss" scoped>
#car-form {
  margin: 0 auto;
  border-radius: 5px;
  width: 60%;
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