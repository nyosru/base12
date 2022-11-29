<template>
  <div>
    <div class="container cont-tl">
      <div class="row justify-content-center">
        <div class="col-xl-10 col-12">
          <news />

          <div v-if="1 == 2" class="timeline timeline-line-solid">
            <span class="timeline-label"><span class="label">2021</span></span>

            <div class="timeline-item">
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
                    <h4>новый DiDrive</h4>
                  </div>
                  <div class="widget-body">
                    <small style="color: gray" class="xtime-right">26-09-2021</small>
                    <p>
                      Идея заключается в следующем: создать систему управления данными ...
                      как отдельный стик на рабочем столе бизнеса. Система подключается к
                      базе данных и помогает в норм интерфейсе управлять данными. Бета
                      версия системы управления готова! и запущена на ряде проектов.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="timeline-item">
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
                    <h4>VUE3 в кармане</h4>
                  </div>
                  <div class="widget-body">
                    <small style="color: gray" class="xtime-right">01-09-2021</small>
                    <p>
                      Проведены тесты, собраны первые сайты, VUE 3 с его прекрасным
                      композишн апи в работе
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="timeline-item">
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
                    <h4>Laravel seeder и фабрики БД</h4>
                  </div>
                  <div class="widget-body">
                    <small style="color: gray" class="xtime-right">22-05-2021</small>
                    <p>
                      Первый раз ( как в первый класс )) использую данные технологии в
                      боевом сайте, очень удобно освобождает массу времени и не нужно
                      писать 100-ни строк кода
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="timeline-item">
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
                    <h4>Создал эту тайм линию</h4>
                  </div>
                  <div class="widget-body">
                    <small style="color: gray" class="xtime-right">30-04-2021</small>
                    <p>Взял и сделал, интересное решение</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="timeline-item">
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
                    <h4>Старт работ по созданию сайта бесплатных обьявлений бу72.рф</h4>
                  </div>
                  <div class="widget-body">
                    <a href="//бу72.рф" style="margin-left: 10px" target="_blank"
                      >бу72.рф</a
                    >
                    <p>Делаю свою досочку обьявлений для Тюмени</p>
                    <div class="block_tehs">
                      <b>laravel</b><b>php</b><b>mysql</b><b>telegram</b><b>api</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <a href="/010.timeline/"
              ><span class="timeline-label"
                ><span class="label bg-primary"> Посмотреть полную версию </span></span
              ></a
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import { ref } from "vue";
// import sendTelegramm from "./../use/sendTelegramm.ts";

import news from "../components/Tests.vue";

export default {
  components: { news },

  //   props: {
  //     titleFrom: { type: String, default: "x" },
  //   },

  data() {
    return {
      items: [
        {
          name: "Laravel",
          link: "https://ru.wikipedia.org/wiki/laravel",
          img: "/phpcat/logo/laravel.svg",
        },
        {
          name: "VUE3.js",
          link: "https://ru.wikipedia.org/wiki/Vue.js",
          img: "/phpcat/logo/vue.svg",
        },
        {
          name: "HTML",
          link: "https://ru.wikipedia.org/wiki/html",
          img: "/phpcat/logo/html5.svg",
        },
        {
          name: "CSS",
          link: "https://ru.wikipedia.org/wiki/css",
          img: "/phpcat/logo/css3.svg",
        },
        {
          name: "XML",
          link: "https://ru.wikipedia.org/wiki/XML",
          img: "/phpcat/logo/xml.svg",
        },
        {
          name: "JSon",
          link: "https://ru.wikipedia.org/wiki/JSON",
          img: "/phpcat/logo/json.svg",
        },
        {
          name: "NPM",
          link: "https://ru.wikipedia.org/wiki/Npm",
          img: "/phpcat/logo/npm.svg",
        },
        {
          name: "WebPack",
          link: "https://ru.wikipedia.org/wiki/Webpack",
          img: "/phpcat/logo/webpack.svg",
        },
        {
          name: "JQuery",
          link: "https://ru.wikipedia.org/wiki/JQuery",
          img: "/phpcat/logo/jquery.svg",
        },
        {
          name: "AJAX",
          link: "https://ru.wikipedia.org/wiki/AJAX",
          img: "/phpcat/logo/ajax.svg",
        },
        {
          name: "PHP",
          link: "https://ru.wikipedia.org/wiki/php",
          img: "/phpcat/logo/php.svg",
        },
        {
          name: "Composer",
          link: "https://ru.wikipedia.org/wiki/Composer",
          img: "/phpcat/logo/composer.png",
        },
        {
          name: "MySql",
          link: "https://ru.wikipedia.org/wiki/mysql",
          img: "/phpcat/logo/mysql.png",
        },
      ],

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
    // const result = ref("x");
    // const loading = ref(false);

    return {
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
</style>
