<template>
  <div>
    <button @click="start">test</button>
    <button @click="logout">logout</button>
  </div>
</template>


<script>
export default {
  methods: {
    start(){
      this.$http.get('/auth/me');
    },
    logout(){
      this.$store.dispatch('logout');
    }
  }
}
</script>