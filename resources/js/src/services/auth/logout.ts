import { successMsg } from "@/helper/toast-notification"
import { makeHttpReq } from "@/services/makeHttpReq"
import { ref } from "vue"
import { handleAxiosError } from "@/helper/errorHandler"

export function userLogout() {

    const loading=ref(false);
    async function logout(userId:number|undefined) {

        try {

            loading.value = true;
            await makeHttpReq<{userId:number|undefined}, {message:string}> ('logout', 'POST', {userId});
            loading.value = false;

        } catch (error) {
            loading.value = false;
            handleAxiosError(error);
            //console.log("🚀 ~ logout ~ error:", (error as Error).status)
            if ((error as Error).status === 401) {
                window.location.href = '/app/login';
            }
        }


    }

    return { loading, logout }
}
