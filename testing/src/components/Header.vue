<template>
  <header>
    <!-- navbar com class container, que tem largura de 90% da tela -->
    <nav class="container">

      <!-- div de itens do lado esquerdo da navbar, com botão home, input de busca e botão para realizar a busca -->
      <div class="lado_esquerdo">
        <a href="/">
          <img id='home_button' src="../images/home.png" alt="home">
        </a>
        <div class="search">
          <input id="search_input" v-model="message" placeholder="Pesquisar">
          <a href="/">
            <img id="magnify_button" src="../images/magnifying_glass.png" alt="magnify_button">
          </a>
        </div>
      </div>

      <!-- div de itens do lado direito da navbar, com botão de perfil de usuário -->
      <div class="lado_direito">
          <img id='profile_button' src="../images/user_profile.png" alt="home" v-on:click="openProfile">
      </div>
    </nav>

    <!-- overlay que "escurece a parte de trás da tela", para dar foco à tela de perfil de usuário -->
    <div id="menu_overlay_top" v-if="profileActive" v-on:click="closeProfile"></div>
    <div id="menu_overlay_bottom" v-if="profileActive" v-on:click="closeProfile"></div>
    <div id="menu_overlay_left" v-if="profileActive" v-on:click="closeProfile"></div>
    <div id="menu_overlay_right" v-if="profileActive" v-on:click="closeProfile"></div>

    <!-- pop-up de perfil de usuário -->
    <div id="user_profile" :class="{active:profileActive}">
      <p>User profile</p>
    </div>
  </header>
</template>

<script>
export default {
  name: 'Header',
  // Método responsável por inicialmente esconder o pop-up de perfil
  data() {
    return {
      profileActive: false
    }
  },
  // Método responsável por ativar ou desativar o pop-up de perfil
  methods:{
    openProfile: function() {
      this.profileActive = true;
    },
    closeProfile: function() {
      this.profileActive = false;
    }
  },
  // Método responsável por validar se entrou um usuário válido ou não
  getUser() {

  }
}
</script>

<style scoped>
header,
.search,
.lado_esquerdo,
.lado_direito {
  display: flex;
  align-items: center;
  justify-content: center;
}

header {
  background-color: var(--color-background-nav);
  border-radius: 5px;
  height: 65px;
  width: 80%;
  margin: 10px 10% 20px;
  justify-content: space-between;
}

nav {
  display: flex;
  align-items: center;
}

ul {
  list-style: none;
  text-align: center;
}

ul li {
  margin: 20px 0;
}
.search {
  margin-left: 15px;
  height: 40px;
}

.lado_esquerdo {
  margin-left: 10px;
  justify-content: flex-end;
}

#home_button {
  width: 40px;
}

#magnify_button {
  padding-top: 3px;
  width: 25px;
}

#search_input {
  height: 30px;
}

.container {
  display: flex;
  justify-content: space-between;
}

.lado_direito {
  align-items: center;
  justify-content: flex-end;
  margin-right: -50px;
}

#profile_button {
  width: 40px;
}

#profile_button:hover {
  cursor: pointer;
}


/* POP-UP DE PERFIL DE USUÁRIO */
#user_profile {
  position: fixed;
  top: 20%;
  left: 30%;
  background-color: #FFFFFF;
  width: 40%;
  height: 60%;
  flex-direction: column;
  align-items: center;

  display: none;
}

#user_profile.active {
  display: flex;
}


/* OVERLAY DE TELA DE PERFIL DE USUÁRIO */
#menu_overlay_top,
#menu_overlay_bottom,
#menu_overlay_left,
#menu_overlay_right {
  position: fixed;
  height: 100vh;
  background-color: #000;
  opacity: 50%;
}

#menu_overlay_top {
  width: 70%;
  height: 20%;
  top: 0;
  left: 0;
}

#menu_overlay_bottom {
  width: 70%;
  height: 20%;
  bottom: 0;
  right: 0;
}

#menu_overlay_left {
  width: 30%;
  height: 80%;
  bottom: 0;
  left: 0;
}

#menu_overlay_right {
  width: 30%;
  height: 80%;
  right: 0;
  top: 0;
}</style>