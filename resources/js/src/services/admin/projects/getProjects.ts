import { ref } from "vue"
import { handleAxiosError } from "@/helper/errorHandler"
import { makeHttpReq } from "@/services/makeHttpReq"

export type ProjectType = {
    id: number;
    name: string;
    start_date: string;
    end_date: string;
    slug: string;
    task_progress: {
        id: number;
        project_id: number;
        progress: string;
        created_at: string;
        updated_at: string;
    }
}

export type GetProjectType = {
    data: {data:Array<ProjectType>}
} & Record<string, any>

export function useGetProjects() {

    const loading=ref(false);
    const projects=ref<GetProjectType>({} as GetProjectType);

    async function getProjects(page:number=1, query:string='') {

        try {

            loading.value = true;
            const data = await makeHttpReq<undefined, GetProjectType> (`projects?query=${query}&page=${page}`, 'GET');
            loading.value = false;
            projects.value = data;
            console.log(projects.value);

        } catch (error) {
            loading.value = false;
            handleAxiosError(error);
        }

    }

    return { loading, getProjects, projects }
}
