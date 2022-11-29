<template>
  <div class="row item pt-1 pb-1">
    <div
      class="
        xcol-xs-12 xcol-sm-4 xcol-md-3 xcol-lg-3
        name_item
        col-8 col-sm-6 col-md-4 col-lg-3
        name
      "
      xclick="show1 = !show1"
    >
      {{ el.naimenovanie ?? "" }}
      {{ el.dobavka ?? "" }}

      <span class="ed_iz">{{ el.edizm ?? "" }}</span>

      <!-- <br/> -->
      <!-- <a href="http://vk.com/id85935868" target="_blank">
		vk.com/id85935868
		</a> -->

      <template v-if="el.saitsdelal.length > 0">
        <br />
        <a target="_blank" :href="el.saitsdelal">{{ el.saitsdelal }}</a>
      </template>

      <!-- <pre v-if="show1">{{ el }}</pre> -->
    </div>

    <!-- артикул -->
    <div class="d-none d-lg-block col-lg-2">
      {{ el.kodt }}
    </div>

    <!-- срок годности -->
    <div class="d-none d-lg-block col-lg-1 text-right">
    &nbsp;</div>

    <!-- на складе -->
    <div class="d-none d-lg-block col-lg-1 text-right">
      {{ el.kolicestvo }}
    </div>

    <div class="d-none d-sm-none d-md-block col-md-2 col-lg-1 price">
      {{ showPrice1 }}
    </div>
    <div class="d-none d-sm-none d-md-block col-md-2 col-lg-1 price">
      {{ showPrice2 }}
    </div>
    <div class="d-block col-4 col-sm-3 col-md-2 col-lg-1 price">
      {{ showPrice3 }}
    </div>

    <div class="col-12 text-center col-sm-3 text-sm-start col-md-2 col-lg-2 but_bay nobr">
      <button
        v-if="good[el.id] > 0"
        @click="good[el.id] = good[el.id] > 1 ? good[el.id] - 1 : 0"
        xrel="0"
        xrev="1725"
        xclass="btn btn-sm btn-warning"
        class="btn--minus"
        xalt="10000"
        xvalue="-"
        type="button"
      >
        -
      </button>
      <div v-else style="display: inline-block; width: 25px">&nbsp;</div>
      <!-- el.id {{ el.id }} -->
      <input v-model="good[el.id]" class="kolvo" type="text" />
      <button
        @click="good[el.id] = good[el.id] + 1"
        xrel="0"
        xrev="1725"
        xalt="10000"
        xclass="btn btn-sm btn-success"
        class="btn--plus"
        xvalue="+"
        type="button"
      >
        +
      </button>
    </div>
  </div>
</template>

<script>
// import { ref } from 'vue';
import { computed } from "vue";
// import axios from "axios";
import Vitrin from "./Vitrin.ts";

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
    const { good } = Vitrin();

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

<style lang="scss" >
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
