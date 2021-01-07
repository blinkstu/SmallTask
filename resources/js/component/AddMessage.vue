<template>
  <div>
    <h3>Запрос - {{ theme }}</h3>
    <el-card>
      <div class="chat">
        <ul class="chat-history">
          <li class="clearfix">
            <div class="message-data align-right">
              <span class="message-data-time">5:23 AM, Today</span> &nbsp;
              &nbsp;
              <span class="message-data-name">Olia</span>
              <i class="fa fa-circle me"></i>
            </div>
            <div class="message other-message float-right">asdf</div>
          </li>
          <li>
            <div class="message-data">
              <span class="message-data-name"
                ><i class="fa fa-circle online"></i> Vincent</span
              >
              <span class="message-data-time">5:23 AM, Today</span>
            </div>
            <div class="message my-message">
              An SQL query enters a bar, approaches two tables and asks: "May I
              join you?"
            </div>
          </li>
          <li class="clearfix" v-for="item in messages" :key="item.id">
            <div class="message-data align-right">
              <span class="message-data-time">{{formateTime(item.created_at)}}</span> &nbsp;
              &nbsp;
              <span class="message-data-name">{{item.user.name}}</span>
              <i class="fa fa-circle me"></i>
            </div>
            <div class="message other-message float-right">{{ item.content }}</div>
          </li>
        </ul>
      </div>

      <hr />
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
            action="https://jsonplaceholder.typicode.com/posts/"
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
</template>

<script>
import moment from 'moment';
moment.lang('ru');
export default {
  data() {
    return {
      loading: false,
      theme: '',
      messages: [],
      form: {
        theme: '',
        content: ''
      }
    }
  },
  mounted() {
    this.$http.get('/tickets/6')
      .then(res => {
        console.log(res);
        this.theme = res.data.theme;
        this.messages = res.data.messages;
      })
      .catch(err => { })
      .finally(() => { })
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
    formateTime(time){
      return moment(time).fromNow()
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