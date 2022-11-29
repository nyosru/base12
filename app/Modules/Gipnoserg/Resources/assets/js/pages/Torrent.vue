<template>
  <div>
    <div class="container cont-tl">

      <div class="row justify-content-center">
        <div class="col-xl-10 col-12 pb-5 pt-5 text-center" >
          <b>Пользуйтесь пока работает!</b><br/>
          <form @submit.prevent=" showSrc = 'https://poisk.ww33.top/ser2.php?query=' + search;" >
          поиск торентов <input type="text" v-model="search" />
          <button type="submit" >Поиск</button>
          </form>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-xl-10 col-12" style="height: 600px;">
          <iframe :src="showSrc" class="if"></iframe>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import { ref, watchEffect } from "vue";
// import sendTelegramm from "./../use/sendTelegramm.ts";

// import news from "../components/Tests.vue";

export default {
  // components: { news },

  //   props: {
  //     titleFrom: { type: String, default: "x" },
  //   },

  data() {
    return {
      search: "",
      // items: [
      //   {
      //     name: "Laravel",
      //     link: "https://ru.wikipedia.org/wiki/laravel",
      //     img: "/phpcat/logo/laravel.svg",
      //   },
      //   {
      //     name: "VUE3.js",
      //     link: "https://ru.wikipedia.org/wiki/Vue.js",
      //     img: "/phpcat/logo/vue.svg",
      //   },
      //   {
      //     name: "HTML",
      //     link: "https://ru.wikipedia.org/wiki/html",
      //     img: "/phpcat/logo/html5.svg",
      //   },
      //   {
      //     name: "CSS",
      //     link: "https://ru.wikipedia.org/wiki/css",
      //     img: "/phpcat/logo/css3.svg",
      //   },
      //   {
      //     name: "XML",
      //     link: "https://ru.wikipedia.org/wiki/XML",
      //     img: "/phpcat/logo/xml.svg",
      //   },
      //   {
      //     name: "JSon",
      //     link: "https://ru.wikipedia.org/wiki/JSON",
      //     img: "/phpcat/logo/json.svg",
      //   },
      //   {
      //     name: "NPM",
      //     link: "https://ru.wikipedia.org/wiki/Npm",
      //     img: "/phpcat/logo/npm.svg",
      //   },
      //   {
      //     name: "WebPack",
      //     link: "https://ru.wikipedia.org/wiki/Webpack",
      //     img: "/phpcat/logo/webpack.svg",
      //   },
      //   {
      //     name: "JQuery",
      //     link: "https://ru.wikipedia.org/wiki/JQuery",
      //     img: "/phpcat/logo/jquery.svg",
      //   },
      //   {
      //     name: "AJAX",
      //     link: "https://ru.wikipedia.org/wiki/AJAX",
      //     img: "/phpcat/logo/ajax.svg",
      //   },
      //   {
      //     name: "PHP",
      //     link: "https://ru.wikipedia.org/wiki/php",
      //     img: "/phpcat/logo/php.svg",
      //   },
      //   {
      //     name: "Composer",
      //     link: "https://ru.wikipedia.org/wiki/Composer",
      //     img: "/phpcat/logo/composer.png",
      //   },
      //   {
      //     name: "MySql",
      //     link: "https://ru.wikipedia.org/wiki/mysql",
      //     img: "/phpcat/logo/mysql.png",
      //   },
      // ],

      // " alt="MySql" border="1">
      // </a><a href="https://ru.wikipedia.org/wiki/postresql" target="_blank"
      // title="PostgreSQL"><img src="/vendor/didrive/libs/img/logo/postgresql.svg" alt="PostgreSQL"
      // border="1"></a><a href="https://ru.wikipedia.org/wiki/sqlite" target="_blank" title="SQLite">
      // </a><a href="https://ru.wikipedia.org/wiki/postresql" target="_blank"
      // title="PostgreSQL"><img src="/vendor/didrive/libs/img/logo/postgresql.svg" alt="PostgreSQL"
      // border="1"></a><a href="https://ru.wikipedia.org/wiki/sqlite" target="_blank" title="SQLite">
      // <img src="/vendor/didrive/libs/img/logo/sqlite.svg" alt="SQLite" border="1"></a></div>

      // }
      //       formName: "",
      //       formPhone: "",
      //       formMsg: "",
    };
  },

  setup(props) {
    const showSrc = ref("");
    const search = ref("");
    // const loading = ref(false);

    // watchEffect(() => {
    //   showSrc.value = "https://poisk.ww33.top/ser2.php?query=" + search.value;
    // });

    return {
      search,
      showSrc,
      //   result,
      //   loading,
    };
  },

  //   //   mounted() {
  //   //     console.log("Component mounted.");
  //   //   },
  //   methods: {
  //     async formSend() {
  //       //   console.log(2222, this.formName, this.formPhone, this.formMsg);
  //       //   console.log(2222, this.formPhone, this.titleFrom);

  //       this.loading = true;

  //       const { sendToTelegramm } = sendTelegramm();
  //       let ww = await sendToTelegramm(
  //         "Где: " +
  //           this.titleFrom +
  //           "<br>" +
  //           "Как зовут: " +
  //           this.formName +
  //           "<br>" +
  //           "Телефон: " +
  //           this.formPhone +
  //           "<br>" +
  //           "Сообщение: " +
  //           this.formMsg
  //       );
  //       //   console.log('ww',ww);
  //       this.result = ww;
  //     },
  //   },
};
</script>

<style lang="scss">
.if {
  height: 600px;
  width: 100%;
  overflow: auto;
}
</style>
