import { ref } from "vue"
import { handleAxiosError } from "@/helper/errorHandler"
import { makeHttpReq } from "@/services/makeHttpReq"

interface pinnedProjectType {
    id: number,
    name: string,
}

interface GetPinnedResponseType {
    data: pinnedProjectType
}

export function useGetPinnedProject() {

    const pinnedProject = ref<pinnedProjectType>({} as pinnedProjectType);

    async function getPinnedProject() {

        try {
            const { data } = await makeHttpReq<undefined, GetPinnedResponseType> (`projects/pinned`, 'GET');
            pinnedProject.value = data;
            console.log("🚀 ~ getPinnedProject ~ data:", data)
        } catch (error) {
            console.log("🚀 ~ getPinnedProject ~ error:", (error as Error))
            handleAxiosError(error);
        }

    }

    return { pinnedProject, getPinnedProject }
}
