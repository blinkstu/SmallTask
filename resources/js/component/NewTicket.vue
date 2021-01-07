<template>
  <div>
    <h3>Создать запрос</h3>
    <el-card>
      <el-form ref="form" :model="form" label-width="120px">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label"
            >Тема запроса</label
          >
          <input
            v-model="form.theme"
            class="form-control"
            placeholder="Тема запроса"
          />
        </div>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"
            >Текст сообщения</label
          >
          <textarea
            v-model="form.content"
            class="form-control"
            rows="3"
            placeholder="Текст сообщения"
          ></textarea>
        </div>
        <div class="mb-3">
          <label for="">Прикрепить файл</label>
          <el-upload
            class="upload-demo"
            action="https://jsonplaceholder.typicode.com/posts/"
          >
            <el-button size="small">Прикрепить файл</el-button>
          </el-upload>
        </div>
        <hr />
        <el-button :loading="loading" type="info" @click="request"
          >Отправить</el-button
        >
        <el-button @click="$router.go(-1)">Отмена</el-button>
      </el-form>
    </el-card>
  </div>
</template>

<script>

export default {
  data() {
    return {
      loading: false,
      form: {
        theme: '',
        content: ''
      }
    }
  },
  methods: {
    request() {
      this.loading = true;
      this.$http.post('/tickets', this.form).then(res => {
        this.$message.success('успешно созданный')
        this.$router.go(-1);
      }).catch(err => { }).finally(() => {
        this.loading = false;
      })
    }
  }
}
</script>
