<template>
  <div>
    <div v-if="pageLoading"></div>
    <div v-else>
      <h3>Запрос - {{ theme }}</h3>
      <el-card>
        <div class="chat">
          <ul class="chat-history">
            <li class="clearfix" v-for="item in messages" :key="item.id">
              <div class="message-data align-right" v-if="myId == item.user.id">
                <span class="message-data-time">{{
                  formateTime(item.created_at)
                }}</span>
                &nbsp; &nbsp;
                <span class="message-data-name">{{ item.user.name }}</span>
                <i class="fa fa-circle me"></i>
              </div>
              <div class="message-data" v-else>
                <span class="message-data-name"
                  ><i class="fa fa-circle online"></i>{{ item.user.name }}</span
                >
                <span class="message-data-time">5:23 AM, Today</span>
              </div>
              <div
                class="message"
                v-bind:class="{
                  'my-message': myId != item.user.id,
                  'other-message': myId == item.user.id,
                  'float-right': myId == item.user.id,
                }"
              >
                {{ item.content }}
                <p class="file" v-if="item.file">
                  <a :href="item.file.path" target="_blank">
                    <i class="fas fa-file"></i>&nbsp; {{ item.file.name }}
                  </a>
                </p>
              </div>
            </li>
          </ul>
        </div>
        <el-form ref="form" :model="form" label-width="120px">
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
          <el-button :loading="loading" type="info" @click="request"
            >Отправить</el-button
          >
          <el-button @click="$router.go(-1)">Отмена</el-button>
        </el-form>
      </el-card>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
moment.lang('ru');
export default {
  data() {
    return {
      fileList: [],
      prefix: '',
      myId: null,
      loading: false,
      pageLoading: false,
      theme: '',
      messages: [],
      form: {
        content: '',
        file: null,
      }
    }
  },
  mounted() {
    this.myId = this.$store.state.user.id;
    this.pageLoading = true;
    if (this.$store.state.user.role == 'admin') {
      this.prefix = '/admin'
    }
    this.fetch();
  },
  methods: {
    fetch() {
      this.$http.get(this.prefix + '/tickets/' + this.$route.params.id)
        .then(res => {
          this.theme = res.data.theme;
          this.messages = res.data.messages.reverse();
        })
        .catch(err => { })
        .finally(() => { this.pageLoading = false; })
    },
    request() {
      this.loading = true;
      this.$http.post(this.prefix + '/tickets/' + this.$route.params.id + '/messages', this.form).then(res => {
        this.$message.success('Отправленный');
        this.form.content = '';
        this.form.file = '';
        this.fileList = [];
        this.fetch();
      }).catch(err => { }).finally(() => {
        this.loading = false;
      })
    },
    formateTime(time) {
      return moment(time).fromNow()
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

<style lang="scss" scoped>
@import url(https://fonts.googleapis.com/css?family=Lato:400,700);

$green: #86bb71;
$blue: #94c2ed;
$orange: #e38968;
$gray: #92959e;

*,
*:before,
*:after {
  box-sizing: border-box;
}

ul li {
  list-style-type: none;
}

.file {
  margin: 0;
  font-size: 1rem;
  margin-bottom: -10px;
  a {
    color: #fff;
  }
}

.chat {
  color: #434651;

  .chat-header {
    padding: 20px;
    border-bottom: 2px solid white;

    img {
      float: left;
    }

    .chat-about {
      float: left;
      padding-left: 10px;
      margin-top: 6px;
    }

    .chat-with {
      font-weight: bold;
      font-size: 16px;
    }

    .chat-num-messages {
      color: $gray;
    }

    .fa-star {
      float: right;
      color: #d8dadf;
      font-size: 20px;
      margin-top: 12px;
    }
  }

  .chat-history {
    padding: 30px 10px 0px;
    border-bottom: 2px solid white;

    .message-data {
      margin-bottom: 15px;
    }

    .message-data-time {
      color: lighten($gray, 8%);
      padding-left: 6px;
    }

    .message {
      color: white;
      padding: 18px 20px;
      line-height: 26px;
      font-size: 16px;
      border-radius: 7px;
      margin-bottom: 30px;
      width: 90%;
      position: relative;

      &:after {
        bottom: 100%;
        left: 7%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: $green;
        border-width: 10px;
        margin-left: -10px;
      }
    }

    .my-message {
      background: $green;
    }

    .other-message {
      background: $blue;

      &:after {
        border-bottom-color: $blue;
        left: 93%;
      }
    }
  }

  .chat-message {
    padding: 30px;

    textarea {
      width: 100%;
      border: none;
      padding: 10px 20px;
      font: 14px/22px "Lato", Arial, sans-serif;
      margin-bottom: 10px;
      border-radius: 5px;
      resize: none;
    }

    .fa-file-o,
    .fa-file-image-o {
      font-size: 16px;
      color: gray;
      cursor: pointer;
    }

    button {
      float: right;
      color: $blue;
      font-size: 16px;
      text-transform: uppercase;
      border: none;
      cursor: pointer;
      font-weight: bold;
      background: #f2f5f8;

      &:hover {
        color: darken($blue, 7%);
      }
    }
  }
}

.online,
.offline,
.me {
  margin-right: 3px;
  font-size: 10px;
}

.online {
  color: $green;
}

.offline {
  color: $orange;
}

.me {
  color: $blue;
}

.align-left {
  text-align: left;
}

.align-right {
  text-align: right;
}

.float-right {
  float: right;
}

.clearfix:after {
  visibility: hidden;
  display: block;
  font-size: 0;
  content: " ";
  clear: both;
  height: 0;
}
</style>