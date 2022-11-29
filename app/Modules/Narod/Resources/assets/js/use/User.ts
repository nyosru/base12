import { ref } from "vue";
// import axios from "axios";

// массив для отслеживания выбранных товаров на витрине
const userId = ref(0);

export default function User() {
  return {
    userId
  }
}