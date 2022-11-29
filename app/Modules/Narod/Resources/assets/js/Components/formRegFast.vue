<template>
  <div class="container-fluid mt-5">
    <div class="row">
      <div class="col-12">
        <form
          name="bw"
          action=""
          method="post"
          enctype="multipart/form-data"
          class="submit send_bw5 ajax"
          div_load="ajaxform_res2"
          div_res="ajaxform_res1"
          res_ok="ajaxform_res1"
          res_error="ajaxform_res12"
          show_block_loaded="ajaxform_res2"
          @submit.prevent="sendForm"
        >

          <input
            type="hidden"
            v-model="form_now"
            />

          <table class="table table-striped" id="ttr">
            <tbody>
              <tr>
                <td>
                  <label for="fio">
                    Как Вас зовут &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="fio"
                      xname="bw[fio]"
                      type="text"
                      xvalue=""
                      rel="Как Вас зовут"
                      required=""
                      v-model="fio"
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="tel">
                    Телефон &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="tel"
                      xname="bw[tel]"
                      type="text"
                      xvalue=""
                      rel="Телефон"
                      required=""
                      v-model="phone"
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td><label for="soc_set"> Страница в соц. сети </label></td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="soc_set"
                      xname="bw[soc_set]"
                      type="text"
                      xvalue=""
                      rel="Страница в соц. сети"
                      v-model="socweb"
                    />
                  </div>
                  <small>Например http://vk.com/id123123123</small>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="polza">
                    Что можете предложить нашему обществу &nbsp;<font
                      color="red"
                      >*</font
                    ></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <textarea
                      style="width: 100%"
                      id="polza"
                      xname="bw[polza]"
                      rel="Что можете предложить нашему обществу"
                      required=""
                      v-model="predlogau"
                    ></textarea>
                  </div>
                </td>
              </tr>
              <!-- <tr>
                  <td>
                    <b>Введите цифры:<font color="red">*</font></b> 47627
                  </td>
                  <td>
                    <input
                      name="antispam"
                      style="width: 98%; text-align: center"
                      type="text"
                      value=""
                      required=""
                    />
                  </td>
                </tr> -->
              <tr>
                <td colspan="2">
                  <p>
                    Поля помеченные звёздочкой (<font color="red">*</font>)
                    обязательны для заполнения.
                  </p>
                </td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  <div
                    id="ajaxform_res12"
                    class="bg-warning"
                    style="padding: 5px 10px; display: none"
                  ></div>
                  <p>
                    <input
                      name="suba"
                      style="width: 70%; text-align: center"
                      type="submit"
                      value="Отправить"
                    />
                  </p>
                  <div id="ajaxform_res2" style="display: none">
                    <img src="/img/load.gif" alt="" border="0" />
                  </div>
                  <p></p>
                </td>
              </tr>
            </tbody>
          </table>
          <input name="action" type="hidden" value="send_ajax" /><input
            name="run_modul"
            type="hidden"
            value="051.enter"
          /><input name="id" type="hidden" value="47627" /><input
            name="s"
            type="hidden"
            value="cd781bb9311f252b24f57078744abc96"
          />
        </form>
      </div>
    </div>
  </div>
</template>

<script>

// import axios from "axios";

import { ref, onMounted } from "vue";
// import PageText from "./PageText.ts";
import FormReg from "./FormReg.ts";

// import {
//   // useRouter,
//   useRoute,
// } from "vue-router";

export default {

  data() {
    
    const fio = ref("");
    const phone = ref("");
    const socweb = ref("");
    const predlogau = ref("");

    return {
      fio,
      phone,
      socweb,
      predlogau,
    };

  },

  setup(props) {

    const {
      loading,
      sendForm,
      // getData,
      // pageData,
      // loadError
    } = FormReg();
    // // const Loading = ref(true);

    // const route = useRoute();
    const datar = ref([]);

    // onMounted(() => {
    //   console.log("mounted");
    //   getData(route.meta.page ?? "");
    // });

    // // function getDataNow(name) {
    // //   this.getData($route.meta.page);
    // // }

    return {
      // // getDataNow,
      loading,
      sendForm,
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
