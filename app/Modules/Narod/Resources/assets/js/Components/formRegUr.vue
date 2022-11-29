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
        >
          <table class="table table-striped" id="ttr">
            <tbody>
              <tr>
                <td>
                  <label for="comp_name">
                    Название компании &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="comp_name"
                      name="bw[comp_name]"
                      type="text"
                      value=""
                      rel="Название компании"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="comp_dir">
                    Руководитель &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="comp_dir"
                      name="bw[comp_dir]"
                      type="text"
                      value=""
                      rel="Руководитель"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="inn"> ИНН &nbsp;<font color="red">*</font></label>
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="inn"
                      name="bw[inn]"
                      type="text"
                      value=""
                      rel="ИНН"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="kpp"> КПП &nbsp;<font color="red">*</font></label>
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="kpp"
                      name="bw[kpp]"
                      type="text"
                      value=""
                      rel="КПП"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="ogrn">
                    ОГРН &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="ogrn"
                      name="bw[ogrn]"
                      type="text"
                      value=""
                      rel="ОГРН"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td><label for="glav_buh"> Главный бухгалтер </label></td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="glav_buh"
                      name="bw[glav_buh]"
                      type="text"
                      value=""
                      rel="Главный бухгалтер"
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="fio">
                    Контактное лицо ФИО &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="fio"
                      name="bw[fio]"
                      type="text"
                      value=""
                      rel="Контактное лицо ФИО"
                      required=""
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
                      name="bw[tel]"
                      type="text"
                      value=""
                      rel="Телефон"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="soc_set">
                    Страница в соц. сети &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="soc_set"
                      name="bw[soc_set]"
                      type="text"
                      value=""
                      rel="Страница в соц. сети"
                      required=""
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
                      name="bw[polza]"
                      rel="Что можете предложить нашему обществу"
                      required=""
                    ></textarea>
                  </div>
                  <small>услуги, продукцию, знания</small>
                </td>
              </tr>
              <tr>
                <th colspan="2" style="text-align: center">
                  Банковские реквизиты
                </th>
              </tr>
              <tr>
                <td>
                  <label for="bank_pol1">
                    Получатель в платежном поручении при перечислении Вам
                  </label>
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="bank_pol1"
                      name="bw[bank_pol1]"
                      type="text"
                      value=""
                      rel="Получатель в платежном поручении при перечислении Вам"
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="bank_pol2">
                    ИНН в платежном поручении при перечислении Вам
                  </label>
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="bank_pol2"
                      name="bw[bank_pol2]"
                      type="text"
                      value=""
                      rel="ИНН в платежном поручении при перечислении Вам"
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="bank_pol3">
                    КПП в платежном поручении при перечислении Вам
                  </label>
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="bank_pol3"
                      name="bw[bank_pol3]"
                      type="text"
                      value=""
                      rel="КПП в платежном поручении при перечислении Вам"
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td><label for="bank_БИК"> БИК банка </label></td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="bank_БИК"
                      name="bw[bank_БИК]"
                      type="text"
                      value=""
                      rel="БИК банка"
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="bank_rs">
                    Расчётный счёт в платежном поручении при перечислении Вам
                  </label>
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="bank_rs"
                      name="bw[bank_rs]"
                      type="text"
                      value=""
                      rel="Расчётный счёт в платежном поручении при перечислении Вам"
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="bank_name_pay">
                    Назначение платежа в платежном поручении при перечислении
                    Вам
                  </label>
                </td>
                <td>
                  <div class="xform-group">
                    <textarea
                      style="width: 100%"
                      id="bank_name_pay"
                      name="bw[bank_name_pay]"
                      rel="Назначение платежа в платежном поручении при перечислении Вам"
                    ></textarea>
                  </div>
                </td>
              </tr>
              <!-- <tr>
                <td>
                  <b>Введите цифры:<font color="red">*</font></b> 44211
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
            value="051.enter_ur"
          /><input name="id" type="hidden" value="44211" /><input
            name="s"
            type="hidden"
            value="2b96e2e19ce52902c708217dd5ddbe71"
          />
        </form>
      </div>
    </div>
  </div>
</template>

<script>
// import axios from "axios";

// import { ref, onMounted } from "vue";
// import PageText from "./PageText.ts";

// import {
//   // useRouter,
//   useRoute,
// } from "vue-router";

export default {
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

    return {
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
