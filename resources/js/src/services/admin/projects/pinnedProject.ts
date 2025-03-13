import { ref } from "vue"
import { handleAxiosError } from "@/helper/errorHandler"
import { makeHttpReq } from "@/services/makeHttpReq"
import { successMsg } from "@/helper/toast-notification";

type PinnedResponseType = {
    message: string
}

export function usePinnedProject() {

    const loading=ref(false);

    async function pinnedProject(project_id: number) {

        try {

            loading.value = true;
            const data = await makeHttpReq<{project_id:number}, PinnedResponseType> (`projects/pinned`, 'PATCH', {project_id});
            loading.value = false;
            successMsg(data.message);

        } catch (error) {
            loading.value = false;
            handleAxiosError(error);
        }

    }

    return { loading, pinnedProject }
}
