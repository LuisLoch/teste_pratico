<template>
  <div class="main-container">
    <ul class="customers">
      <li class="label">
        <span class="id">Id:</span>
        <span class="nome">Nome:</span>
        <span class="data_nasc">Data nasc:</span>
        <span class="sexo">Sexo:</span>
        <div class="actions">
          <button class="create" @click="$router.push({ name: 'ClientesCadastroPage' })">Cadastrar</button>
        </div>
      </li>
      <hr>
      <li class="customer" v-for="(customer, index) in customers" :class="{ par: !(index % 2) }" v-bind:key="index">
        <span class="id">{{ customer.id }}</span>
        <span class="nome">{{ customer.nome }}</span>
        <span class="data_nasc">{{ customer.data_nasc }}</span>
        <span class="sexo">{{ customer.sexo }}</span>
        <div class="actions">
          <button @click="createCarWithCustomer(customer.id)" class="create">+Carro</button>
          <button @click="updateCustomer(customer)" class="edit">Editar</button>
          <button @click="deleteCustomer(customer.id)" class="delete">Excluir</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import axios from 'axios';

export default {
  name: 'ClientesPage',

  created() {
    this.$store.dispatch('loadCustomers');
  },

  mounted() {
    if (this.$store.state.props.reloadFlag) {
      this.$store.dispatch('bindReloadFlag');
      window.location.reload();
    }
  },

  computed: mapState([
    'customers',
  ]),

  methods: {
    createCarWithCustomer(id) {
      this.$store.dispatch('setCarsProps', { customerId: id });
      this.$router.push({ name: 'CarrosCadastroPageComCliente' })
    },
    deleteCustomer(id) {
      if (confirm("Excluir cliente?")) {
        const formData = new FormData()
        formData.append('_method', 'delete');

        axios.post(`http://localhost/blegon/backend/api/customers/${id}`, formData)
          .then(response => {
            console.log(response.data);
          })
          .catch(error => {
            console.log(error);
          });

        location.reload()
      }
    },
    updateCustomer(customer) {
      this.$store.dispatch('setCustomersProps', { customerId: customer.id, customerName: customer.nome, customerBirth: customer.data_nasc, customerSex: customer.sexo });
      this.$router.push({ name: 'ClientesEditarPage' })
    }
  }
}
</script>

<style lang="scss" scoped>
.customers {
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

.customer,
.label {
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

.customers,
.customer {

  span.id {
    width: 7%;
  }

  span.nome {
    width: 40%;
  }

  span.data_nasc {
    width: 12%;
  }

  span.sexo {
    width: 7%;
  }

  .actions {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    width: 34%;
    margin-right: 2px;

    button {
      border-radius: 5px;
      text-align: center;
      width: 33%;
      font-weight: bold;
      max-height: 30px;
      margin-left: 1%;
    }

    .delete {
      background-color: #FF4500;
    }

    .edit {
      background-color: #00BFFF;
    }

    .create {
      background-color: #00FF7F;
    }
  }
}

.customers span {
  font-weight: bold;
}

.customer span {
  font-weight: 500;
  overflow: hidden;
}

.par {
  background-color: #fefefe;
}</style>
