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
                  <label for="fam">
                    Фамилия &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="fam"
                      name="bw[fam]"
                      type="text"
                      value=""
                      rel="Фамилия"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="fio_name">
                    Имя &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="fio_name"
                      name="bw[fio_name]"
                      type="text"
                      value=""
                      rel="Имя"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td><label for="soname"> Отчество </label></td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="soname"
                      name="bw[soname]"
                      type="text"
                      value=""
                      rel="Отчество"
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
                  <label for="gragdanstvo">
                    Гражданство &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="gragdanstvo"
                      name="bw[gragdanstvo]"
                      type="text"
                      value=""
                      rel="Гражданство"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="dr">
                    День рожденья &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="dr"
                      name="bw[dr]"
                      type="text"
                      value=""
                      rel="День рожденья"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="pasport_seria">
                    Документ серия &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="pasport_seria"
                      name="bw[pasport_seria]"
                      type="text"
                      value=""
                      rel="Документ серия"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="pasport_nom">
                    Документ номер &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="pasport_nom"
                      name="bw[pasport_nom]"
                      type="text"
                      value=""
                      rel="Документ номер"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="pasport_dv">
                    Дата выдачи &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="pasport_dv"
                      name="bw[pasport_dv]"
                      type="text"
                      value=""
                      rel="Дата выдачи"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="pasport_vudan">
                    Кем выдан &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="pasport_vudan"
                      name="bw[pasport_vudan]"
                      type="text"
                      value=""
                      rel="Кем выдан"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="pasport_reg">
                    Адрес регистрации &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="pasport_reg"
                      name="bw[pasport_reg]"
                      type="text"
                      value=""
                      rel="Адрес регистрации"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td><label for="inn"> ИНН </label></td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="inn"
                      name="bw[inn]"
                      type="text"
                      value=""
                      rel="ИНН"
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td><label for="ogrn"> ОГРНИП </label></td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="ogrn"
                      name="bw[ogrn]"
                      type="text"
                      value=""
                      rel="ОГРНИП"
                    />
                  </div>
                  <small>только для индивидуальных предпринимателей</small>
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
                  <label for="bank_pol">
                    Получатель в платежном поручении при перечислении Вам
                    &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="bank_pol"
                      name="bw[bank_pol]"
                      type="text"
                      value=""
                      rel="Получатель в платежном поручении при перечислении Вам"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="bank_inn">
                    ИНН в платежном поручении при перечислении Вам &nbsp;<font
                      color="red"
                      >*</font
                    ></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="bank_inn"
                      name="bw[bank_inn]"
                      type="text"
                      value=""
                      rel="ИНН в платежном поручении при перечислении Вам"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="bank_kpp">
                    КПП в платежном поручении при перечислении Вам &nbsp;<font
                      color="red"
                      >*</font
                    ></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="bank_kpp"
                      name="bw[bank_kpp]"
                      type="text"
                      value=""
                      rel="КПП в платежном поручении при перечислении Вам"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="bank_БИК">
                    БИК банка &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <input
                      style="width: 100%"
                      id="bank_БИК"
                      name="bw[bank_БИК]"
                      type="text"
                      value=""
                      rel="БИК банка"
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="bank_rs">
                    Расчётный счёт в платежном поручении при перечислении Вам
                    &nbsp;<font color="red">*</font></label
                  >
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
                      required=""
                    />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="bank_name_pay">
                    Назначение платежа в платежном поручении при перечислении
                    Вам &nbsp;<font color="red">*</font></label
                  >
                </td>
                <td>
                  <div class="xform-group">
                    <textarea
                      style="width: 100%"
                      id="bank_name_pay"
                      name="bw[bank_name_pay]"
                      rel="Назначение платежа в платежном поручении при перечислении Вам"
                      required=""
                    ></textarea>
                  </div>
                </td>
              </tr>
              <!-- <tr>
                <td>
                  <b>Введите цифры:<font color="red">*</font></b> 13640
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
            value="051.enter_fiz"
          /><input name="id" type="hidden" value="13640" /><input
            name="s"
            type="hidden"
            value="1e92d1a667eb9018644e49697f843ebb"
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
