<template>
  <div id="nav">
    <router-link to="/" id="home_url">
      <img src="@/images/home.png" alt="home" id="home">
    </router-link>
    <router-link to="/">
      Início
    </router-link>
    <router-link to="/customers">
      Clientes
    </router-link>
    <router-link to="/cars">
      Carros
    </router-link>
    <router-link to="/reviews">
      Reviews
    </router-link>
  </div>
</template>

<script>
export default {
  name: "NavBar",
}

</script>

<style scoped>
/* estilo da imagem */
img {
  width: 35px;
  height: 35px;
}

/* estilo da navbar */
#nav {
  background-color: #fff;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
  height: 65px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  width: 90%;
  margin: 0 5% 2vh;
}

/* estilo dos itens da navbar */
#nav a {
  color: #777;
  text-decoration: none;
  margin: 10px;
  transition: 0.3s;
}

#nav a:hover {
  color: black;
}

#nav #home_url {
  margin: auto;
  margin-left: 8px;
}
</style>
