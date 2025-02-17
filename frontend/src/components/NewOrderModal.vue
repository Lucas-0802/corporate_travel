<template>
  <div
    class="modal fade"
    id="newOrderModal"
    tabindex="-1"
    aria-labelledby="newOrderModalLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newOrderModalLabel">
            {{ isEditing ? $t("order.edit_order") : $t("order.new_order") }}
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <form @submit.prevent="submitOrder">
          <div class="modal-body">
            <div class="mb-3">
              <label for="origin" class="form-label">{{
                $t("order.origin")
              }}</label>
              <select v-model="order.origin" ref="originInput" id="origin" class="form-control" required>
                <option value="" disabled>{{ $t("order.select_origin") }}</option>
                <option v-for="city in cities" :key="city" :value="city">
                  {{ city }}
                </option>
              </select>
            </div>

            <div class="mb-3">
              <label for="destination" class="form-label">{{
                $t("order.destination")
              }}</label>
              <select v-model="order.destination" ref="destinationInput" id="destination" class="form-control" required>
                <option value="" disabled>{{ $t("order.select_destination") }}</option>
                <option v-for="city in cities" :key="city" :value="city">
                  {{ city }}
                </option>
              </select>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="departure_date" class="form-label">{{
                    $t("order.departure_date")
                  }}</label>
                  <input type="date" ref="departureDateInput" v-model="order.departure_date" id="departure_date" class="form-control" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="return_date" class="form-label">{{
                    $t("order.return_date")
                  }}</label>
                  <input type="date" ref="returnDateInput" v-model="order.return_date" id="return_date" class="form-control" required />
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn cancel" data-bs-dismiss="modal">
              {{ $t("order.cancel") }}
            </button>
            <button type="submit" class="btn new-order-btn" :disabled="loading">
              {{ loading ? $t("order.processing") : isEditing ? $t("order.save_changes") : $t("order.create_order") }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <LoadingSpinner v-if="loading" />

    <FeedbackMessage v-if="feedbackMessage" :message="feedbackMessage" :type="feedbackType" />
  </div>
</template>


<script setup>
import { ref, nextTick } from "vue";
import { useI18n } from "vue-i18n";
import LoadingSpinner from "./LoadingSpinner.vue";
import FeedbackMessage from "./FeedbackMessage.vue";
import api from "../api";

const emit = defineEmits(["orderCreated"]);

const { t } = useI18n();

const cities = ref([
  "São Paulo - SP",
  "Rio de Janeiro - RJ",
  "Belo Horizonte - MG",
  "Salvador - BA",
  "Curitiba - PR",
  "Brasília - DF",
  "Porto Alegre - RS",
  "Manaus - AM",
  "Recife - PE",
  "Fortaleza - CE",
]);

const order = ref({
  id: null,
  origin: "",
  destination: "",
  departure_date: "",
  return_date: "",
});

const isEditing = ref(false);
const loading = ref(false);
const feedbackMessage = ref("");
const feedbackType = ref("success");


const departureDateInput = ref(null);
const returnDateInput = ref(null);
const originInput = ref(null);
const destinationInput = ref(null);

const openModalForEdit = async (existingOrder) => {
  if (!existingOrder) return;
  await nextTick();

  if (originInput.value) originInput.value.value = existingOrder.origin;
  if (destinationInput.value) destinationInput.value.value = existingOrder.destination;
  if (departureDateInput.value) departureDateInput.value.value = existingOrder.departure_date;
  if (returnDateInput.value) returnDateInput.value.value = existingOrder.return_date;

  isEditing.value = true;

  const modalElement = document.getElementById("newOrderModal");
  if (modalElement) {
    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
    modalInstance.show();
  }
};

const submitOrder = async () => {
  loading.value = true;
  feedbackMessage.value = "";

  try {
    let response;

    if (isEditing.value && order.value.id) {  
      response = await api.put(`/travel_order/update/${order.value.id}`, order.value);
    } else {
      response = await api.post("/travel_order/create", order.value);
    }

    const modalElement = document.getElementById("newOrderModal");
    if (modalElement) {
      const modalInstance = bootstrap.Modal.getInstance(modalElement);
      modalInstance.hide();
    }

    order.value = { id: null, origin: "", destination: "", departure_date: "", return_date: "" };
    isEditing.value = false;
    feedbackMessage.value = t(`messages.${response.data.message}`);
    feedbackType.value = "success";

    emit("orderCreated");
  } catch (error) {
    console.error(error);
    if (error.response?.data?.errors) {
      const firstErrorKey = Object.keys(error.response.data.errors)[0];
      feedbackMessage.value = t(`messages.${error.response.data.errors[firstErrorKey][0]}`);
    } else {
      feedbackMessage.value = t("messages.order_submission_failed");
    }
    feedbackType.value = "error";
  } finally {
    loading.value = false;
  }
};

defineExpose({ openModalForEdit });
</script>
