<template>
  <span>
    <!-- <div>
      result: {{ result }}
      <i class="fa fa-check" aria-hidden="true"></i>
    </div> -->
    <center>
      <b>Бесплатная консультация по телефону</b>
      <form
        @submit.prevent="formSend"
        v-if="(!loading && result != 'sended') || result == 'errored'"
      >
        <fieldset>
          <input
            xv-if="res != 'sended'"
            xtype="address"
            xname="address"
            class="email"
            :class="result == 'errored' ? 'bg-danger' : ''"
            placeholder="Укажите Ваш телефон"
            autocomplete="on"
            v-model="formPhone"
            required
            style="text-align: center"
          />
        </fieldset>
        <fieldset>
          <button type="submit" v-if="result != 'sended'" class="main-button">
            Отправить
          </button>
        </fieldset>
      </form>

      <div
        v-if="result == 'errored'"
        class="p-3 alert alert-danger text-center"
        style="border-radius: 20px"
      >
        Произошла ошибка, повторите отправку и напишите в чат (справа внизу)
      </div>
    </center>
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
      //   formName: "",
      formPhone: "",
      //   formMsg: "",
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
        "Где: " + this.titleFrom + "<br>" + "Телефон: " + this.formPhone
      );
      //   console.log('ww',ww);
      this.result = ww;
    },
  },
};
</script>
