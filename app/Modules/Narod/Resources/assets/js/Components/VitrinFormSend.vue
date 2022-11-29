<template>
  <div>
    <!-- 223344 - showForm {{ showForm }} -->
    <!-- showFormSumm: {{ showFormSumm }} -->
    <transition name="fade">
      <div v-if="showForm > 0" id="form_order" class="form_bottom" style="">
        <div v-if="sendForm">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="bi bi-check-circle"
            viewBox="0 0 16 16"
          >
            <path
              d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
            />
            <path
              d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"
            />
          </svg>
          Заявка отправлена, позвоним в ближайшее время
        </div>
        <div v-else>
          <!-- good -->
          <!-- {{ good }} -->
          <!-- <br /> -->
          <!-- <span class="mh150" v-for="(k, v) in good" :key="k">
            <template v-if="k > 0">v{{ v }} k{{ k }} /</template>
          </span> -->
          <!-- <br />
          <br />
          <div class="mh150">
            showFormSumm
            <span v-for="(k, v) in showFormSumm" :key="k">
              v{{ v }} k{{ k }} /
            </span>
          </div> -->
          <!-- <div class="mh150">goods {{ goods }}</div> -->

          <form method="post" @submit.prevent="sendOrder">
            <div id="form_order2">
              <div id="form_ok"></div>
              <div class="row">
                <div class="col-12 text-center"><h4>Отправить зявку</h4></div>
              </div>
              <div class="row" id="form_new">
                <div class="col-xs-6 col-md-4 col-sm-4 col-lg-3">
                  <input
                    xname="fio"
                    id="fio"
                    placeholder="Как Вас зовут"
                    class="form-control"
                    xvalue=""
                    type="text"
                    required=""
                    v-model="fio"
                  />
                </div>
                <div class="col-xs-6 col-md-4 col-sm-4 col-lg-3">
                  <input
                    placeholder="Телефон"
                    xname="phone"
                    xid="phone"
                    class="form-control"
                    type="text"
                    required=""
                    v-model="phone"
                  />
                </div>
                <div class="col-xs-6 col-md-4 col-sm-4 col-lg-2 text-center">
                  Сумма
                  <br />
                  <b>
                    <span id="fin_itog">{{ showFormSumm }}</span>
                    р
                  </b>
                  <!-- <input type="hidden" id="finsumm30" value="0" /><input
                    type="hidden"
                    name="user_type"
                    value="{if $now_price == 2 }сотрудник{else if $now_price == 1 }пайщик{else}гость{/if}"
                  /> -->
                  <!-- <input type="hidden" name="id" value="123" /><input
                    type="hidden"
                    name="s"
                    value="360fdfa219c1d3e9eb9c94fcb271fb9b"
                  /> -->
                </div>
                <div class="col-xs-6 col-md-4 col-sm-4 col-lg-2 text-center">
                  <span id="ok_but_stat"></span
                  ><input
                    id="ok_but"
                    class="btn btn-success"
                    xname="suba"
                    value="Отправить"
                    style=""
                    type="submit"
                  />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { ref, computed } from "vue";
// import axios from "axios";

// import VitrinRow from "./VitrinRow.vue";
import Vitrin from "./Vitrin.ts";

export default {
  // props: {
  // good: { type: Object },
  // goods: { type: Object },
  // },
  // data() {
  //   return {
  //       fio: '',
  //       phone: ''
  //   };
  // },
  components: {
    // VitrinRow,
  },
  setup(props) {

    const fio = ref('');
    const phone = ref('');

    const { good, pageData: goods } = Vitrin();

    // console.log("pageData", goods.value);
    // console.log("pageData", good.value);

    let x = 0;

    const showForm = computed(
      () => good.value.map((i) => (x += i), (x = 0)).reverse()[0]
    );

    // фильтруем умножаем и суммируем
    const resFind2 = ref({});
    const showFormSumm = computed(() =>
      good.value
        .map((kolvo, id) => {
          if (kolvo > 0) {
            resFind2.value = goods.value.find((el) => el.id == id);
            // console.log("resFind2.value", resFind2.value.cena1, resFind2.value);
            return 0 + Math.ceil(resFind2.value.cena3) * kolvo;
          } else {
            return 0;
          }
        })
        .reduce(function (previous, current) {
          return previous + current;
        }, 0)
    );

    const sendForm = ref(false);
    const sendFormError = ref(false);

    // const sendToTelegramm = async (msg) => {

    //     // loading.value = true;

    //     let res = await axios
    //         .post('https://api.uralweb.info/telegram.php',
    //             {
    //                 domain: window.location.hostname,
    //                 // show_datain: 1,
    //                 answer: 'json',

    //                 // s: md5('1'),
    //                 s: 'c4ca4238a0b923820dcc509a6f75849b',

    //                 // id: 1,
    //                 id: [
    //                     360209578, // я
    //                     // 222 // ещё
    //                 ],
    //                 msg
    //             })
    //         .catch((error) => {
    //             console.log("error", error);
    //             return 'errored';
    //         });

    //     if (res.data.res === true) {
    //         // sended.value = true;
    //         return 'sended';
    //     } else {
    //         // errored.value = true;
    //         return 'errored';
    //     }

    // }

    const sendOrder = () => {
      console.log(777);
      console.log(good.value);
      // sendToTelegramm(123123123);

      axios
        .post("/api/sendOrder", {
          goods: good.value,
          fio: fio.value,
          phone: phone.value
        })
        .then((response) => {
          // pageData.value = response.data.data;
          console.log("response.data", response.data);
          sendForm.value = true;
        })
        .catch((error) => {
          console.log(error);
          // loadError.value = true;
        });
    };

    // const pageData = ref("");

    // // loading.value = false;
    // axios
    //   .get("/api47/getVitrin")
    //   .then((response) => {
    //     pageData.value = response.data.data;
    //   })
    //   .catch((error) => {
    //     console.log(error);
    //     // loadError.value = true;
    //   });

    return {
      good,
      fio,
      phone,
      //   pageData,
      showForm,
      showFormSumm,
      sendOrder,
      // resFind1,
      resFind2,
      sendForm,
      sendFormError,
    };
  },
};
</script>

<style lang="scss" >
.mh150 {
  max-height: 100px;
  overflow: auto;
}

.fade-enter-active,
.fade-leave-active {
  transition: all 1s ease;
  bottom: 60px;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  bottom: 70px;
}

// * {
//   transition: all 1s ease-in-out;
// }
// .ed_iz {
//   padding: 2px 5px;
//   margin-left: 10px;
//   background-color: rgba(0, 0, 0, 0.1);
// }
#form_order {
  xborder-top-left-radius: 5px;
  xborder-bottom-left-radius: 5px;
  xdisplay: none;
  padding: 0;
  margin: 0;
  z-index: 1200;
  position: fixed;
  right: 0;
  transition: all 2s ease-in-out;
  xbottom: 30px;
}
// .form_top {
//   bottom: 80%;
// }

.form_bottom {
  display: block;
  bottom: 50px;
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
  > div {
    background-color: #fff3ac;
    box-shadow: 0 0 10px gray;
    margin: 0;
    padding: 10px;
  }
  td {
    height: 35px;
  }
}
// input.summa {
//   width: 90px;
//   background-color: transparent;
//   border: none;
// }
// .but_bay input.kolvo {
//   width: 45px;
//   text-align: center;
// }
// .but_bay button {
//   display: none;
// }
// div.item {
//   min-height: 40px;
//   padding-bottom: 5px;
//   padding-top: 5px;
// }
// div.item:hover button {
//   display: inline-block;
// }
// div.item:hover button {
//   display: inline-block;
// }
// div.item:nth-child(2n) {
//   background-color: rgba(0, 0, 0, 0.05);
// }
// .warn {
//   background-color: yellow;
//   padding: 10px;
//   border-radius: 5px;
//   margin: 10px;
// }
// .shop1_opt_items a {
//   display: block;
//   background-color: rgba(200, 250, 250, 0.4);
//   padding: 5px;
//   margin-bottom: 3px;
//   border-radius: 5px;
// }
// .shop1_opt_item a:hover,
// .shop1_opt_items .active {
//   background-color: rgba(100, 150, 150, 0.4);
// }
// .price {
//   font-size: 16px;
//   color: #ce7200;
// }
// .item .price_old {
// }
// a.name:visited {
//   color: #9f00e6;
//   border-bottom: 1px solid #ebbdff;
// }
// a.name {
//   font-size: 16px;
//   color: #5e5fff;
//   text-decoration: none;
//   border-bottom: 1px solid #cacaff;
//   outline: none;
// }
// a.name:hover {
//   text-decoration: none;
//   color: orange;
//   border-bottom: 1px solid #fff097;
// }
// .but_buy_ok {
//   padding: 5px 10px 5px 10px;
// }
// .cart_icon {
//   color: orange;
//   font-size: 20px;
// }
// .cart_body {
// //   x-padding: 10px 20px 10px 20px;
// }
// .cart_price {
//   color: orange;
//   font-size: 16px;
//   font-weight: bold;
// }
// .up_line {
//   border-bottom: 1px solid rgba(0, 0, 0, 0.2);
// }
// .search_form {
//   max-width: 350px;
//   padding: 10px 5px 10px 5px;
// }
// .cart .for_img {
//   height: 160px;
//   width: 160px;
//   display: inline-block;
// }
// .cart img {
//   max-height: 100px;
//   max-width: 100px;
//   float: left;
//   padding: 5px;
// }
// .cart input.kolvo2 {
//   width: 50px;
// }
// .cart input[type="checkbox"] {
// }
// .order_div {
//   color: white;
//   background: rgb(110, 110, 110); /* Old Browsers */
//   background: -webkit-linear-gradient(
//     bottom left,
//     rgb(110, 110, 110),
//     rgb(180, 180, 180)
//   ); /*Safari 5.1-6*/
//   background: -o-linear-gradient(
//     bottom left,
//     rgb(110, 110, 110),
//     rgb(180, 180, 180)
//   ); /*Opera 11.1-12*/
//   background: -moz-linear-gradient(
//     bottom left,
//     rgb(110, 110, 110),
//     rgb(180, 180, 180)
//   ); /*Fx 3.6-15*/
//   background: linear-gradient(
//     bottom left,
//     rgb(110, 110, 110),
//     rgb(180, 180, 180)
//   ); /*Standard*/
//   padding: 20px;
//   border-radius: 10px;
// }
// .order_div textarea,
// .order_div input[type="email"],
// .order_div input[type="text"] {
//   margin-bottom: 10px;
// }
// #summ_for_pay {
//   color: orange;
//   font-size: 20px;
//   font-weight: bold;
//   font-style: italic;
// }
// .list_in_cats .row > div {
//   padding: 10px;
// }
// .list_in_cats .row {
//   background-color: rgba(0, 0, 0, 0.1);
// }
// .list_in_cats .row:nth-child(2n) {
//   background-color: rgba(0, 0, 0, 0.01);
// }
// .order_okey {
//   background: #f2c14e; /* ��� ���������, ������� �� ������������ ��������� */
//   background: -webkit-linear-gradient(
//     left,
//     #f2c14e,
//     #f78154
//   ); /* ��� Safari 5.1 - 6.0 */
//   background: -o-linear-gradient(
//     left,
//     #f2c14e,
//     #f78154
//   ); /* ��� Opera 11.1 - 12.0 */
//   background: -moz-linear-gradient(
//     left,
//     #f2c14e,
//     #f78154
//   ); /* ��� Firefox 3.6 - 15 */
//   background: linear-gradient(
//     left,
//     #f2c14e,
//     #f78154
//   ); /* ����������� ��������� */
//   width: 100%;
//   text-align: center;
//   color: white;
//   text-shadow: 0 0 5px gray;
//   font-size: 26px;
//   padding: 20vh 10vh;
// }
// .myshop_catalogs2 {
//   background-color: #ffe4c3;
//   padding-top: 20px;
//   padding-bottom: 20px;
// }
// .myshop_catalogs2 a {
//   padding: 2px;
//   display: block;
//   background-color: rgba(0, 0, 0, 0.05);
//   margin-bottom: 3px;
// }
// .item_2line {
//   color: #aaaaaa;
//   text-align: right;
//   padding: 15px;
//   border-bottom: 1px solid #aaaaaa;
//   margin-bottom: 10px;
// }
// .item_price {
//   border: 1px solid #bebebe;
//   padding: 0;
//   max-width: 250px;
//   margin: 0 auto;
//   border-radius: 5px;
//   overflow: hidden;
// }
// .item_price .div01 {
//   padding: 10px;
// }
// .item_price h3 {
//   display: block;
//   text-align: center;
//   font-size: 30px;
// }
// .item_price .price_old {
//   font-size: 16px;
//   display: inline;
//   color: gray;
// }
// x.item_price .price_old:after {
//   x-position: relative;
//   position: absolute;
//   display: inline-block;
//   content: "";
//   left: 20px;
//   height: 20px;
//   width: 50px;
//   background: center
//     url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACoAAAAOCAYAAABZ/o57AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAKZJREFUeNpi/F/BMBgBGxAbArEJEMsBcTnLIHKcMBCbArEZEOtDHQsDogPtUBUgNoeGnAqa3B0gPgPEJ4H4NcsARinIgYJIcr+A+CIQnwLi00D8FlkjywBH6XtoiIFC7jzUsVgBywBH6R1iDWQZ6Cilh0OpEqW0cijVo5RaDqV5lFLiULpGKakOHbAoJcWhkkDcP1BRSopDnwPxLSC+NxBRSiwACDAARtQ7rVrTUZYAAAAASUVORK5CYII=")
//     no-repeat;
//   background-repeat: no-repeat;
//   opacity: 0.8;
// }
// .item_price .but_buy_ok,
// .item_price .but_buy {
//   text-decoration: none;
//   display: block;
//   padding-top: 20px;
//   padding-bottom: 20px;
//   text-align: center;
//   font-family: Arial, sans-serif;
//   font-size: 16px;
// }
// .item_price .but_buy {
//   background-color: #0f77b0;
//   color: white;
//   font-weight: bold;
// }
// .item_price .but_buy_ok {
//   background-color: #00b06b;
//   color: white;
//   font-weight: bold;
// }
// .item_price .but_buy_ok font {
//   font-weight: normal;
//   display: block;
// }
// .view_item .but_buy_ok a {
//   color: white;
// }
// .view_item .but_buy_ok sup a {
//   color: rgba(255, 255, 255, 0.5);
// }
// .view_item .but_buy_ok sup a:hover {
//   color: rgba(255, 55, 55, 0.9);
// }
// .link_block {
//   cursor: pointer;
// }
// .link_block:hover {
//   background-color: rgba(0, 0, 0, 0.05);
// }
// .row_mnu .xbtn2 {
//   padding: 12px 20px;
//   display: inline-block;
//   border-right: 1px solid #e5e5e5;
//   font-size: 1.3em;
//   font-weight: bold;
//   color: #454545;
// }
// .row_mnu .btn-group:hover .xbtn2 {
//   background-color: yellow;
//   box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15);
// }
// .row_mnu .dropdown-menu a {
//   padding: 10px 20px;
// }
// @font-face {
//   font-family: "ALSRubl-Arial";
//   src: url("/fonts/alsrubl-arial-regular.eot");
//   src: url("/fonts/alsrubl-arial-regular.eot?#iefix")
//       format("embedded-opentype"),
//     url("/fonts/alsrubl-arial-regular.woff") format("woff"),
//     url("/fonts/alsrubl-arial-regular.ttf") format("truetype"),
//     url("/fonts/alsrubl-arial-regular.svg#ALSRublArialRegular") format("svg");
//   font-weight: normal;
//   font-style: normal;
// }
// @font-face {
//   font-family: "ALSRubl-Arial";
//   src: url("/fonts/alsrubl-arial-italic.eot");
//   src: url("/fonts/alsrubl-arial-italic.eot?#iefix") format("embedded-opentype"),
//     url("/fonts/alsrubl-arial-italic.woff") format("woff"),
//     url("/fonts/alsrubl-arial-italic.ttf") format("truetype"),
//     url("/fonts/alsrubl-arial-italic.svg#ALSRublArialItalic") format("svg");
//   font-weight: normal;
//   font-style: italic;
// }
// @font-face {
//   font-family: "ALSRubl-Arial";
//   src: url("/fonts/alsrubl-arial-bold.eot");
//   src: url("/fonts/alsrubl-arial-bold.eot?#iefix") format("embedded-opentype"),
//     url("/fonts/alsrubl-arial-bold.woff") format("woff"),
//     url("/fonts/alsrubl-arial-bold.ttf") format("truetype"),
//     url("/fonts/alsrubl-arial-bold.svg#ALSRublArialBold") format("svg");
//   font-weight: bold;
//   font-style: normal;
// }
// @font-face {
//   font-family: "ALSRubl-Arial";
//   src: url("/fonts/alsrubl-arial-bolditalic.eot");
//   src: url("/fonts/alsrubl-arial-bolditalic.eot?#iefix")
//       format("embedded-opentype"),
//     url("/fonts/alsrubl-arial-bolditalic.woff") format("woff"),
//     url("/fonts/alsrubl-arial-bolditalic.ttf") format("truetype"),
//     url("/fonts/alsrubl-arial-bolditalic.svg#ALSRublArialBoldItalic")
//       format("svg");
//   font-weight: bold;
//   font-style: italic;
// }
// .ruble {
//   font-family: "ALSRubl-Arial", Arial, sans-serif;
//   line-height: normal;
// }
// footer {
//   xbackground-color: #ffe600;
//   xbox-shadow: 0 0 10px black;
// }
// footer .copy_center {
//   margin-top: 1em;
//   margin-bottom: 1em;
// }
// footer .copy_center > a {
//   font-size: 3em;
//   font-weight: bold;
//   color: #454545;
//   display: block;
// }
// footer .copy1 {
//   margin-top: 2em;
// }
// .myshop.all_bg {
//   xbackground-color: rgba(255, 255, 255, 0.4);
// }
// .myshop.mnu_left a {
//   padding: 5px;
//   display: block;
//   margin-bottom: 2px;
//   background-color: rgba(255, 255, 255, 0.3);
//   color: white;
//   font-weight: bold;
// }
// .myshop.mnu_left a.active {
//   background-color: rgba(155, 255, 155, 0.7);
//   color: black;
// }
// .myshop.mnu_left a:hover {
//   background-color: rgba(155, 255, 155, 0.5);
//   color: black;
//   text-decoration: none;
// }
// .myshop .myshop_item_small {
//   padding: 5px;
//   background-color: rgba(255, 255, 255, 0.9);
//   display: inline-block;
//   margin-right: 10px;
//   margin-bottom: 10px;
// }
// .myshop .myshop_item_small img {
//   max-height: 200px;
//   width: auto;
//   margin: 0 auto;
// }
// .myshop .myshop_item_small .name {
//   display: block;
//   text-align: center;
//   color: #454545;
//   font-weight: bold;
//   text-decoration: none;
// }
// .myshop .body_page {
//   background-color: white;
//   border-radius: 5px;
//   padding: 10px;
//   display: block;
//   margin-left: 10px;
//   margin-bottom: 10px;
// }
// .myshop .btn_buy2 {
//   background-color: yellow;
//   padding: 5px 20px;
//   color: black;
//   border-radius: 5px;
//   font-weight: bold;
//   font-size: 1.3em;
// }
// .myshop .btn_buy2:hover {
//   box-shadow: 0 0 5px gray;
// }
// .myshop .price {
//   color: #333;
//   font-weight: bold;
//   font-size: 1.3em;
// }
// .myshop strike.price-old2 {
//   text-decoration: line-through;
//   color: #c9c9c9;
//   margin-right: 10px;
// }
</style>
