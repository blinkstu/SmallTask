<template>
  <div>
    <button @click="start">test</button>
    <button @click="logout">logout</button>
  </div>
</template>


<script>
export default {
  mounted(){
    const user = this.$store.state.user;
    if(user.role == 'admin'){
      this.$router.push('dashboard/admin')
    } else {
      this.$router.push('dashboard/client')
    }
  },
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