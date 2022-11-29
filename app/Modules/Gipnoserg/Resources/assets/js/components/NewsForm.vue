<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        форма
        <form @submit.prevent="submitForm()">
          <br />
          название
          <br />
          <input type="text" v-model="head" class="form-control" required />
          <br />
          дата
          <br />
          <input type="date" v-model="date" class="form-control" required />
          <br />
          картинка
          <br />
          <input type="file" @change="fileAdd" class="form-control" />
          <br />
          описание
          <br />
          <textarea v-model="text" class="form-control"></textarea>
          <br />
            ссылка
          <br />
          <input type="text" v-model="link" class="form-control" />
          <br />
          <br />
          <br />
          <button type="submit" class="btn btn-info">добавить</button> result {{ result }}
          <br />
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
// import sendTelegramm from "./../use/sendTelegramm.ts";

// import dayjs from "dayjs";
import news from "./news.ts";

// require("dayjs/locale/ru");
// dayjs.locale("ru");

export default {
  //   props: {
  //     titleFrom: { type: String, default: "x" },
  //   },

  data() {
    return {
      head: "",
      date: "",
      text: "",
      link: "",
      attachment: {},
    };
  },

  setup(props) {
    const result = ref(false);
    // const loading = ref(false);

    // onMounted(() => {
    //   getNews();
    // });

    return {
      result,
      //   news_data,
      //   result,
      //   loading,
    };
  },

  //   //   mounted() {
  //   //     console.log("Component mounted.");
  //   //   },
  methods: {

    fileAdd(e) {

        console.log('dddd');

// console.log(e.target);

        // this.attachment = e.target.files[0]
        this.attachment = e.target.files[0]

        console.log(this.attachment);

    },

    submitForm() {

      this.result = false;
      console.log(2222, this.head, this.date, this.text , this.attachment , this.link );

      const { addNews, getNews } = news();
      this.result = addNews( this.head, this.date, this.text , this.attachment , this.link );
      this.head = "";
      this.date = "";
      this.text = "";
      this.link = "";
      this.attachment = {};
      getNews();

    },
    // showDate(date) {
    //   //   console.log("date", date);
    //   //   console.log("date2", dayjs(date, "DD-MM-YYYY").format("DD.MM.YYYY"));
    //   if (dayjs(date).isValid()) {
    //     if (dayjs().year() == dayjs(date).year()) {
    //       // console.log(777);
    //       return dayjs(date).format("DD MMMM");
    //     } else {
    //       // console.log(888);
    //       return dayjs(date).format("MMMM YYYY");
    //     }
    //   }
    // },
    //     async formSend() {
    //       //   console.log(2222, this.formName, this.formPhone, this.formMsg);
    //       //   console.log(2222, this.formPhone, this.titleFrom);

    //       this.loading = true;

    //       const { sendToTelegramm } = sendTelegramm();
    //       let ww = await sendToTelegramm(
    //         "Где: " +
    //           this.titleFrom +
    //           "<br>" +
    //           "Как зовут: " +
    //           this.formName +
    //           "<br>" +
    //           "Телефон: " +
    //           this.formPhone +
    //           "<br>" +
    //           "Сообщение: " +
    //           this.formMsg
    //       );
    //       //   console.log('ww',ww);
    //       this.result = ww;
    //     },
  },
};
</script>

<style lang="scss"></style>
