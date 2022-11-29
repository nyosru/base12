<template>
  <div class="row item pt-2 pb-2">
    <div
      class="col-10 col-sm-9 col-md-4 col-lg-5 name"
      @click="show1 = !show1"
    >
      {{ el.naimenovanie ?? "" }}
      {{ el.dobavka ?? "" }}
      <span class="ed_iz">{{ el.edizm ?? "" }}</span>
      <pre v-if="show1">{{ el }}</pre>
    </div>
    <div class="d-none d-md-block col-md-3 col-lg-3 xname">
      <!-- {{ el.mol }}<br /> -->
      <a :href="el.sait" >{{ el.sait }}</a><br />
      <a :href="'mailto:' + el.yashhik " >{{ el.yashhik }}</a><br />
      <!-- {{ el.yashhik }}<br /> -->
    </div>

    <div class="d-none d-md-block col-md-3 col-lg-3 xname">
      {{ el.kodt }}
    </div>
    <div class="col-2 col-sm-3 col-md-2 col-lg-1 text-center">
      {{ el.kolicestvo }}
    </div>

  </div>
</template>

<script>
// import { ref } from 'vue';
import { computed } from "vue";
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
    const { good } = Datar();

    good.value[props.el.id] = 0;

    // const pageData = ref('');

    // // loading.value = false;
    // axios
    // .get(
    //     "/api47/getVitrin"
    //     )
    //     .then((response) => {
    //     pageData.value = response.data.data;
    //     })
    //     .catch((error) => {
    //     console.log(error);
    //     // loadError.value = true;
    //     })
    //     ;

    // let formatter = new Intl.NumberFormat([locales[, options]]);
    // formatter.format(number); // форматирование

    // const ru = new Intl.NumberFormat("ru").format(amount);

    const showPrice1 = computed(() =>
      new Intl.NumberFormat("ru").format(Math.ceil(props.el.cena1))
    );
    const showPrice2 = computed(() =>
      new Intl.NumberFormat("ru").format(Math.ceil(props.el.cena2))
    );
    const showPrice3 = computed(() =>
      new Intl.NumberFormat("ru").format(Math.ceil(props.el.cena3))
    );

    return {
      good,
      showPrice1,
      showPrice2,
      showPrice3,
    };
  },
};
</script>

<style lang="scss" scoped >

.item a{
  color: gray;
  text-decoration: none;
}
.item a:HOVER{
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
</style>
