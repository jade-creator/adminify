
import { useLocalStorage } from '@vueuse/core';
import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        admin: useLocalStorage('admin', null),
        token: useLocalStorage('token', null),
    }),
    getters: {
        getAdmin: (state) => state.admin,
        getToken: (state) => state.token,
    },
    actions: {
        isAuthenticated() {
            return this.admin !== null;
        },
        async login({ identifier, password, remember }) {
            try {
                const {
                    data: { admin, token }
                } = await axios.post('/api/admins/login', {
                    identifier,
                    password,
                    remember
                });
                this.admin = JSON.stringify(admin);
                this.token = token;
            } catch ({ response }) {
                throw new Error(response.data.message);
            }
        },
        async logout() {
            const params = { _method: "delete" };

            try {
                const {
                    data: { message }
                } = await axios.post('/api/admins/logout', {}, { params });
                this.admin = null;
                this.token = null;

                return message;
            } catch ({ response }) {
                throw new Error(response.data.message);
            }
        }
    }
});
