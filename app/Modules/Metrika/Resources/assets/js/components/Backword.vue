<template>
  <div class="container">
    <div class="row">
      <div
        class="col-lg-6 align-self-center wow fadeInLeft"
        data-wow-duration="0.5s"
        data-wow-delay="0.25s"
      >
        <div class="section-heading contact_text">
          <h2>Отправьте сообщение</h2>
          <p>Предлагаем начать диалог, отправьте сообщение и свой телефон</p>
          <br />
          <br />
          <br />
          <p>
            Тел: <a class="ss" href="tel:+79630692692">+7-963-0-692-692</a>
            <br />
            E-mail:
            <a class="ss" href="mailto:b-metrology@inbox.ru"
              >b-metrology@inbox.ru</a
            >
          </p>
          <!-- <div class="phone-info">
            <h4>
              For any enquiry, Call Us:
              <span><i class="fa fa-phone"></i> <a href="#">010-020-0340</a></span>
            </h4>
          </div> -->
        </div>
      </div>

      <div
        class="col-lg-6 wow fadeInRight"
        data-wow-duration="0.5s"
        data-wow-delay="0.25s"
      >
        <span>
          <!-- <div>
      result: {{ result }}
      <i class="fa fa-check" aria-hidden="true"></i>
    </div> -->
          <!-- <form
    > -->
          <!-- <fieldset>
        <input
          xv-if="res != 'sended'"
          xtype="address"
          xname="address"
          class="email"
          :class="result == 'errored' ? 'bg-danger' : ''"
          placeholder="Ваш телефон"
          autocomplete="on"
          v-model="formPhone"
          required
          style="text-align: center"
        />
      </fieldset>
      <fieldset>
      </fieldset>
    </form> -->

          <form
            id="contact"
            @submit.prevent="formSend"
            v-if="(!loading && result != 'sended') || result == 'errored'"
          >
            <div class="row">
              <div class="col-lg-6">
                <fieldset>
                  <input
                    placeholder="Укажите Имя"
                    v-model="formName"
                    type="name"
                    name="name"
                    id="name"
                    autocomplete="on"
                    required
                  />
                </fieldset>
              </div>
              <!-- <div class="col-lg-6">
              <fieldset>
                <input
                  type="surname"
                  name="surname"
                  id="surname"
                  placeholder="Surname"
                  autocomplete="on"
                  required
                />
              </fieldset>
            </div> -->
              <div class="col-lg-12">
                <fieldset>
                  <input
                    type="text"
                    v-model="formPhone"
                    placeholder="Телефон"
                    required=""
                  />
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <textarea
                    name="message"
                    type="text"
                    v-model="formMsg"
                    class="form-control"
                    id="message"
                    placeholder="Сообщение/вопрос"
                    required=""
                  ></textarea>
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <!-- <button type="submit" id="form-submit" class="main-button">
                  Отправить
                </button> -->

                  <button type="submit" v-if="result != 'sended'" class="main-button">
                    Отправить
                  </button>
                </fieldset>
              </div>
            </div>
            <div class="contact-dec">
              <img src="/metrika/assets/images/contact-decoration.png" alt="" />
            </div>
          </form>

          <div
            v-if="result == 'errored'"
            class="p-3 alert alert-danger text-center"
            style="border-radius: 20px"
          >
            Произошла ошибка, повторите отправку и напишите в чат (справа внизу)
          </div>

          <div
            v-if="loading && result != 'sended' && result != 'errored'"
            class="p-3 alert alert-warning text-center"
            style="border-radius: 20px"
          >
            <!-- <i class="fa fa-check" aria-hidden="true"></i> -->
            <img src="/metrika/img/load.gif" style="width: 80px" />
          </div>

          <div
            v-if="result == 'sended'"
            class="p-3 alert alert-success text-center"
            style="border-radius: 20px"
          >
            <i class="fa fa-check" aria-hidden="true"></i>
            Указали тел: {{ formPhone }} Скоро позвоним, спасибо!
          </div>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";

import sendTelegramm from "./../use/sendTelegramm.ts";

export default {
  props: {
    titleFrom: { type: String, default: "x" },
  },

  data() {
    return {
      formName: "",
      formPhone: "",
      formMsg: "",
    };
  },

  setup(props) {
    const result = ref("x");
    const loading = ref(false);

    return {
      result,
      loading,
    };
  },

  //   mounted() {
  //     console.log("Component mounted.");
  //   },
  methods: {
    async formSend() {
      //   console.log(2222, this.formName, this.formPhone, this.formMsg);
      //   console.log(2222, this.formPhone, this.titleFrom);

      this.loading = true;

      const { sendToTelegramm } = sendTelegramm();
      let ww = await sendToTelegramm(
        "Где: " +
          this.titleFrom +
          "<br>" +
          "Как зовут: " +
          this.formName +
          "<br>" +
          "Телефон: " +
          this.formPhone +
          "<br>" +
          "Сообщение: " +
          this.formMsg
      );
      //   console.log('ww',ww);
      this.result = ww;
    },
  },
};
</script>

<style>
body a.ss { color: white; }
body a.ss:HOVER { text-decoration: underline; }
</style>
