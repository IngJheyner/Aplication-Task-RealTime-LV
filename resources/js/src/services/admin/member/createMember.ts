import { successMsg } from "@/helper/toast-notification"
import { makeHttpReq } from "@/services/makeHttpReq"
import { ref } from "vue"
import { handleAxiosError } from "@/helper/errorHandler"
import { memberStore } from "@/store/memberStore"

export interface MemberInputType {
    name: string,
    email: string,
}

interface MemberResponseType {
    message: string
}

// export const memberInput = ref<MemberInputType>()

export function useCreateOrUpdateMember() {

    const loading=ref(false);

    async function createOrUpdate() {

        try {

            loading.value = true;
            const data = memberStore.edit ? await updateMember() : await createMember();
            loading.value = false;
            //memberInput.value = {} as MemberInputType;
            //console.log(data);
            successMsg(data.message);

        } catch (error) {
            loading.value = false;
            handleAxiosError(error);
        }

    }

    return { loading, createOrUpdate }
}

async function createMember() {
    const data = await makeHttpReq<MemberInputType, MemberResponseType> ('members', 'POST', memberStore.memberInput);
    memberStore.memberInput = {} as MemberInputType;
    return data;
}

async function updateMember() {
   // memberStore.edit = false;
    return await makeHttpReq<MemberInputType, MemberResponseType> ('members', 'PUT', memberStore.memberInput);
}
