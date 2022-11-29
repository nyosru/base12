import { ref } from 'vue'
import md5 from 'md5'

import axios from "axios";

const data = ref({});
const loading = ref(true);
const errored = ref('');

// const sended = ref(false);

const getI = async () => {

    let res = await axios
        // await axios
        .get('/api/tests'
            // ,
            //     {
            //         domain: window.location.hostname,
            //         // show_datain: 1,
            //         answer: 'json',

            //         // s: md5('1'),
            //         s: md5(window.location.hostname),

            //         // id: 1,
            //         id: [
            //             360209578, // я
            //             // 1368605419, // я тест
            //             2037908418 // ваш метролог
            //         ],
            //         msg
            //     }
        )
        .catch((error) => {
            console.log("error", error);
            return 'errored';
        });

    data.value = await res.data.result;

    if (data.value.length > 0) {
        loading.value = false;
    }

    // console.log('fff',res);

    //     if (res.data.res === true) {
    //         loading.value = true;
    //         data.value = true;
    //         return 'sended';
    //     } else {
    //         errored.value = true;
    //         return 'errored';
    //     }

}


const deleteI = async (id) => {

    let res = await axios.delete('/api/tests/'+id )
        .then(
            response => {
                console.log(response.data.message)
                getI()
            }
        )
        .catch(error => console.log(error))

    console.log('news','deleteItem',res);


}


const addI = async (head, date, text, code = '', link1 = '', link2 = '', link3 = '' ) => {


    const config = { 'content-type': 'multipart/form-data' }
    const formData = new FormData()
    formData.append('head', head)
    formData.append('date', date)
    formData.append('text', text)
    formData.append('code', code)
    // if (file != '') {
    //     formData.append('attachment', file)
    // }
    if (link1 != '') { formData.append('link1', link1) }
    if (link2 != '') { formData.append('link2', link2) }
    if (link3 != '') { formData.append('link3', link3) }

    let res = await axios.post('/api/tests', formData, config)
        .then(response => console.log(response.data.message))
        .catch(error => console.log(error))

    console.log('res', res);


    // let res = await axios
    //     // await axios
    //     .post('/api/news'
    //         ,
    //         {
    //             head,
    //             date,
    //             text
    //             //         domain: window.location.hostname,
    //             //         // show_datain: 1,
    //             //         answer: 'json',

    //             //         // s: md5('1'),
    //             //         s: md5(window.location.hostname),

    //             //         // id: 1,
    //             //         id: [
    //             //             360209578, // я
    //             //             // 1368605419, // я тест
    //             //             2037908418 // ваш метролог
    //             //         ],
    //             //         msg
    //         }
    //     )
    //     .catch((error) => {
    //         console.log("error", error);
    //         return 'errored';
    //     });

    // news_data.value = await res.data.result;

    // console.log('fff',res);

    //     if (res.data.res === true) {
    //         loading.value = true;
    //         data.value = true;
    //         return 'sended';
    //     } else {
    //         errored.value = true;
    //         return 'errored';
    //     }

}


export default function tests() {

    //   const response = ref()

    // const request = async () => {
    //     const res = await fetch(url, options)
    //     response.value = await res.json()
    // }

    return {
        addI,
        getI,
        deleteI,
        data,
        errored,
        // news,
        // sendToTelegramm,
        loading,
        // response,
        // request
    }
}
