<template>
  <div>
    <h3>Создать запрос</h3>
    <el-card>
      <el-form ref="form" :model="form" label-width="120px">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label"
            >Тема запроса</label
          >
          <input type="email" class="form-control" placeholder="Тема запроса" />
        </div>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"
            >Текст сообщения</label
          >
          <textarea
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
            :on-preview="handlePreview"
            :on-remove="handleRemove"
            :before-remove="beforeRemove"
            multiple
            :limit="3"
            :on-exceed="handleExceed"
            :file-list="fileList"
          >
            <el-button size="small">Прикрепить файл</el-button>
          </el-upload>
        </div>
        <hr />
        <el-button type="info">Отправить</el-button>
        <el-button @click="$router.go(-1)">Отмена</el-button>
      </el-form>
    </el-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        region: '',
        date1: '',
        date2: '',
        delivery: false,
        type: [],
        resource: '',
        desc: ''
      }
    }
  },

}
</script>
