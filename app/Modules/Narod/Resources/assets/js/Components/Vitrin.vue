<template>
  <div class="container" style="min-height: 60vh">
    <!-- good -->
    <!-- {{ good }} -->
    <!-- <br /> -->
    <!-- <span class="mh150" v-for="(k, v) in good" :key="k">
      <template v-if="k > 0">v{{ v }} k{{ k }} /</template>
    </span> -->

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
        <form id="form_order2" action="" method="post">

          <vitrin-form></vitrin-form>

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
            <div
              class="list_head hidden-xs pt-5"
              style="border-bottom: 1px solid gray"
            >
              <div class="row">
                <div class="
                col-8 col-sm-6 col-md-4 col-lg-3 name
                ">
                  <b>Наименование</b>
                </div>

                <div
                  class="
                    d-none d-lg-block
                    col-lg-2
                  "
                >
                  <b>Артикул</b>
                </div>

                <div
                  class="
                    d-none d-lg-block col-lg-1
                  "
                >
                  <b>Срок годности</b>
                </div>

                <div
                  class="
                    d-none d-sm-none d-md-none d-lg-block
                    xhidden-xs xhidden-sm
                    xcol-md-1 col-lg-1
                    onsklad
                  "
                >
                  <b>На складе</b>
                </div>

                <div
                  class="
                    d-none d-md-block
                    col-md-2 col-lg-1
                    text-center
                  "
                >
                  <!-- <b>Цена для Пайщиков-Сотрудников</b> -->
                  <b>Цена&nbsp;№3 (руб)</b>
                </div>

                <div
                  class="
                    d-none d-md-block
                    col-md-2 col-lg-1
                    text-center
                  "
                >
                  <!-- <b>Цена для Пайшиков-Потребителей</b> -->
                  <b>Цена&nbsp;№2 (руб)</b>
                </div>

                <div class="
                    d-block
                    col-4 col-md-2 col-lg-1
                text-center">
                  <!-- <b>Цена</b> -->
                  <b>Цена&nbsp;(руб) обычная </b>
                </div>

                <div class="                
                    d-none d-sm-block
                    col-sm-3 col-md-2 col-lg-1
                "></div>

              </div>
            </div>

            <vitrin-row
              xv-for="el in pageData"
              v-for="el in listData"
              :key="el.id"
              :el="el"
            ></vitrin-row>
          </div>
        </form>

        <br />
        <br />

        <!-- <div>
          <br />
          <br />
          pageData
          <br />
          <pre>
        {{ pageData ?? "x" }}
        </pre
          >
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watchEffect } from "vue";
// import axios from "axios";

import VitrinRow from "./VitrinRow.vue";
import VitrinForm from "./VitrinFormSend.vue";
import Vitrin from "./Vitrin.ts";

export default {
  // data() {
  //   return {
  //     searchString: ''
  //   }
  // },

  components: {
    VitrinRow,
    VitrinForm,
  },

  setup(props) {
    // const good = ref([]);
    // const pageData = ref([]);
    const searchString = ref("");

    // // loading.value = false;
    // axios
    //   .get("/api47/getVitrin")
    //   .then((response) => {
    //     pageData.value = response.data.data;
    //   })
    //   .catch((error) => {
    //     console.log(error);
    //     // loadError.value = true;
    //   });

    const { good, loading, getData, pageData, loadError } = Vitrin();

    getData();

    const listData = ref([]);

    watchEffect(() => {
      // let employeeDisplayList = [{employeeName: "Jules 1"}, {employeeName: "jules 2"}, {employeeName: "Max"}];
      // let searchStr = "Jules";
      // console.log(employeeDisplayList.filter(e => e.employeeName.toLowerCase().indexOf(searchStr.toLowerCase()) >= 0));

      // listData.value = pageData.value.filter(i => i.naimenovanie.toLowerCase() == searchString.value.toLowerCase()) ;
      // listData.value = pageData.value.filter(e => e.naimenovanie.toLowerCase().indexOf(searchString.value.toLowerCase()) >= 0));
      // let res = users.filter(it => new RegExp('oli', "i").test(it.name));

      let str1 = "";
      let str2 = "";

      // listData.value = pageData.value;
      if (pageData.value && pageData.value.length) {
        // listData.value = pageData.value.filter(it => new RegExp( searchString , "i").test(it.naimenovanie));

        listData.value = pageData.value.filter(function (el) {
          // console.log("el", el);

          if (searchString.value && !searchString.value.length) {
            return true;
          }

          str1 = el.naimenovanie.toLowerCase() + el.dobavka.toLowerCase();
          str2 = searchString.value.toLowerCase();

          // return str1.includes( str2 )
          // return str1.test( str2 )
          return str1.indexOf(str2) != -1;
          // return true;
        });
      }
    });

    return {
      listData,
      loading,
      pageData,
      good,
      searchString,
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
