import { ref } from "vue";
import axios from "axios";

const loading = ref(true);
// const loadError = ref(false);
// const pageData = ref('');

/**
 * получить данные по странице
 * @param pageName название страницы
 */
// const getData = async (pageName = null) => {

//   pageData.value = '';

//   if (pageName === null) {
//     return false;
//   }

//   loading.value = true;
//   loadError.value = false;

//   // console.log("commis ts", "getData (idata irefund)");
//   if (loading.value === true) {

//     // loading.value = false;
//     await axios
//       .get(
//         "/api47/pageText/" + pageName
//       )
//       .then((response) => {

//         // console.log('getData - response.data',response.data);
//         pageData.value = response.data.data;
//         // idata.value = response.data.idata.BOOM ?? {};
//         // irefund.value = response.data.idata.REFUND ?? {};
//         // deductions.value = response.data.idata.deductions ?? {};
//         // bonuses.value = response.data.idata.bonuses ?? {};

//         // if (type == 'comisFee') {
//         //   const { filtrComisToTimeType } = ComisFee();
//         //   filtrComisToTimeType(type2, type3);
//         // }

//         loading.value = false;
//       })
//       .catch((error) => {
//         console.log(error);
//         loadError.value = true;
//       });

//   }
// };

const sendForm = async ( datar = [] ) => {

  console.log( 'datar' , datar );

  // pageData.value = '';

  // if (pageName === null) {
  //   return false;
  // }

  // loading.value = true;
  // loadError.value = false;

  // // console.log("commis ts", "getData (idata irefund)");
  // if (loading.value === true) {

  //   // loading.value = false;
  //   await axios
  //     .get(
  //       "/api47/pageText/" + pageName
  //     )
  //     .then((response) => {

  //       // console.log('getData - response.data',response.data);
  //       pageData.value = response.data.data;
  //       // idata.value = response.data.idata.BOOM ?? {};
  //       // irefund.value = response.data.idata.REFUND ?? {};
  //       // deductions.value = response.data.idata.deductions ?? {};
  //       // bonuses.value = response.data.idata.bonuses ?? {};

  //       // if (type == 'comisFee') {
  //       //   const { filtrComisToTimeType } = ComisFee();
  //       //   filtrComisToTimeType(type2, type3);
  //       // }

  //       loading.value = false;
  //     })
  //     .catch((error) => {
  //       console.log(error);
  //       loadError.value = true;
  //     });

  // }
};

export default function FormReg() {
  return {
    sendForm
    // loading,
    // getData,
    // pageData,
    // loadError
  }
}