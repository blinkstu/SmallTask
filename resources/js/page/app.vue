<template>
  <div>
    <router-view v-if="!loading"></router-view>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: true
    }
  },
  async mounted() {
    const path = this.$router.history.current.path;
    if (path !== '/login' && path !== '/register') {
      await this.$store.dispatch('userInfo').catch(err => {
        this.$router.push('/login');
      })
    }
    this.loading = false;
  }
}
</script>

<style lang="scss">
.form-inline{
  color: white;
}

/* Sticky footer styles
-------------------------------------------------- */
html {
  position: relative;
  min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 60px;
  line-height: 60px; /* Vertically center the text there */
  background-color: #f5f5f5;
}


/* Custom page CSS
-------------------------------------------------- */
/* Not required for template or sticky footer method. */

body > .container {
  padding: 60px 15px 0;
}

.footer > .container {
  padding-right: 15px;
  padding-left: 15px;
}

code {
  font-size: 80%;
}
</style>