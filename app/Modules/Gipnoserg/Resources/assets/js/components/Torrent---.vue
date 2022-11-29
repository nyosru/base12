<template>
  <div>
    <div class="container zadachi">

findTorrent

      <tests-form v-if="$route.params.action == 'ss'" />

      <transition name="fade">
        <div class="row" v-if="loading">
          <div
            class="col-12"
            style="
              position: fixed;
              top: 35%;
              text-align: center;
              left: 0;
              rigth: 0;
              xborder: 1px solid green;
            "
          >
            ... загрузка ...
          </div>
        </div>
        <div v-else class="row">
          <div class="col-12" v-for="k in t_data" :key="k.id">
            <div class="card mb-4 rounded-3 shadow-sm">
              <div class="card-header py-3">
                <h4 class="my-0 fw-normal">
                  {{ k.head }}

                  <a
                    href="#"
                    v-if="$route.params.action == 'ss'"
                    @click.prevent="deleteItem(k.id)"
                  >
                    xx
                  </a>
                </h4>
              </div>
              <div class="card-body">
                <small
                  v-if="k.date && k.date.length"
                  style="color: gray"
                  class="xtime-right"
                >
                  {{ showDate(k.date) }}
                </small>
                <p>
                  <span v-html="k.text"></span>
                </p>
                <a
                  href=""
                  style="display: block"
                  class="pt-2 pb-2"
                  v-if="k.link1 && k.link1.length"
                >
                  {{ k.link1 ?? "v" }}
                </a>
                <a href="" style="display: block" v-if="k.link2 && k.link2.length">
                  {{ k.link2 ?? "x" }}</a
                >
                <a href="" style="display: block" v-if="k.link3 && k.link3.length">
                  {{ k.link3 ?? "c" }}</a
                >

                <pre><code class="language-php" >{{ k.code }}</code></pre>

              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import { onMounted } from "vue";

import dayjs from "dayjs";
import tests from "./tests.ts";

import testsForm from "./TestsForm.vue";

require("dayjs/locale/ru");
dayjs.locale("ru");

export default {
  components: {
    testsForm,
    // highlightjs: hljsVuePlugin.component,
  },
  data() {
    return {};
  },

  setup(props) {
    const { getI, data, loading, errored } = tests();

    onMounted(() => {
      getI();
    });

    return {
      t_data: data,
      loading,
    };
  },

  methods: {
    deleteItem(item_id) {
      const { deleteI } = tests();
      console.log("deleteI(item_id) {", item_id);
      deleteI(item_id);
    },

    showDate(date) {
      if (dayjs(date).isValid()) {
        if (dayjs().year() == dayjs(date).year()) {
          // console.log(777);
          return dayjs(date).format("DD MMMM");
        } else {
          // console.log(888);
          return dayjs(date).format("MMMM YYYY");
        }
      }
    },
  },
};
</script>

<style lang="scss">
.zadachi pre {
  max-height: 350px;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.1);
  padding: 10px;
  font-family: "Courier New", Courier, monospace;
  font-size: 12px;
}
</style>
