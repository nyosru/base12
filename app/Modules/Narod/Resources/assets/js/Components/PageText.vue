<template>
  <div class="main">
    <!-- PageText
    <br />-->
    <!-- <br />
    loading {{ loading }} -->
    <!-- <br />
    <br />
    pageData: {{ pageData }} -->

    <div class="container mt-3">

      <div class="row" v-if="loading === true">
        <div class="col-12 text-center">
          <p>... загружаю ...</p>
        </div>
      </div>

      <div class="row" v-else>

          <div class="col-0 col-lg-2" ></div>

        <template v-if="loadError"> <div class="col-12" ><p>Произошла ошибочка</p></div>  </template>
        <template v-else>

          <div class="col-12 col-lg-8" v-if="pageData && pageData.name">
            <h2>{{ pageData.name }}</h2>
          </div>

          <div class="col-12 col-lg-8" v-if="pageData && pageData.html">
            <span v-html="pageData.html" ></span>
          </div>
        </template>
      </div>
      
    </div>
  </div>
</template>

<script>
// import axios from "axios";

import { ref, onMounted } from "vue";
import PageText from "./PageText.ts";

import {
  // useRouter,
  useRoute,
} from "vue-router";

export default {
  setup(props) {
    const { loading, getData, pageData, loadError } = PageText();
    // const Loading = ref(true);

    const route = useRoute();

    onMounted(() => {
      console.log("mounted");
      getData(route.meta.page ?? "");
    });

    // function getDataNow(name) {
    //   this.getData($route.meta.page);
    // }

    return {
      // getDataNow,
      loading,
      getData,
      pageData,
      loadError,
    };
  },
  watch: {
    "$route.path"() {
      this.loading = true;
      this.pageData = {};
      // console.log("Совершён переход по ссылке", this.$route );
      // console.log("Совершён переход по ссылке", this.$route.meta );
      if (this.$route.meta.page) {
        console.log("Совершён переход по ссылке", this.$route.meta.page);
        this.getData(this.$route.meta.page);
        // this.getDataNow(this.$route.meta.page);
        // this.loading = false;
      } else {
        console.log("Совершён переход по ссылке NO");
      }
    },
  },
};
</script>

<style lang="scss"></style>
