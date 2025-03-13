import { successMsg } from "@/helper/toast-notification"
import { makeHttpReq } from "@/services/makeHttpReq"
import { ref } from "vue"
import { handleAxiosError } from "@/helper/errorHandler"
import { projectStore } from "@/store/projectStore"

export interface ProjectInputType {
    id?: number,
    name: string,
    start_date: string,
    end_date: string,
}

interface ProjectResponseType {
    message: string
}

// export const.projectInput = ref<ProjectInputType>()

export function useCreateOrUpdateProject() {

    const loading=ref(false);

    async function createOrUpdate() {

        try {

            loading.value = true;
            const data = projectStore.edit ? await updateProject() : await createProject();
            loading.value = false;
            successMsg(data.message);

        } catch (error) {
            loading.value = false;
            handleAxiosError(error);
        }

    }

    return { loading, createOrUpdate }
}

async function createProject() {
    const data = await makeHttpReq<ProjectInputType, ProjectResponseType> ('projects', 'POST', projectStore.projectInput);
    projectStore.projectInput = {} as ProjectInputType;
    return data;
}

async function updateProject() {
   // projectStore.edit = false;
    return await makeHttpReq<ProjectInputType, ProjectResponseType> ('projects', 'PUT', projectStore.projectInput);
}
