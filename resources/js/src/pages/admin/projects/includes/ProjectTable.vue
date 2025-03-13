
<script setup lang="ts">
import { myDebounce } from '@/helper/utils';
import { GetProjectType, ProjectType } from '@/services/admin/projects/getProjects';
import { ref } from 'vue';

defineProps<{
    projects:GetProjectType;
    loading:boolean
}>();

const emit=defineEmits<{
    (e:'pinnedProject',projectId:number):void
    (e:'editProject',project:ProjectType):void
    (e:'viewProjectDetail',projectId:number):void
    (e:'getProject',page:number,query:string):Promise<void>

}>()

const query = ref("");
const search = myDebounce(async function () {
    await emit("getProject",1,query.value,);
}, 2000);
</script>

<template>
   <div class="row">
        <div class="row">
            <div class="col-md-4">
                <Input
                    @keydown="search"
                    v-model="query"
                    placeholder="Buscar proyecto por titulo..."

                />
                <span
                    style="color: blue"
                    v-show="loading === true ? true : false"
                    ><b>Buscando...</b></span
                >
            </div>
        </div>
        <br />
        <br />
        <table class="table table-bordered table-striped">
            <thead>
                <tr style="font-weight: bold;">
                    <td width="5%">ID</td>
                    <td width="30%">Titulo</td>

                    <td  width="20%">Completado</td>
                    <td width="5%">Editar</td>
                    <td  width="10%">Pinned</td>
                    <td  width="15%">Ver</td>
                </tr>
            </thead>

            <tbody>
                <tr v-for="project in projects?.data?.data" :key="project.id">
                    <td>{{ project.id }}</td>
                    <td>{{ project.name }}</td>
                    <td>
                        <div
                        class="progress"
                    >
                        <div class="progress-bar"
                        role="progressbar"
                        aria-label="Example with label"
                        :aria-valuenow="project?.task_progress?.progress"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        :class="
                            [
                                project?.task_progress?.progress == 100 ? 'bg-success' : 'bg-warning',
                                'h-100'
                            ]"
                            :style="{width: project?.task_progress?.progress+'%'}">
                            {{project?.task_progress?.progress}} %
                        </div>
                    </div>

                    </td>
                    <td>
                        <button @click="emit('editProject',project)" type="button" class="btn btn-outline-primary">Editar</button>
                    </td>

                    <td>
                        <button @click="emit('pinnedProject',project.id)" type="button" class="btn btn-light">Pinned <i class="bi bi-activity"></i></button>
                    </td>

                    <td>
                        <RouterLink
                            class="btn btn-warning"
                            :to="'/kaban?query=' + project.slug"
                        >View <i class="bi bi-arrow-right"></i></RouterLink>
                    </td>
                </tr>
            </tbody>
        </table>
        <slot name="pagination"></slot>
   </div>
</template>
