<script lang="ts" setup>
import { onMounted, ref } from "vue";
import ApexDonut from "./include/ApexDonut.vue";
import ApexRadialBar from "./include/ApexRadialBar.vue";
import { useGetPinnedProject } from "@/services/admin/dashboard/getPinnedProject";
// import { useGetTotalProject } from "./actions/countProject";
// import { useGetChartData } from "./actions/getChartData";

const { pinnedProject, getPinnedProject } = useGetPinnedProject();
// const { countProject, getTotalProject } = useGetTotalProject();

//const { chartData, getChartData } = useGetChartData();
onMounted(async () => {
    await getPinnedProject();
    // getChartData(project.value.id);
    // getTotalProject();
});
</script>
<template>

    <h2 class="mb-4">Panel de control</h2>
    <div class="row">
        <div class="col-md-8">
        <!-- {{ pinnedProject?.id }} -->
            <div class="card border-primary">
                <div class="card-header"><h3 style="color: rgb(118, 119, 120)">Proyecto: {{ pinnedProject?.name }}</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white"><b>Tareas</b></div>
                                <div class="card-body">
                                    <!-- {{ chartData.tasks }}
                                    <div v-if="chartData.tasks">
                                        <ApexDonut :task="chartData.tasks" />
                                    </div>
                                    <div v-else>
                                        <ApexDonut :task="[0, 0]" />
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <b>Progreso</b>
                                </div>

                                <div class="card-body">
                                    <!-- <div v-if="chartData.progress > 0">
                                        <ApexRadialBar :percent="chartData.progress" />
                                    </div>
                                    <div v-else>
                                        <ApexRadialBar :percent="chartData.progress" />
                                    </div>
                                    <br /> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card border-secondary">
                <div class="card-header">
                    <b>Total de proyectos</b>
                </div>
                <div class="card-body">
                    <h2 align="center">{{ countProject?.count }}</h2>
                    <br />
                    <br />
                </div>
            </div>
        </div>
    </div>
</template>
