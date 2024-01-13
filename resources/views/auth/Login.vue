<script setup>
import { ref, toValue, watchEffect } from 'vue';
import { useAuthStore } from "@stores/auth";
import { useRouter } from 'vue-router'

const auth = useAuthStore();
const admin = ref({
  identifier: '',
  password: ''
});
const router = useRouter();


async function login() {
  try {
    await auth.login({ identifier: admin.value.identifier, password: admin.value.password });

    router.push('/admin')
      .then(() => { router.go(0) });
  } catch (error) {
    toastrAlert.error(error.message);
  }
}
</script>

<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <RouterLink to="/" class="h1"> <b>Admin</b>LTE </RouterLink>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Sign in to start your session</p>

          <form @submit.prevent="login">
            <div class="input-group mb-3">
              <input
                v-model="admin.identifier"
                name="identifier"
                class="form-control"
                placeholder="Email or Username"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input
                v-model="admin.password"
                type="password"
                class="form-control"
                placeholder="Password"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember" />
                  <label for="remember"> Remember Me </label>
                </div>
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">
                  Sign In
                </button>
              </div>
            </div>
          </form>

          <div class="social-auth-links text-center mt-2 mb-3">
            <a href="#" class="btn btn-block btn-primary" @click="test">
              <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
          </div>

          <p class="mb-1">
            <a href="#">I forgot my password</a>
          </p>
          <p class="mb-0">
            <a href="#" class="text-center">Register a new membership</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
