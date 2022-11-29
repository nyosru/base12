<template>
  <tr>
    <!-- <td>{{ el.firma }}</td> -->
    <!-- <td>{{ el.dokument }}</td> -->
    <td>
      <!-- <span @click="show1 = !show1" > -->
        {{ el.dobro.length > 0 ? el.dobro : '<>' }}
      <!-- </span> -->
      <!-- <pre v-if="show1">{{ el }}</pre> -->

    </td>
    <td class="trr" >{{ el.debet.length ? el.debet : '-'  }}</td>
    <td class="trr" >{{ el.kredit.length ? el.kredit : '-' }}</td>
  </tr>
</template>

<script>

// // import { ref } from 'vue';
// import { onMounted, computed } from "vue";
// // import axios from "axios";
// import Datar from "./Datar.ts";

export default {
  props: {
    el: { type: Object },
    // good: { type: Object },
  },

  data() {
    return {
      show1: false,
    };
  },

  // setup(props) {
  //   const { good, listScheta } = Datar();

  //   onMounted(() => {
  //     if (!listScheta.value[props.el["nomer-sceta"]]) {
  //       listScheta.value[props.el["nomer-sceta"]] = 1;
  //     } else {
  //       listScheta.value[props.el["nomer-sceta"]] =
  //         listScheta.value[props.el["nomer-sceta"]] + 1;
  //     }
  //   });

  //   good.value[props.el.id] = 0;

  //   // const pageData = ref('');

  //   // // loading.value = false;
  //   // axios
  //   // .get(
  //   //     "/api47/getVitrin"
  //   //     )
  //   //     .then((response) => {
  //   //     pageData.value = response.data.data;
  //   //     })
  //   //     .catch((error) => {
  //   //     console.log(error);
  //   //     // loadError.value = true;
  //   //     })
  //   //     ;

  //   // let formatter = new Intl.NumberFormat([locales[, options]]);
  //   // formatter.format(number); // форматирование

  //   // const ru = new Intl.NumberFormat("ru").format(amount);

  //   // const showPrice1 = computed(() =>
  //   //   new Intl.NumberFormat("ru").format(Math.ceil(props.el.cena1))
  //   // );
  //   // const showPrice2 = computed(() =>
  //   //   new Intl.NumberFormat("ru").format(Math.ceil(props.el.cena2))
  //   // );
  //   // const showPrice3 = computed(() =>
  //   //   new Intl.NumberFormat("ru").format(Math.ceil(props.el.cena3))
  //   // );

  //   return {
  //     listScheta,
  //     good,
  //     // showPrice1,
  //     // showPrice2,
  //     // showPrice3,
  //   };
  // },
};
</script>

<style lang="scss" scoped >
.trr{ text-align: right; }
</style>
