import { successMsg } from "@/helper/toast-notification"
import { makeHttpReq } from "@/services/makeHttpReq"
import { ref } from "vue"
import { handleAxiosError } from "@/helper/errorHandler"

interface RegisterUserType {
    email: string,
    password: string
}

interface RegisterResponseType {
    user: { email: string },
    message: string
}

export const registerInput = ref<RegisterUserType>({} as RegisterUserType)

export function useRegisterUser() {

    const loading=ref(false);
    async function register() {

        try {

            loading.value = true;
            const data = await makeHttpReq<RegisterUserType, RegisterResponseType> ('register', 'POST', registerInput.value);
            loading.value = false;
            registerInput.value = {} as RegisterUserType;
            //console.log(data);
            successMsg(data.message);

        } catch (error) {
            loading.value = false;
            handleAxiosError(error);
        }

    }

    return { loading, register }
}
