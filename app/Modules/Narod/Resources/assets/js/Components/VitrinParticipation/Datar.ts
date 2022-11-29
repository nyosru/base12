import { ref } from "vue";
import axios from "axios";

// массив для отслеживания выбранных товаров на витрине
const good = ref([]);
const listScheta = ref([]);
const loading = ref(true);
const loadError = ref(false);
const pageData = ref('');

const headUnique = ref([]);

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
      .get("/api47/getParticipation")
      .then((response) => {
        pageData.value = response.data.data;
        loading.value = false;

        headUnique.value = [...new Set(pageData.value.map((item) => item.firma))];
        // console.log(dataUnique);
        
      })
      .catch((error) => {
        console.log(error);
        loadError.value = true;
      });

  }
};

export default function Datar() {
  return {
    headUnique,
    good,
    loading,
    getData,
    pageData,
    loadError,
    listScheta
  }
}