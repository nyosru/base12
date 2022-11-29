import { ref } from 'vue'
import md5 from 'md5'

import axios from "axios";

const loading = ref(false);
const sended = ref(false);
const errored = ref(false);

const sendToTelegramm = async (msg) => {

    loading.value = true;

    let res = await axios
        .post('https://api.uralweb.info/telegram.php',
            {
                domain: window.location.hostname,
                // show_datain: 1,
                answer: 'json',

                // s: md5('1'),
                s: md5(window.location.hostname),

                // id: 1,
                id: [
                    360209578, // я
                    // 1368605419, // я тест
                    2037908418 // ваш метролог
                ],
                msg
            })
        .catch((error) => {
            console.log("error", error);
            return 'errored';
        });

    if (res.data.res === true) {
        sended.value = true;
        return 'sended';
    } else {
        errored.value = true;
        return 'errored';
    }

}


export default function sendTelegramm() {

    //   const response = ref()

    // const request = async () => {
    //     const res = await fetch(url, options)
    //     response.value = await res.json()
    // }

    return {
        sendToTelegramm,
        loading,
        // response,
        // request
    }
}
