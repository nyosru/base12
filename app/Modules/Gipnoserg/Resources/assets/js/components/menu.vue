<template>
  <div class="row" v-if="1 == 1">
    <div class="col-12 text-center pb-5 menu" style="line-height: 35px">
      <router-link :to="{ name: 'index' }">
        Супер&nbsp;предложение!
        </router-link>
      <router-link :to="{ name: 'timeline' }">
        Историческая&nbsp;лента
      </router-link>
      <router-link :to="{ name: 'tests' }">
        Задачки&nbsp;и&nbsp;решения
      </router-link>
      <router-link :to="{ name: 'findTorrent' }">
        Поиск&nbsp;торрентов
      </router-link>
      <!-- <router-link :to="{ name: 'lern' }">Учится, не переучится</router-link> -->
    </div>
  </div>
</template>

<script>
// import { ref } from "vue";
// import sendTelegramm from "./../use/sendTelegramm.ts";

export default {
  //   props: {
  //     titleFrom: { type: String, default: "x" },
  //   },

  data() {
    return {};
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
.menu {
  a {
    background-color: #efefef;
    padding: 5px 10px;
    margin-right: 10px;
    border-radius: 3px;
    &.active {
      background-color: #55efef;
    }
  }
}
</style>
