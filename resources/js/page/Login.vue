<template>
  <el-container class="container">
    <div class="login">
      <el-card class="login-box">
        <h2>Вход</h2>
        <el-form
          class="login-form"
          :model="model"
          :rules="rules"
          ref="form"
          @submit.native.prevent="login"
        >
          <el-form-item prop="email">
            <el-input
              v-model="model.email"
              placeholder="e-mail адрес"
              prefix-icon="fas fa-user"
            ></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <el-input
              v-model="model.password"
              placeholder="пароль"
              type="password"
              prefix-icon="fas fa-lock"
            ></el-input>
          </el-form-item>
          <el-form-item>
            <el-button
              :loading="loading"
              class="login-button"
              type="primary"
              native-type="submit"
              block
              >войти</el-button
            >
          </el-form-item>
          <router-link class="forgot-password" to="/register"
            >зарегистрироваться на сайте</router-link
          >
        </el-form>
      </el-card>
    </div>
  </el-container>
</template>

<script>
export default {
  name: "login",
  data() {
    return {
      model: {
        email: "test@gmail.com",
        password: "admin"
      },
      loading: false,
      rules: {
        email: [
          {
            required: true,
            message: "Введите ваш e-mail адрес",
            trigger: "blur"
          },
        ],
        password: [
          { required: true, message: "Введите пароль", trigger: "blur" },
          {
            min: 5,
            message: "Длина пароля должна быть не менее 5 символов",
            trigger: "blur"
          }
        ]
      }
    };
  },
  mounted() {
    const user = this.$store.state.user;
    if (user) {
      this.$router.push('/')
    }
  },
  methods: {
    async login() {
      let valid = await this.$refs.form.validate();
      if (!valid) {
        return;
      }

      this.loading = true;
      await this.$store
        .dispatch("login", { email: this.model.email, password: this.model.password })
        .then(res => {
          this.$store.dispatch('userInfo').then(res => {
            this.$router.push("/")
          })
        })
        .catch(err => console.log(err));
      this.loading = false;
    }
  }
}
</script>



<style lang="scss">
.login-box {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 350px;
}
.el-button--primary {
}
.login .el-input__prefix {
  left: 0;
  height: calc(100% - 2px);
  left: 1px;
  top: 1px;
  border-radius: 3px;
  .el-input__icon {
    width: 30px;
  }
}
.login .el-input input {
  padding-left: 35px;
}
.login .el-card {
  padding-top: 0;
  padding-bottom: 30px;
}
h2 {
  font-family: "Open Sans";
  letter-spacing: 1px;
  font-family: Roboto, sans-serif;
  padding-bottom: 20px;
}
a {
  text-decoration: none;
}
.login .el-card {
  width: 340px;
  display: flex;
  justify-content: center;
}
.login {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}
.login-button {
  width: 100%;
  margin-top: 20px;
}
.login-form {
  width: 290px;
}
.forgot-password {
  margin-top: 10px;
}
</style>