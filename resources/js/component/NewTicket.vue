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
        <div class="mb-3" style="max-width: 400px">
          <label for="">Прикрепить файл</label>
          <el-upload
            action="/api/files"
            :limit="1"
            :headers="headers"
            :on-error="onError"
            :on-remove="onRemove"
            :on-success="onSuccess"
            :on-exceed="onExceed"
          >
            <el-button v-show="!disable" size="small"
              >Прикрепить файл</el-button
            >
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
      fileList: [],
      headers: {},
      form: {
        theme: '',
        content: '',
        file: null
      }
    }
  },
  mounted() {
    const token = localStorage.getItem('token');
    this.headers = {
      'Authorization': 'Bearer ' + token
    };
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
    },
    onRemove: function () {
      this.form.file = null;
    },
    onError: function (e) {
      this.$message.error(e.message);
    },
    onSuccess: function (res) {
      console.log(res);
      this.form.file = res.id;
    },
    onExceed: function () {
      this.$message.info('Только один файл может быть загружен')
    }
  }
}
</script>
