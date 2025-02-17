<template>
    <div
      class="modal fade"
      id="userSettingsModal"
      tabindex="-1"
      aria-labelledby="userSettingsModalLabel"
      aria-hidden="true"
      data-bs-backdrop="static"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userSettingsModalLabel">
              {{ $t("user.settings") }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form @submit.prevent="saveUserSettings">
            <div class="modal-body">
             
              <div class="mb-3">
                <label for="name" class="form-label">{{ $t("user.name") }}</label>
                <input type="text" class="form-control" id="name" v-model="user.name" required />
              </div>
  
            
              <div class="mb-3">
                <label for="email" class="form-label">{{ $t("user.email") }}</label>
                <input type="email" class="form-control" id="email" v-model="user.email" />
              </div>
  
        
              <div class="mb-3">
                <label for="password" class="form-label">{{ $t("user.new_password") }}</label>
                <input type="password" class="form-control" id="password" v-model="user.password" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn cancel" data-bs-dismiss="modal">
                {{ $t("user.cancel") }}
              </button>
              <button type="submit" class="btn new-order-btn" :disabled="loading">
                {{ loading ? $t("user.processing") : $t("user.save") }}
              </button>
            </div>
          </form>
        </div>
      </div>
  
      <!-- Exibir o Loading -->
      <LoadingSpinner v-if="loading" />
  
      <!-- Exibir Feedback -->
      <FeedbackMessage v-if="feedbackMessage" :message="feedbackMessage" :type="feedbackType" />
    </div>
  </template>
  
  <script setup>
  import { ref } from "vue";
  import { useI18n } from "vue-i18n";
  import LoadingSpinner from "./LoadingSpinner.vue";
  import FeedbackMessage from "./FeedbackMessage.vue";
  
  const { t } = useI18n();
  
  const user = ref({
    name: "", 
    email: "", 
    password: "", 
  });
  
  const loading = ref(false);
  const feedbackMessage = ref("");
  const feedbackType = ref("success");
  
  const saveUserSettings = () => {
  };
  </script>
  
  <style scoped>
  .modal-body {
    padding: 20px;
  }
  
  .form-control {
    width: 100%;
  }
  
  .btn-primary {
    background-color: var(--primary-color);
    border: none;
  }
  
  .btn-primary:hover {
    background-color: var(--primary-color-dark);
  }
  </style>
  