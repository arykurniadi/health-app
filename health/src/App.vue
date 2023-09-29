<template>
  <div id="app" style="border:3px solid red">
    <Layout />
  </div> 
</template>

<script>
import Layout from './components/layout/Layout.vue';

export default {
  name: "MyAppVue2",
  
  components: {
    Layout,
  },
}
</script>