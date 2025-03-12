<script lang="ts" setup>
import { MemberType, useGetMembers } from '@/services/admin/member/listMemeber';
import MemberTable from './include/MemberTable.vue';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { memberStore } from '@/store/memberStore';
import { MemberInputType } from '@/services/admin/member/createMember';

const { loading, getMembers, members } = useGetMembers();

async function fetchMembers() {
    await getMembers();
}

const router = useRouter();

function editMember(member: MemberType) {
    memberStore.memberInput = member;
    memberStore.edit=true;
    router.push(`/member/create`);
}

onMounted(async () => {
    await fetchMembers();
    memberStore.edit=false;
    memberStore.memberInput = {} as MemberInputType;
});
</script>

<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Miembros</h3>
                    <router-link to="/member/create" class="btn btn-primary float-end">Agregar</router-link>
                </div>
                <div class="card-body">
                    <MemberTable
                    @edit="editMember"
                    :loading="loading"
                    @search="getMembers"
                    :members="members" />
                </div>
            </div>
        </div>
    </div>
</template>
