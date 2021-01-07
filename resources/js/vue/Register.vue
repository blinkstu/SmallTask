<template>
  <el-container class="container">
    <div class="register">
      <el-card class="register-box">
        <h2>Ре­гис­тра­ция</h2>
        <el-form
          class="register-form"
          :model="model"
          :rules="rules"
          ref="form"
          @submit.native.prevent="register"
        >
          <el-form-item prop="name" label="Имя">
            <el-input v-model="model.username"></el-input>
          </el-form-item>
          <el-form-item prop="email" label="E-mail адрес">
            <el-input
              v-model="model.username"
            ></el-input>
          </el-form-item>
          <el-form-item prop="password" label="пароль">
            <el-input
              v-model="model.password"
              type="password"
            ></el-input>
          </el-form-item>
          <el-form-item>
            <el-button
              :loading="loading"
              class="register-button"
              type="primary"
              native-type="submit"
              block
              >зарегистрироваться</el-button
            >
          </el-form-item>
          <p class="forgot-password">
            Уже за­регис­три­рова­ны?
            <router-link to="/login">Войдите</router-link>
          </p>
        </el-form>
      </el-card>
    </div>
  </el-container>
</template>

<script>
export default {
  name: "register",
  data() {
    return {
      validCredentials: {
        username: "lightscope",
        password: "lightscope"
      },
      model: {
        username: "",
        password: ""
      },
      loading: false,
      rules: {
        name: [
          {
            required: true,
            message: "Введите ваше имя",
            trigger: "blur"
          },
        ],
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
}
</script>



<style lang="scss">
.register-box {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 350px;
}
.el-form-item {
  margin-bottom: 1.2rem;
  label {
    line-height: 20px;
    margin-bottom: 0.1rem;
  }
}
.register .el-input__prefix {
  background: rgb(238, 237, 234);
  left: 0;
  height: calc(100% - 2px);
  left: 1px;
  top: 1px;
  border-radius: 3px;
  .el-input__icon {
    width: 30px;
  }
}
.register .el-card {
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
.register .el-card {
  width: 340px;
  display: flex;
  justify-content: center;
}
.register {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}
.register-button {
  width: 100%;
  margin-top: 20px;
}
.register-form {
  width: 290px;
}
.forgot-password {
  margin-top: 10px;
}
</style>