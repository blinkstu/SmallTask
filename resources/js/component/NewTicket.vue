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
            action="#"
            :on-remove="onRemove"
            :file-list="fileList"
            :limit="1"
            :beforeUpload="beforeUpload"
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
      fileList: [],
      form: {
        theme: '',
        content: '',
        file: null
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
    },
        beforeUpload: function (file) {
      var fd = new window.FormData();
      console.log(file);
      fd.append('file', file, file.name);
      var that = this;
      this.$http.post('/files', fd).then(function (res) {
        that.fileList = [file];
        that.form.file = res.data.id;
      });
      return false;
    },
    onRemove: function () {
      this.fileList = [];
      this.form.file = null;
    }
  }
}
</script>
