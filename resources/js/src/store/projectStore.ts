import { ProjectInputType } from "@/services/admin/projects/createProject";
import { defineStore } from "pinia";

const useProjectStore = defineStore('member', {
    state: () => ({
        projectInput: {} as ProjectInputType,
        edit: false
    })
})

export const projectStore = useProjectStore();
