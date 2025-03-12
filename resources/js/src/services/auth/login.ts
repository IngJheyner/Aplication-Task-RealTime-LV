import { successMsg } from "@/helper/toast-notification"
import { makeHttpReq } from "@/services/makeHttpReq"
import { ref } from "vue"
import { handleAxiosError } from "@/helper/errorHandler"

interface LoginUserType {
    email: string,
    password: string
}

export interface LoginResponseType {
    user: { id:number, email: string },
    message: string,
    isLoggedIn: boolean,
    token: string,
}

export const loginInput = ref<LoginUserType>({} as LoginUserType)

export function userLoginUser() {

    const loading=ref(false);
    async function login() {

        try {

            loading.value = true;
            const data = await makeHttpReq<LoginUserType, LoginResponseType> ('login', 'POST', loginInput.value);
            loading.value = false;
            loginInput.value = {} as LoginUserType;
            successMsg(data.message);
            if(data.isLoggedIn){
                localStorage.setItem('user', JSON.stringify(data));
                window.location.href = '/app/admin';
            }

        } catch (error) {
            loading.value = false;
            handleAxiosError(error);
        }

    }

    return { loading, login }
}
