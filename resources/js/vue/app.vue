<template>
  <div>
    <router-view v-if="!loading"></router-view>
  </div>
</template>

<script>
export default {
  data(){
    return {
      loading: true
    }
  },
  async mounted(){
    const path = this.$router.history.current.path;
    if(path !== '/login' && path !== '/register'){
      await this.$store.dispatch('userInfo');
      
      //garding current page
      
    }
    this.loading = false;
  }
}
</script>

<style lang="scss">
html,body {
  margin: 0;
  height: 100%
}
body{
  background: #f7f7f7;
}
.el-header,
.el-footer {
  background-color: #b3c0d1;
  color: #333;
  text-align: center;
  line-height: 60px;
}

.el-aside {
  background-color: #d3dce6;
  color: #333;
  text-align: center;
  line-height: 200px;
}

.el-main {
  background-color: #e9eef3;
  color: #333;
  text-align: center;
  line-height: 160px;
}

body > .el-container {
  margin-bottom: 40px;
}

.el-container:nth-child(5) .el-aside,
.el-container:nth-child(6) .el-aside {
  line-height: 260px;
}

.el-container:nth-child(7) .el-aside {
  line-height: 320px;
}
</style>