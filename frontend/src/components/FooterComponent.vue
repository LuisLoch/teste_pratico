<template>
  <div id="footer">
    <p>
      Blegon &copy; 2023
    </p>
  </div>
</template>

<script>
export default {
  name: "FooterComponent",
}

</script>

<style scoped>
  #footer {
    height: 60px;
    background-color: #efefef;
    border-top: 2px solid #777;
    color: #444;
    display: flex;
    align-items: center;
    justify-content: center;
    bottom: 0;
    width: 100%;
  }
</style>
