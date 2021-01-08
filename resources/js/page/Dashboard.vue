<template>
  <div>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" v-if="role == 'admin'">Консоль</a>
        <a class="navbar-brand" v-else>Личный Кабинет</a>

        <el-dropdown @command="logout">
          <span class="form-inline el-dropdown-link">
            <span><i class="fas fa-user"></i>&nbsp;&nbsp;{{ clientName }}</span
            >&nbsp;&nbsp;
            <span v-if="role == 'admin'" class="badge bg-danger"
              >администратор</span
            >
            <span v-if="role == 'client'" class="badge bg-default">клиент</span>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item >Выход</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </div>
    </nav>

    <main role="main" style="margin-top: 20px" class="container">
      <router-view></router-view>
    </main>


    <div class="pleaseholder" style="width:100%;height: 200px;"></div>
    <footer class="footer">
      <div class="container">
        <span class="text-muted">контакт: arysmukiyat@hotmail.com</span>
      </div>
    </footer>
  </div>
</template>
<script>
export default {
  data() {
    return {
      clientName: '',
      role: ''
    }
  },
  mounted() {
    this.clientName = this.$store.state.user.name;
    this.role = this.$store.state.user.role;

    const user = this.$store.state.user;
    if (user.role == 'admin') {
      this.$router.push('/admin');
    } else {
      this.$router.push('/client');
    }
  },
  methods: {
    async logout() {
      console.log('out');
      await this.$store.dispatch('logout');
      this.$router.push('/');
    }
  }
}
</script>

<style lang="scss">
</style>