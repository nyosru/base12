<template>
  <tr
    :style="el.start ? '' : 'background-color: rgba(0,0,0,0.05)'"
    v-if="el.start || listScheta[el['nomer-sceta']]"
    @click="
      el.start
        ? (listScheta[el['nomer-sceta']] = !listScheta[el['nomer-sceta']])
        : ''
    "
  >
    <td>
      <span v-if="el.start">
        {{ el["nomer-sceta"] ?? "" }}
      </span>
      <!-- <br/>
      {{ el.start ? '++' : '--' }} -->
    </td>
    <td>
      <span v-if="el.start" xclick="show1 = !show1">
        {{ el.naimenovanie ?? "" }}

        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="currentColor"
          class="bi bi-arrow-down-square"
          viewBox="0 0 16 16"
          v-if="!listScheta[el['nomer-sceta']]"
        >
          <path
            fill-rule="evenodd"
            d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"
          />
        </svg>

        <svg
          v-else
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="#898989"
          class="bi bi-arrow-down-square-fill"
          viewBox="0 0 16 16"
        >
          <path
            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5a.5.5 0 0 1 1 0z"
          />
        </svg>
      </span>
      <span v-else @click="show1 = !show1">{{ el.firma ?? "" }}</span>

      <pre v-if="show1">{{ el }}</pre>
    </td>

    <td class="tr" :class="{ 'bbold' :  el.start && listScheta[el['nomer-sceta']] }" >{{ el["debet-na-naclo-perioda"] ?? "-" }}</td>
    <td class="tr" :class="{ 'bbold' :  el.start && listScheta[el['nomer-sceta']] }">{{ el["kredit-na-naclo-perioda"] ?? "-" }}</td>
    <td class="tr" :class="{ 'bbold' :  el.start && listScheta[el['nomer-sceta']] }">{{ el["oborot-debet"] ?? "-" }}</td>
    <td class="tr" :class="{ 'bbold' :  el.start && listScheta[el['nomer-sceta']] }">{{ el["oborot-kredit"] ?? "-" }}</td>
    <td class="tr" :class="{ 'bbold' :  el.start && listScheta[el['nomer-sceta']] }">{{ el["debet-na-konec-perioda"] ?? "-" }}</td>
    <td class="tr" :class="{ 'bbold' : el.start &&  listScheta[el['nomer-sceta']] }">{{ el["kredit-na-konec-perioda"] ?? "-" }}</td>
    
  </tr>
</template>

<script>
// import { ref } from 'vue';
// import { onMounted, computed } from "vue";
// import axios from "axios";
import Datar from "./Datar.ts";

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

  setup(props) {
    const {
      // good,
      listScheta,
    } = Datar();

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

    return {
      listScheta,
      //     good,
      //     // showPrice1,
      //     // showPrice2,
      //     // showPrice3,
    };
  },
};
</script>

<style lang="scss" scoped >
.tr {
  text-align: right;
}

.nomer_schet {
  display: inline-block;
  width: 24px;
}
.nomer_schet.start {
  border-right: 2px solid gray;
}
// .nomer_schet {
//   border-right: 2px solid gray;
// }

.item a {
  color: gray;
  text-decoration: none;
}
.item a:hover {
  text-decoration: underline;
}
pre {
  max-height: 300px;
  overflow: auto;
}

.kolvo {
  text-align: center;
  width: 40px;
}

.nobr {
  white-space: pre;
}

.price {
  text-align: right;
}

.btn--plus,
.btn--minus {
  display: inline-block;
  border-radius: 3px;
  border: none;
  padding: 1px 5px 3px 5px;
}

.btn--plus {
  background-color: rgba(0, 255, 0, 0.2);
}
.btn--minus {
  background-color: rgba(255, 0, 0, 0.2);
}

.bbold{
  font-weight: bold;
}
</style>
