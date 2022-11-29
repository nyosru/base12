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
        <div class="container">
          <div class="row">
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

              <!-- <pre>pageData {{ pageData }}</pre > -->
              <!-- <pre>headUnique {{ headUnique }}</pre> -->
              <!-- filterFirm : {{ filterFirm }} -->

              <div class="btn-list">
                
                  <h3 v-if="!filterFirm.length">
                    Выберите кооператив
                  </h3>
                  <h3 v-else>Кооператив</h3>
                
                <div class="div-top-3">
                  <button
                    v-for="k in headUnique"
                    :key="k"
                    class="btn btn-sm"
                    :class="
                      filterFirm == k ? 'btn-success' : 'btn-outline-success'
                    "
                    @click="filterFirm = k"
                  >
                    {{ k }}
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-6">
              <table
                v-if="pageData2.length"
                class="table table-bordered table-striped"
              >
                <thead>
                  <tr>
                    <!-- <th>Кооператив</th> -->
                    <th>Действие</th>
                    <th>Потребление</th>
                    <th>Вклад</th>
                  </tr>
                </thead>

                <tbody>
                  <row v-for="el in pageData2" :key="el.id" :el="el"></row>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watchEffect } from "vue";

import Row from "./RowComponent.vue";
// import Row from "./RowHeadComponent.vue";
import Datar from "./Datar.ts";

export default {
  components: {
    Row,
  },
  setup(props) {
    const filterFirm = ref("");
    const pageData2 = ref([]);

    const { good, loading, getData, headUnique, pageData, loadError } = Datar();

    getData();

    watchEffect(() => {
      if (filterFirm.value.length > 0) {
        pageData2.value = pageData.value.filter(function (n) {
          return n.firma == filterFirm.value;
        });
      }
    });

    return {
      pageData2,
      filterFirm,
      headUnique,
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

.btn-list {
  text-align: center;
  margin-top: 3vh;
  margin-bottom: 3vh;
}
.btn-list button {
  margin-right: 1vw;
}
.div-top-3 {
  position: sticky;
  top: 60px;
  z-index: 200;
}

</style>
