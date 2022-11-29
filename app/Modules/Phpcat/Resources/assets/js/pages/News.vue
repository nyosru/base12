<template>
  <div>
    <div class="container cont-tl">
      <div class="row justify-content-center">
        <div class="col-xl-10 col-12">

          <news />

        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import { ref } from "vue";
// import sendTelegramm from "./../use/sendTelegramm.ts";

import news from "./../components/News.vue";

export default {
  components: { news },

  //   props: {
  //     titleFrom: { type: String, default: "x" },
  //   },

//   data() {
//     return {

//     };
//   },

  setup(props) {
    // const result = ref("x");
    // const loading = ref(false);

    return {
      //   result,
      //   loading,
    };
  },

};
</script>

<style lang="scss">
</style>
