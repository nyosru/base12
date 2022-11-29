<template>

  <!-- <header1></header1> -->

  <div class="main">
    <router-view name="bodyContent"></router-view>
  </div>

  <!-- <footer1></footer1> -->

</template>

<script>
// import axios from "axios";

// import Backword from "./components/Backword.vue";
// import BackwordMini from "./components/BackwordMini.vue";

// import header1 from "./Header.vue";
// // import bodys from "./page/body.vue";
// import footer from "./footer.vue";

export default {
  components: {
    // header1,
    // body1: bodys,
    // footer1: footer,
  },

  setup(props) {
    // let token = document.head.querySelector('meta[name="csrf-token"]');

    // // axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
    // axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*";

    // if (token) {
    //   axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
    // } else {
    //   console.error(
    //     "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    //   );
    // }
    return {};
  },

  // data() {
  //     return {
  //         preloader: true,
  //         show_menu: true,
  //         // show_iframe_div: false,
  //         // show_iframe_div: true,
  //         // message: "js2 route!",
  //         // now: new Date()
  //         // now: "da da da 1 ",
  //     };
  // },

  // computed(){
  //     console.log('2222');
  // }

  // methods: {
  //     hidePreloader(e) {
  //         console.log(333);
  //         this.preloader = false;
  //     },
  // },

  //   components: {
  //     // Backword,
  //     // BackwordMini,
  //     // appMenu,
  //     // itemOnOff,
  //     // notFound,
  //     // pageIndex
  //   },

  // router
  // async created() {

  //     const index_var = await axios
  //         .get("/closer/api/get_index")
  //         .catch((error) => {
  //             console.log(error);
  //             // this.errored = true;
  //         })
  //         .finally(() => {
  //             // this.loading = false;
  //         });

  //     // this.content_show = this.content = booms.data;
  //     // console.log("content", this.content);
  // },
};
</script>

<style lang="scss">
.main {
  min-height: 65vh;
}
</style>
