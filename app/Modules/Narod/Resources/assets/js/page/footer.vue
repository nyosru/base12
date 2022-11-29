<template>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
          Все права защищены ©
          <!-- {{ date("Y") }} -->
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
          Создание сайта: <a href="https://php-cat.com" target="_blank">php-cat.com</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
// import axios from "axios";

export default {
  setup(props) {
    // let token = document.head.querySelector('meta[name="csrf-token"]');

    // // axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
    // axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*";

    // if (token) {
    //   axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
    // } else {
    //   console.error(
    //     "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    //   );
    // }
    return {};
  },
};
</script>

<style lang="scss">
footer {
  background-color: rgba(0, 0, 0, 0.1);

  .row {
    padding: 20px;
  }
}
</style>
