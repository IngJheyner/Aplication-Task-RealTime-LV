import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory("/app"),
    routes: [
        {
            path: "/auth",
            name: "auth",
            component: () => import('@/pages/auth/AuthPage.vue'),

            children: [
                {
                    path: "/login",
                    name: "auth.login",
                    component: () => import('@/pages/auth/LoginPage.vue')
                },
                {
                    path: "/register",
                    name: "auth.register",
                    component: () => import('@/pages/auth/RegisterPage.vue')
                }
            ]
        },
        {
            path: "/admin",
            name: "admin",
            component: () => import('@/pages/admin/AdminPage.vue'),

            children: [
                {
                    path: "/dashboard",
                    name: "admin.dashboard",
                    component: () => import('@/pages/admin/dashboard/DashboardPage.vue')
                },
                {
                    path: "/members",
                    name: "admin.member",
                    component: () => import('@/pages/admin/member/MemberPage.vue'),
                },
                {
                    path: "/member/create",
                    name: "admin.member.create",
                    component: () => import('@/pages/admin/member/CreateMemberPage.vue')
                },
                {
                    path: "/projects",
                    name: "admin.project",
                    component: () => import('@/pages/admin/projects/ProjectsPage.vue')
                },
                {
                    path: "/project/create",
                    name: "admin.project.create",
                    component: () => import('@/pages/admin/projects/CreateProject.vue')
                },
            ]
        }
    ],
});

export default router
