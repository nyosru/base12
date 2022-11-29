<template>
  <div class="container" style="min-height: 60vh">
    <div class="row" v-if="loading">
      <div class="col-12 text-center">
        <br />
        <br />
        <br />
        <h3 style="color: gray">.. загружаемся информацией ..</h3>
      </div>
    </div>
    <div v-else class="row">
      <div class="col-12">
        <!-- <div class="container">
          <br />
          <br />
          <div class="row" style="border-bottom: 1px solid gray">
            <div class="col-2"><b>счёт / НАименование</b></div>
            <div class="col"><b>НП Дебет</b></div>
            <div class="col"><b>НП Кредит</b></div>
            <div class="col"><b>Оборот Дебет</b></div>
            <div class="col"><b>Оборот Кредит</b></div>
            <div class="col"><b>КП Дебет</b></div>
            <div class="col"><b>КП Кредит</b></div>
          </div>

          <row v-for="el in pageData" :key="el.id" :el="el"></row>

        </div>

        <br />
        <br /> -->

        <table class="table table-bordered">
          <thead>
            <tr>
              <th rowspan="2">Счёт</th>
              <th rowspan="2">Наименование, Организация</th>
              <th colspan="2" class="text-center hidden-xs">
                На&nbsp;начало&nbsp;периода
              </th>
              <th colspan="2" class="text-center">Оборот</th>
              <th colspan="2" class="text-center hidden-xs">
                На&nbsp;конец&nbsp;периода
              </th>
            </tr>
            <tr>
              <th class="text-center hidden-xs">Дебет</th>
              <th class="text-center hidden-xs">Кредит</th>
              <th class="text-center">Дебет</th>
              <th class="text-center">Кредит</th>
              <th class="text-center hidden-xs">Дебет</th>
              <th class="text-center hidden-xs">Кредит</th>
            </tr>
          </thead>
          <tbody>
            <row v-for="el in pageData" :key="el.id" :el="el"></row>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
// import Row from "./RowComponent.vue";
import Row from "./RowHeadComponent.vue";
import Datar from "./Datar.ts";

export default {
  components: {
    Row,
  },
  setup(props) {
    const { good, loading, getData, pageData, loadError } = Datar();

    getData();

    return {
      loading,
      pageData,
      good,
    };
  },
};
</script>

<style lang="scss" >
pre {
  max-height: 300px;
  overflow: auto;
}

.list_head,
.table thead {
  position: -webkit-sticky;
  position: -moz-sticky;
  position: -ms-sticky;
  position: -o-sticky;
  position: sticky;
  top: 40px;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 200;
}

.item {
  margin-top: 3px;
  margin-bottom: 3px;
}

.item:nth-child(2n) {
  background-color: rgba(0, 0, 0, 0.1);
}
</style>
