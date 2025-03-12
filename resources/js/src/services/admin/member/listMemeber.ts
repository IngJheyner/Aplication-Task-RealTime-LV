import { ref } from "vue"
import { handleAxiosError } from "@/helper/errorHandler"
import { makeHttpReq } from "@/services/makeHttpReq"

export interface MemberType {
    id: number
    name: string
    email: string
}

export type GetMemberType = {
    data: {data:Array<MemberType>}
} & Record<string, any>

export function useGetMembers() {

    const loading=ref(false);
    const members=ref<GetMemberType>({} as GetMemberType);

    async function getMembers(page:number=1, query:string='') {

        try {

            loading.value = true;
            const data = await makeHttpReq<undefined, GetMemberType> (`members?query=${query}&page=${page}`, 'GET');
            loading.value = false;
            members.value = data;
            console.log(members.value);

        } catch (error) {
            loading.value = false;
            handleAxiosError(error);
        }

    }

    return { loading, getMembers, members }
}
