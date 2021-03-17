<template>
  <div>
    <ContactUs :endpoint="wpPluginUri" />
    POOP
  </div>
</template>

<script>
import ContactUs from "./views/ContactUs.vue";

export default {
  name: "App",
  components: {
    ContactUs
  },
  props: {
    wpPluginUri: String,
  },
  // mounted() {
  //   console.log(this.wpPluginUri);
  // },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
