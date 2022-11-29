import { ref } from "vue";
import axios from "axios";

// массив для отслеживания выбранных товаров на витрине
const good = ref([]);
const loading = ref(true);
const loadError = ref(false);
const pageData = ref('');

/**
 * получить данные по странице
 */
const getData = async () => {

  pageData.value = '';

  loading.value = true;
  loadError.value = false;

  // console.log("commis ts", "getData (idata irefund)");
  if (loading.value === true) {

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


    // loading.value = false;
    await axios
      .get( "/api47/getVitrin" )
      .then((response) => {

        // console.log('getData - response.data',response.data);
        pageData.value = response.data.data;
        // idata.value = response.data.idata.BOOM ?? {};
        // irefund.value = response.data.idata.REFUND ?? {};
        // deductions.value = response.data.idata.deductions ?? {};
        // bonuses.value = response.data.idata.bonuses ?? {};

        // if (type == 'comisFee') {
        //   const { filtrComisToTimeType } = ComisFee();
        //   filtrComisToTimeType(type2, type3);
        // }

        loading.value = false;
      })
      .catch((error) => {
        console.log(error);
        loadError.value = true;
      });

  }
};

export default function Vitrin() {
  return {
    good,
    loading,
    getData,
    pageData,
    loadError
  }
}