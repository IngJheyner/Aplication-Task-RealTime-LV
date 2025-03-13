<script lang="ts" setup>
import { ProjectType, useGetProjects } from '@/services/admin/projects/getProjects';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { projectStore } from '@/store/projectStore';
import { MemberInputType } from '@/services/admin/member/createMember';
import ProjectTable from './includes/ProjectTable.vue';
import { ProjectInputType } from '@/services/admin/projects/createProject';
import { usePinnedProject } from '@/services/admin/projects/pinnedProject';


const { loading, getProjects, projects } = useGetProjects();

async function fetchProjects() {
    await getProjects();
}

const router = useRouter();

function editProject(project: ProjectType) {
    projectStore.projectInput = project;
    projectStore.edit=true;
    router.push(`/project/create`);
}

const { pinnedProject } = usePinnedProject();
async function pinnedProjectOnDashboard(projectId:number){
    await pinnedProject(projectId)
    router.push('/dashboard')
}

onMounted(async () => {
    await fetchProjects();
    projectStore.edit=false;
    projectStore.projectInput = {} as ProjectInputType;
});
</script>

<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Proyectos</h3>
                    <router-link to="/project/create" class="btn btn-primary float-end">Agregar</router-link>
                </div>
                <div class="card-body">
                    <ProjectTable
                    :projects="projects"
                    @getProject="getProjects"
                    @editProject="editProject"
                    @pinnedProject="pinnedProjectOnDashboard"
                    :loading="loading"
                    >
                    <template #pagination>
                        <Bootstrap5Pagination
                        v-if="projects?.data"
                        :data="projects?.data"
                        @pagination-change-page="getProjects"
                        />

                    </template>
                    </ProjectTable>
                </div>
            </div>
        </div>
    </div>
</template>
