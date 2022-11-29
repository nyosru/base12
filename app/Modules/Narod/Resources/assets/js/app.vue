<script>
import axios from "axios";

// import Backword from "./components/Backword.vue";
// import BackwordMini from "./components/BackwordMini.vue";

import PageBody from "./page/body.vue";

// import header1 from "./page/header.vue";
// import header1 from "./page/HeaderComponent.vue";
import footer1 from "./page/footer.vue";
import HeaderMenu from "./page/HeaderMenu.vue";
import User from "./use/User.ts";

export default {
  components: {
    PageBody,
    // header1,
    HeaderMenu,
    footer1,
  },

  setup(props) {
    const { userId } = User();

    let u1 = document.head.querySelector('meta[name="user"]');
    if (u1 && u1.content > 0) {
      userId.value = u1.content;
    }

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

  // Backword,
  // BackwordMini,
  // appMenu,
  // itemOnOff,
  // notFound,
  // pageIndex

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
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 14px;
  line-height: 1.4;
}

// #services>div{
//     margin-top:20px;
//     margin-bottom: 20px;
// }
#services {
  .section {
    margin-top: 15vh;
    xmargin-bottom: 10vh;
  }

  h2 {
    font-size: 50px;
    font-weight: 700;
    color: #2a2a2a;
    line-height: 72px;
  }
  h2 em {
    color: #03a4ed;
  }

  h2 span {
    color: #fe3f40;
  }
}

header {
  background-image: url("/narod/img/bg_up.png");
  min-height: 150px;
  background-size: cover;
  box-shadow: inset 0 0 10px gray;
  > div {
    background-image: linear-gradient(
      to left,
      rgba(255, 255, 255, 0),
      rgba(255, 255, 255, 0.8)
    );
    height: 150px;
  }
}
</style>
