<template>
  <div class="pb-5">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Module: page</h3>

        <div class="card-tools">
          <span style="display: inline-block; float: right">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>

            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button> -->
          </span>

          <!-- <span style="display: inline-block; float: right">
          <link-pages />
        </span> -->
        </div>
      </div>

      <div class="card-body" style="display: block">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <!-- <mod-page-file-editor
                v-if="!loading && dataText && dataText.length"
                :editorData="dataText"
              /> -->

              <!-- <ckeditor
                aaxstyle="width: 100%; min-height: 350px"
                aaxname="editor1"
                v-model="editorData"
                aaxxmodel-value="editorData"
                :editor="editor"
                :config="editorConfig"
                aaxx@destroy="onEditorDestroy"
                @input="updateField"
              ></ckeditor> -->
              <ckeditor
                v-model="editorData"
                :editor="editor"
                :config="editorConfig"
                @input="updateField"
              ></ckeditor>

              <!-- <tiptap /> -->
            </div>
          </div>
        </div>
      </div>

      <div
        class="card-footer"
        style="
          display: block;
          background-color: rgba(0, 0, 0, 0.7);
          position: sticky;
          bottom: 0;
        "
      >
        <span style="float: right">
          <!-- <link-pages /> -->

          <span v-if="saveDataError" class="alert alert-danger p-1 mr-2"
            >Упс .. ошибочка сохранения</span
          >
          <span v-else-if="saveDataOk" class="alert alert-success p-1 mr-2"
            >Сохранено</span
          >
          <span v-else-if="saveData" class="alert alert-warning p-1 mr-2">сохраняем</span>
          <span v-else-if="editedData" class="alert alert-light p-1 mr-2">
            Есть не сохранённые изменения
          </span>

          <button class="btn btn-success" @click="saveText">Save</button>
        </span>
      </div>

      <div class="overlay" v-if="loading">
        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
      </div>
    </div>
  </div>
</template>

<script>
// import itemsFilters from "./ModItemsFilters.vue";
// import linkPages from "../comand/PagesComponent.vue";
// import itemsItem from "./ModItemsItem.vue";
// import itemsFormAdd from "./ModItemsForm2.vue";
// import filterSettings from "./../../modules/filterSettings.ts";

import datasFile from "./../../../modules/didrive_items/datasFile.ts";

// import ModPageFileEditor from "./ModPageFileEditor.vue";

import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

// import SummernoteEditor
// import SummernoteEditor from 'vue3-summernote-editor';

import Tiptap from "./editorTiptap.vue";

import {
  // ref,
  watchEffect,
  onUnmounted,
} from "vue";

import { useRoute } from "vue-router";
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

// import CKEditor from "@ckeditor/ckeditor5-vue";
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  components: {
    ckeditor: CKEditor.component,
    // ModPageFileEditor,
    // Tiptap,
    //     ckeditor: CKEditor.component,
    //     // itemsItem,
    //     // itemsFormAdd,
    //     // linkPages,
    //     // itemsFilters,
    //     // SummernoteEditor,
    //     // CKEditor,
  },

  data() {
    //     // const { dataText } = datasFile();

    return {
      editor: ClassicEditor,
      editorConfig: {},
      now_module: "",
      saveData: false,
      saveDataOk: false,
      saveDataError: false,
      editedData: false,
      //       //   //             myValue: '55555555555',
      //       //   text_data: '2222'

      //       editor: ClassicEditor,
      //         // editorData: "<p>Content loading</p>",
      //       editorData: dataText.value,
      //       editorConfig: {
      //         // The configuration of the editor.
      //       },
    };
  },

  setup(props) {
    console.log("mod dataFile setup");

    const route = useRoute();
    // const { loadData } = datas();
    // const text_data = ref(".. loading ..");
    const { loading, dataText, loadData } = datasFile();

    watchEffect(() => {
      if (loading.value == true) {
        // console.log("route.params.module", route.params.module);
        loadData(route.params.module);
      }
    });

    // editor.model.document.on("change:data", () => {
    //   console.log("The data has changed!");
    // });

    // onUnmounted(() => {
    //   // const { dataText , loading } = datasFile();
    //   dataText.value = "";
    //   loading.value = true;
    // });

    // let editorData = '';

    // watchEffect(() => {
    //   editorData = dataText.value;
    // //   CKEditor.setData(dataText.value);
    // });

    // const { loading, cfg, data_filtered } = datas();
    // const { showStatusDelete } = filterSettings();

    // // const editor = ClassicEditor;
    // // const editorData = "<p>Rich-text editor content.</p>";
    // // const editorConfig = {
    // //   // The configuration of the rich-text editor.
    // // };

    let nowData = "";

    return {
      nowData,
      editorData: dataText,
      now_module: route.params.module,
      //   text_data,
      //   editorData,
      dataText,
      loading,
      //   items_cfg: cfg,
      //   data_filtered,
      // items_loading: loading,
      //   showStatusDelete,
      //   now_module: route.params.module,

      //   editor: ClassicEditor,
      //   editorData: "<p>Rich-text editor content.</p>",
      //   editorConfig: {},
    };
  },

  methods: {
    updateField() {
      console.log(7777, this.editorData.length);
      this.nowData = this.editorData;

      this.editedData = true;
      this.saveData = false;
      this.saveDataOk = false;
      this.saveDataError = false;

      //   this.$emit("input", String(this.editorData));
      //   this.$emit("input", this.editorData);
    },

    saveText() {
      console.log("savePage");
      //   console.log("data", this.editorData);

      //   const route = useRoute();

      this.saveData = true;
      this.saveDataOk = false;
      this.saveDataError = false;

      axios
        .post("/api/page/save/" + this.now_module, {
          data_new: this.nowData,
          //   item_id: item_id,
          //   status: new_status,
        })
        .then((response) => {
          //   console.log(response.data);
          if (response.data.res == true) {
            this.saveData = false;
            this.saveDataOk = true;
          } else {
            this.saveDataError = true;
          }
          //   this.item.status = new_status;
          //   this.loading = false;
        })
        .catch((error) => {
          //   console.log("error", error);
          this.saveDataError = true;
          //   alert("error:" + error.message);
        });
    },
    //     //    summernoteChange(newValue) {
    //     //       console.log("summernoteChange", newValue);
    //     //    },
    //     //     summernoteImageLinkInsert(...args) {
    //     //       console.log("summernoteImageLinkInsert()", args);
    //     //    },
  },
};
</script>
