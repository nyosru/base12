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



            <div class="row pt-5">
              <div class="col-12 xcol-sm-6 xcol-md-4 xcol-lg-3 name text-center">
                
                <input
                  type="text"
                  v-model="searchString"
                  placeholder="быстрый поиск"
                  style="min-width: 320px; width:40%; text-align: center;"
                />

              </div>
            </div>


          <br />
          <br />
          <div
            class="list_head hidden-xs"
            style="border-bottom: 1px solid gray"
          >
            <div class="row">
              <div class="col-10 col-sm-9 col-md-4 col-lg-5 name">
                <b>Наименование</b>
              </div>
              <div class="d-none d-md-block col-md-3 col-lg-3 name">
                <b>Контакты</b>
              </div>

              <div class="d-none d-md-block col-md-3 col-lg-3 name">
                <b>Артикул</b>
              </div>
              <div class="col-2 col-sm-3 col-md-2 col-lg-1 text-center">
                <b>Кол-во</b>
              </div>

              <!-- <div class="hidden-xs hidden-sm col-md-1 col-lg-1">
                  Срок годности
                </div>

                <div class="hidden-xs hidden-sm col-md-1 col-lg-1 onsklad">
                  На складе
                </div>

                <div class="hidden-xs hidden-sm hidden-md col-lg-1 text-center">
                  Цена для Пайщиков-Сотрудников
                </div>

                <div class="hidden-xs hidden-sm hidden-md col-lg-1 text-center">
                  Цена для Пайшиков-Потребителей
                </div> -->

              <!-- <div class="col-xs-4 col-sm-2 col-md-2 col-lg-1 text-center">
                  <b>Цена</b>
                </div> -->

              <!-- <div
                  class="col-xs-7 col-sm-2 col-md-2 col-lg-2 text-center"
                ></div> -->
            </div>
          </div>

          <!-- <row v-for="el in pageData" :key="el.id" :el="el"></row> -->
          <row v-for="el in listData" :key="el.id" :el="el"></row>
        </div>

        <br />
        <br />
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watchEffect } from "vue";

import Row from "./RowComponent.vue";
import Datar from "./Datar.ts";

export default {
  components: {
    Row,
  },
  setup(props) {

    const { good, loading, getData, pageData, loadError } = Datar();
    getData();

    const listData = ref({});
    const searchString = ref("");

    watchEffect(() => {

      let str1 = "";
      let str2 = "";

      if (pageData.value && pageData.value.length) {

        listData.value = pageData.value.filter(function (el) {

          if (searchString.value && !searchString.value.length) {
            return true;
          }

          str1 = el.naimenovanie.toLowerCase() + el.dobavka.toLowerCase();
          str2 = searchString.value.toLowerCase();

          return str1.indexOf(str2) != -1;
        });
      }
    });


    return {
      listData,
      searchString,
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
