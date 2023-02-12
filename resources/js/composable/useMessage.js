import {watch, ref} from "vue";

export function useMessage(key, val = null){
    let storedVal = localStorage.getItem(key)
    let data = ref(storedVal)

    let write_message = (data = null) =>{
        localStorage.setItem("simple_data", data);
    }

    return write_message();

}
