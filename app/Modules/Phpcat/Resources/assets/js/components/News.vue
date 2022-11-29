<template>
  <div>
    <div class="container cont-tl">
      <news-form v-if="$route.params.action == 'ss'" />

      <!-- loading {{ loading }} -->

      <div class="row justify-content-center">
        <transition name="fade">
          <div style="position: fixed; top: 35%; left:0; rigth: 0; xborder: 1px solid green;" class="xcol-12 text-center" v-if="loading">... загрузка ...</div>
          <div v-else class="col-12">
            <div
              class="timeline timeline-line-solid"
              v-for="(k, id) in news_data"
              :key="k.id"
            >
              <div class="timeline-item" :class="{ 'timeline-item-right': id % 2 != 0 }">
                <div class="timeline-point timeline-point"></div>

                <div class="timeline-event">
                  <div class="widget has-shadow">
                    <div class="widget-header d-flex align-items-center">
                      <div class="user-image">
                        <img
                          class="rounded-circle"
                          src="https://bootdey.com/img/Content/avatar/avatar1.png"
                          alt="..."
                        />
                      </div>
                      <h4>
                        <a
                          href="#"
                          v-if="$route.params.action == 'ss'"
                          @click.prevent="deleteItem(k.id)"
                          >xx</a
                        >
                        {{ k.head }}
                      </h4>
                    </div>
                    <div class="widget-body">
                      <!-- {{ k.date ?? "x" }} -->
                      <small
                        v-if="k.date && k.date.length"
                        style="color: gray"
                        class="xtime-right"
                      >
                        {{ showDate(k.date) }}
                      </small>
                      <img
                        v-if="k.img_pod && k.img_pod.length"
                        style="width: 100%"
                        :src="'/phpcat/' + k.img_pod"
                      />
                      <img
                        v-if="k.img && k.img.length"
                        style="width: 100%"
                        :src="k.img"
                      />
                      <br />
                      <a :href="k.link" target="_blank" v-if="k.link && k.link.length">
                        {{ k.link }}
                      </a>
                      <p>
                        <span v-html="k.text"></span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted } from "vue";
// import sendTelegramm from "./../use/sendTelegramm.ts";

import dayjs from "dayjs";
import news from "./news.ts";

import newsForm from "./NewsForm.vue";

require("dayjs/locale/ru");
dayjs.locale("ru");

export default {
  components: {
    newsForm,
  },

  //   props: {
  //     titleFrom: { type: String, default: "x" },
  //   },

  data() {
    return {};
  },

  setup(props) {
    // const result = ref("x");
    // const loading = ref(false);

    const { getNews, news_data, loading, errored } = news();

    onMounted(() => {
      getNews();
    });

    return {
      news_data,
      //   result,
      loading,
    };
  },

  //   //   mounted() {
  //   //     console.log("Component mounted.");
  //   //   },
  methods: {
    deleteItem(item_id) {
      const { deleteItem } = news();
      console.log("deleteItem(item_id) {", item_id);
      deleteItem(item_id);
    },

    showDate(date) {
      //   console.log("date", date);
      //   console.log("date2", dayjs(date, "DD-MM-YYYY").format("DD.MM.YYYY"));
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
@import "./news.scss";

.fade-enter-active,
.fade-leave-active {
  transition: opacity 2.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

</style>
