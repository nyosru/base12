<template>
  <header>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <a href="/"
            ><img
              src="/narod/img/logo.png"
              style="padding-top: 1em; max-height: 120px; margin-left: 10%"
              alt="Народная экономика"
          /></a>
        </div>
      </div>
    </div>
  </header>

  <header-menu></header-menu>

</template>

<script>
// import axios from "axios";

import HeaderMenu from "./HeaderMenu.vue";

export default {
  components: {
    HeaderMenu,
  },
  setup(props) {
    return {};
  },
};
</script>

<style lang="scss">
.sidebar {
  background-color: rgba(0, 0, 0, 0.2);
  min-height: 90vh;
}

header {
  background-image: url("/narod/img/bg_up.png");
  min-height: 150px;
  background-size: cover;
  box-shadow: inset 0 0 10px gray;
  > div {
    background-image: linear-gradient(
      to left,
      rgba(255, 255, 255, 0),
      rgba(255, 255, 255, 0.8)
    );
    height: 150px;
  }
}

header h1 {
  display: inline-block;
  padding-top: 20px;
  padding-left: 60px;
  font-family: "Roboto", arial;
  font-weight: bold;
  color: white;
  x-text-shadow: -1px -1px 0 rgba(0, 0, 0, 0.5), 1px -1px 0 rgba(0, 0, 0, 0.5),
    -1px 1px 0 rgba(0, 0, 0, 0.5), 1px 1px 0 rgba(0, 0, 0, 0.5);
  text-shadow: 0 0 3px rgba(0, 0, 0, 1);
}

.corzina1 {
  position: fixed;
  top: 70px;
  right: 20px;
  padding: 10px;
  border-radius: 5px;
  background-color: rgba(255, 255, 255, 0.9);
  text-align: right;
  font-weight: bold;
}

.bg1 {
  background-color: rgba(0, 0, 0, 0.05);
  padding-top: 0.2em;
  padding-bottom: 0.8em;
}

/*
.list123 > div,
.list123 > div div
{
    xpadding: 5px 20px;
    xborder-left: 1px solid rgba(0,0,0,0.25);
}

.tr1 .sk{ display: inline-block; }
.tr1{ display: table; }
.tr1  div{ display: table-row;
           xborder: 1px solid green;
           xpadding: 5px; xmargin: 5px; }
.tr1  div  div{ display: table-cell;
                border: 1px solid red;
                padding: 5px; margin: 5px;
}
.tr1  div  div:nth-child(1){ min-width: 250px; }
.tr1  div  div:nth-child(2){ xwidth: 150px; }
*/

.tab {
  display: table;
}
.tab div {
  display: table-row;
}
.tab div div {
  display: table-cell;
  border-bottom: 1px solid gray;
  border-right: 1px solid rgba(0, 0, 0, 0.1);
  padding: 2px;
  margin: 2px;
}

.tab div div:nth-child(1) {
  min-width: 250px;
}

/*
x.table2 .tr2 > div:nth-child(1) { min-width:250px; }
x.table2:nth-child(even){ background-color: #e5e5e5; }
*/
.pad a,
.pad > span {
  display: block;
  padding-right: 20px;
}

.pad1 a,
.pad1 > span {
  margin-left: 0px;
  border-left: 2px solid rgba(0, 0, 0, 0.1);
}
.pad2 a,
.pad2 > span {
  margin-left: 20px;
  border-left: 2px solid rgba(0, 0, 0, 0.15);
}
.pad3 a,
.pad3 > span {
  margin-left: 40px;
  border-left: 2px solid rgba(0, 0, 0, 0.2);
}
.pad4 a,
.pad4 > span {
  margin-left: 60px;
  border-left: 2px solid rgba(0, 0, 0, 0.25);
}
.pad5 a,
.pad5 > span {
  margin-left: 80px;
  border-left: 2px solid rgba(0, 0, 0, 0.3);
}
.pad6 a,
.pad6 > span {
  margin-left: 100px;
  border-left: 2px solid rgba(0, 0, 0, 0.35);
}
.pad7 a,
.pad7 > span {
  margin-left: 120px;
  border-left: 2px solid rgba(0, 0, 0, 0.4);
}
.pad8 a,
.pad8 > span {
  margin-left: 140px;
  border-left: 2px solid rgba(0, 0, 0, 0.45);
}
.pad9 a,
.pad9 > span {
  margin-left: 160px;
  border-left: 2px solid rgba(0, 0, 0, 0.5);
}
.pad10 a,
.pad10 > span {
  margin-left: 180px;
  border-left: 2px solid rgba(0, 0, 0, 0.55);
}
.pad11 a,
.pad11 > span {
  margin-left: 200px;
  border-left: 2px solid rgba(0, 0, 0, 0.6);
}
.pad12 a,
.pad12 > span {
  margin-left: 220px;
  border-left: 2px solid rgba(0, 0, 0, 0.65);
}
.pad13 a,
.pad13 > span {
  margin-left: 240px;
  border-left: 2px solid rgba(0, 0, 0, 0.7);
}
.pad14 a,
.pad14 > span {
  padding-left: 260px;
  border-left: 2px solid rgba(0, 0, 0, 0.75);
}
.pad15 a,
.pad15 > span {
  padding-left: 280px;
  border-left: 2px solid rgba(0, 0, 0, 0.8);
}
.pad16 a,
.pad16 > span {
  padding-left: 300px;
  border-left: 2px solid rgba(0, 0, 0, 0.85);
}
.pad17 a,
.pad17 > span {
  padding-left: 320px;
  border-left: 2px solid rgba(0, 0, 0, 0.9);
}
.pad18 a,
.pad18 > span {
  padding-left: 340px;
  border-left: 2px solid rgba(0, 0, 0, 0.95);
}
.pad19 a,
.pad19 > span {
  padding-left: 360px;
  border-left: 2px solid rgba(0, 0, 0, 1);
}
.pad20 a,
.pad20 > span {
  padding-left: 380px;
  border-left: 2px solid rgba(0, 0, 0, 1);
}
/*
.table_ob{
    display: block;
    width:100%;
    overflow-x: auto;
}

*/

.td_r {
  text-align: right;
}

.navbar2 {
  position: -webkit-sticky;
  position: -moz-sticky;
  position: -ms-sticky;
  position: -o-sticky;
  position: sticky;
  top: 0;
  z-index: 200;
}

xx.table {
  overflow: visible;
}
.list_head,
.table thead {
  position: -webkit-sticky;
  position: -moz-sticky;
  position: -ms-sticky;
  position: -o-sticky;
  position: sticky;
  top: 40px;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 200;
}
.table thead th {
  background-color: rgba(255, 255, 255, 0.8);
}
</style>
