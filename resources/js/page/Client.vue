<template>
  <div>
    <h3>Список запросов</h3>
    <div>
      <el-card>
        <el-button type="info" @click="$router.push('new_request')">Создать</el-button>
        <el-table :data="tableData">
          <el-table-column prop="id" label="Id" width="180"> </el-table-column>
          <el-table-column prop="date" label="Тема">
          </el-table-column>
          <el-table-column prop="name" label="Последнее сообщение" >
          </el-table-column>
          <el-table-column prop="name" label="Статус" width="100">
          </el-table-column>
          <div slot="empty">пустые данные</div>
        </el-table>
      </el-card>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tableData: []
    }
  }
}
</script>