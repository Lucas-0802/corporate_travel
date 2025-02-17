<template>
  <header class="header">
    <div class="header-left">
      <img src="/onfly.svg" alt="Logo" class="logo" />
      <h4 class="title mt-2">{{ $t("header.title") }}</h4>
    </div>
    <div class="header-right">
      <div class="dropdown" data-bs-toggle="dropdown">
        <button
          class="btn dropdown-btn dropdown-toggle"
          type="button"
          aria-expanded="false"
        >
          {{ $t("header.hello", { name: userName }) }}
        </button>
        <ul class="dropdown-menu">
          <li>
            <a class="dropdown-item" href="#" @click="openModal">
              <i class="bi bi-gear"></i> {{ $t("header.settings") }}
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#" @click="logout">
              <i class="bi bi-box-arrow-right"></i> {{ $t("header.logout") }}
            </a>
          </li>
        </ul>
      </div>
      <i class="bi bi-bell-fill notification-icon"></i>
    </div>
  </header>

  <UserSettingsModal />

  <!-- Exibir o Loading -->
  <LoadingSpinner v-if="loading" />
</template>

<script setup>
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useI18n } from "vue-i18n";
import LoadingSpinner from "./LoadingSpinner.vue";
import UserSettingsModal from "./UserSettingsModal.vue";
import api from "../api";

const { t } = useI18n();
const loading = ref(false);
const route = useRoute();
const router = useRouter();
const userName = route.query.name;

let bootstrap = window.bootstrap;

const openModal = () => {
  const modalElement = document.getElementById("userSettingsModal");
  if (modalElement && bootstrap) {
    const modalInstance = new bootstrap.Modal(modalElement);
    modalInstance.show();
  }
};

const logout = async () => {
  loading.value = true;
  try {
   await api.post("/logout");
   router.push("/login"); 
  } catch (error) {
    console.log(error);
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: white;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

h4 {
  font-size: 1.4rem;
}

.header-left {
  display: flex;
  align-items: center;
}

.logo {
  width: 40px;
}

.title {
  color: var(--primary-color);
  margin-left: 10px;
}

.header-right {
  display: flex;
  align-items: center;
}

.dropdown-btn {
  background-color: var(--orange-color);
  color: white;
  width: 170px;
  border: none;
  padding: 5px;
  cursor: pointer;
}

.notification-icon {
  color: var(--primary-color);
  margin-left: 1rem;
  font-size: 1.2rem;
  cursor: pointer;
}
</style>
