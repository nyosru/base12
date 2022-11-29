
<script>
// import axios from "axios";

import { ref, onMounted } from "vue";

// import Tehnologii from "./components/Tehnologii.vue";
// import Backword from "./components/Tehnologii.vue";
// import BackwordMini from "./components/BackwordMini.vue";

// import confetti from "https://cdn.skypack.dev/canvas-confetti";

import confetti from "canvas-confetti";
// require('canvas-confetti');

import { useRoute } from "vue-router";

import AppMenu from "./components/menu.vue";
import photos from "./components/IndexPhotos.vue";

export default {
  setup(props) {
    let token = document.head.querySelector('meta[name="csrf-token"]');

    // axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
    axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*";

    if (token) {
      axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
    } else {
      console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
      );
    }

    const route = useRoute();

    console.log("route", route);
    // console.log("currentRouteName", currentRouteName);

    // onMounted(() => {
    //   (function (m, e, t, r, i, k, a) {
    //     m[i] =
    //       m[i] ||
    //       function () {
    //         (m[i].a = m[i].a || []).push(arguments);
    //       };
    //     m[i].l = 1 * new Date();
    //     (k = e.createElement(t)),
    //       (a = e.getElementsByTagName(t)[0]),
    //       (k.async = 1),
    //       (k.src = r),
    //       a.parentNode.insertBefore(k, a);
    //   })(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    //   ym(76358443, "init", {
    //     clickmap: true,
    //     trackLinks: true,
    //     accurateTrackBounce: true,
    //   });
    // });



    // onMounted(() => {
    //   window.replainSettings = { id: "b425c1ea-1e24-4a28-bd66-fb7a3ed2011d" };
    //   (function (u) {
    //     var s = document.createElement("script");
    //     s.type = "text/javascript";
    //     s.async = true;
    //     s.src = u;
    //     var x = document.getElementsByTagName("script")[0];
    //     x.parentNode.insertBefore(s, x);
    //   })("https://widget.replain.cc/dist/client.js");
    // });


    // const preloader = ref(true);
    const preloader = ref(false);

    onMounted(() => {
      confetti();

      setTimeout(() => {
        confetti.reset();
      }, 40000);

    //   setTimeout(() => {
    //     preloader.value = false;
    //   }, 10000);
    });

    return {
      route,
      preloader,
    };
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
  computed: {
    currentRouteName() {
      return this.$route.name;
    },
  },
  components: {
    photos,
    // Tehnologii,
    AppMenu,
    // Backword,
    // BackwordMini,
    // appMenu,
    // itemOnOff,
    // notFound,
    // pageIndex
  },

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
html {
  scroll-behavior: smooth;
}

body {
  background-color: #ffffff;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='383' height='383' viewBox='0 0 800 800'%3E%3Cg fill='none' stroke='%23FBF3EB' stroke-width='3.3'%3E%3Cpath d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63'/%3E%3Cpath d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764'/%3E%3Cpath d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880'/%3E%3Cpath d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382'/%3E%3Cpath d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269'/%3E%3C/g%3E%3Cg fill='%23FEF8E5'%3E%3Ccircle cx='769' cy='229' r='11'/%3E%3Ccircle cx='539' cy='269' r='11'/%3E%3Ccircle cx='603' cy='493' r='11'/%3E%3Ccircle cx='731' cy='737' r='11'/%3E%3Ccircle cx='520' cy='660' r='11'/%3E%3Ccircle cx='309' cy='538' r='11'/%3E%3Ccircle cx='295' cy='764' r='11'/%3E%3Ccircle cx='40' cy='599' r='11'/%3E%3Ccircle cx='102' cy='382' r='11'/%3E%3Ccircle cx='127' cy='80' r='11'/%3E%3Ccircle cx='370' cy='105' r='11'/%3E%3Ccircle cx='578' cy='42' r='11'/%3E%3Ccircle cx='237' cy='261' r='11'/%3E%3Ccircle cx='390' cy='382' r='11'/%3E%3C/g%3E%3C/svg%3E");
}

// // #services>div{
// //     margin-top:20px;
// //     margin-bottom: 20px;
// // }
// #services {
//   .section {
//     margin-top: 15vh;
//     xmargin-bottom: 10vh;
//   }

//   h2 {
//     font-size: 50px;
//     font-weight: 700;
//     color: #2a2a2a;
//     line-height: 72px;
//   }
//   h2 em {
//     color: #03a4ed;
//   }

//   h2 span {
//     color: #fe3f40;
//   }
// }
</style>
