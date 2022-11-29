<template>
  <div class="main">
    <!-- PageText
    <br />-->
    <!-- <br />
    loading {{ loading }} -->
    <!-- <br />
    <br />
    pageData: {{ pageData }} -->

    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h3 class="mt-3 mb-3">Заявка на участие</h3>

          <div class="btn-group" role="group" aria-label="docs">
            <button
              class="btn"
              :class="
                showForm == 'fast'
                  ? 'btn-success'
                  : 'btn-light btn-outline-secondary'
              "
              @click="showForm = 'fast'"
            >
              Быстрая форма
            </button>
            <button
              class="btn"
              :class="
                showForm == 'fiz'
                  ? 'btn-success'
                  : 'btn-light btn-outline-secondary'
              "
              @click="showForm = 'fiz'"
            >
              Анкета Физ.лицо
            </button>
            <button
              class="btn"
              :class="
                showForm == 'ur'
                  ? 'btn-success'
                  : 'btn-light btn-outline-secondary'
              "
              @click="showForm = 'ur'"
            >
              Анкета Юр.лицо
            </button>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-12 col-md-8">
          <!-- showForm {{ showForm }} -->          
          <form-fast v-if="showForm == 'fast'"></form-fast>
          <form-fiz v-else-if="showForm == 'fiz'"></form-fiz>
          <form-ur v-else-if="showForm == 'ur'"></form-ur>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import axios from "axios";

import { ref, onMounted } from "vue";
// import PageText from "./PageText.ts";

// import {
//   // useRouter,
//   useRoute,
// } from "vue-router";

import FormFast from "./formRegFast.vue";
import FormFiz from "./formRegFiz.vue";
import FormUr from "./formRegUr.vue";

export default {
  components: {
    FormFast,
    FormFiz,
    FormUr,
  },

  // data() {
  //   return {
  //     // showForm: "fast",
  //   };
  // },

  setup(props) {
    // const { loading, getData, pageData, loadError } = PageText();
    // // const Loading = ref(true);

    // const route = useRoute();

    // onMounted(() => {
    //   console.log("mounted");
    //   getData(route.meta.page ?? "");
    // });

    // // function getDataNow(name) {
    // //   this.getData($route.meta.page);
    // // }

    const showForm = ref("fast");

    return {
      showForm,
      // // getDataNow,
      // loading,
      // getData,
      // pageData,
      // loadError,
    };
  },
  // watch: {
  //   "$route.path"() {
  //     this.loading = true;
  //     this.pageData = {};
  //     // console.log("Совершён переход по ссылке", this.$route );
  //     // console.log("Совершён переход по ссылке", this.$route.meta );
  //     if (this.$route.meta.page) {
  //       console.log("Совершён переход по ссылке", this.$route.meta.page);
  //       this.getData(this.$route.meta.page);
  //       // this.getDataNow(this.$route.meta.page);
  //       // this.loading = false;
  //     } else {
  //       console.log("Совершён переход по ссылке NO");
  //     }
  //   },
  // },
};
</script>

<style lang="scss"></style>
