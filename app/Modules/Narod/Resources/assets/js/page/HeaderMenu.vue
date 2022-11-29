<template>
  <nav class="navbar2">
    <span v-for="m in menu" :key="m">
      <router-link
        v-if="m.onAuth != true || (m.onAuth == true && userId > 0)"
        :to="{ path: m.level, meta: { type: m.type ?? '' } }"
        :class="{ active: $route.name == m.level }"
      >
        {{ m.name }}
      </router-link>
    </span>
  </nav>
</template>

<script>
// import axios from "axios";
import User from "./../use/User.ts";

export default {
  setup(props) {
    const { userId } = User();

    const menu = [
      {
        name: "О нас",
        level: "about",
        type: "PageText",
      },
      {
        name: "Добро",
        level: "index",
        type: "Vitrin",
      },
      {
        name: "Хочу стать участником",
        level: "formReg",
        // type: "RegUser",
        type: "formReg",
      },
      {
        name: "Документы",
        level: "documents",
        type: "PageText",
      },
      {
        name: "Требы",
        level: "trebs",
        type: "PageText",
      },
      {
        name: "Наша экономика",
        level: "balance",
        type: "PageText",
      },
      {
        name: "Контакты",
        level: "contacts",
        type: "PageText",
      },
      {
        name: "Ваше участие",
        level: "participation",
        type: "PageText",
        onAuth: true,
      },
    ];

    return {
      menu,
      userId,
    };
  },
};
</script>

<style lang="scss">
.navbar2 {
  top: 0;
  position: sticky;
  background-color: rgb(200, 200, 200);
  text-align: center;

  a {
    color: black;
    padding: 10px 20px 10px 20px;
    display: inline-block;
    text-decoration: none;
  }
  a:hover {
    text-decoration: underline;
  }
  a.active {
    background-color: rgba(0, 0, 0, 0.2);
  }
}
</style>
