import { MemberInputType } from "@/services/admin/member/createMember";
import { defineStore } from "pinia";

const useMemberStore = defineStore('member', {
    state: () => ({
        memberInput: {} as MemberInputType,
        edit: false
    })
})

export const memberStore = useMemberStore();
