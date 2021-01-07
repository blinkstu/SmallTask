<template>
  <div>
    <h3>Список запросов</h3>
    <div>
      <el-card>
        <el-button type="info" @click="$router.push('tickets/new')"
          >Создать</el-button
        >
        <el-table v-loading="loading" :data="tableData">
          <el-table-column prop="id" label="Id" width="180"> </el-table-column>
          <el-table-column prop="theme" label="Тема"> </el-table-column>
          <el-table-column
            prop="created_at"
            :formatter="dateFormatter"
            label="время создания"
          >
          </el-table-column>
          <el-table-column prop="status" label="Статус">
            <template slot-scope="scope">
              <el-tag v-if="scope.row.status == 0" type="info" size="mini"
                >Находится на рассмотрении</el-tag
              >
            </template>
          </el-table-column>
          <el-table-column prop="name" label="Операция" width="100">
            <template slot-scope="scope">
              <el-button
                type="text"
                @click="
                  $router.push('/tickets/' + scope.row.id + '/add_message')
                "
                >Открыть</el-button
              >
            </template>
          </el-table-column>
          <div slot="empty">пустые данные</div>
        </el-table>
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
      loading: false,
      tableData: []
    }
  },
  mounted() {
    this.loading = true;
    this.$http.get('/tickets').then(res => {
      this.tableData = res.data;
    }).catch(err => { }).finally(() => {
      this.loading = false;
    })
  },
  methods: {
    dateFormatter(row, column, cellValue, index) {
      return moment(cellValue).format('LLLL');
    }
  }
}
</script>