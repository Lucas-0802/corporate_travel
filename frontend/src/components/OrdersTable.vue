<template>
  <section ref="ordersTable" class="orders-table">
    <div class="table-header">
      <h5>{{ $t("orders.title") }}</h5>
    </div>

    <div class="table-container">
      <table class="table mt-4">
        <thead>
          <tr class="text-center">
            <th scope="col">{{ $t("orders.id") }} <i class="bi bi-filter"></i></th>
            <th scope="col">{{ $t("orders.requester") }} <i class="bi bi-filter"></i></th>
            <th scope="col">{{ $t("orders.origin") }} <i class="bi bi-filter"></i></th>
            <th scope="col">{{ $t("orders.destination") }} <i class="bi bi-filter"></i></th>
            <th scope="col">{{ $t("orders.period") }} <i class="bi bi-filter"></i></th>
            <th scope="col">{{ $t("orders.status") }} <i class="bi bi-filter"></i></th>
            <th scope="col">{{ $t("orders.actions") }}</th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center" v-for="order in paginatedOrders" :key="order.id">
            <td scope="row">{{ order.idPedido }}</td>
            <td>{{ order.solicitante }}</td>
            <td>{{ order.origem }}</td>
            <td>{{ order.destino }}</td>
            <td>{{ order.periodo }}</td>
            <td>
              <span :class="['badge', getStatusClass(order.status)]">
                {{ order.status }}
              </span>
            </td>
            <td>
              <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ $t("orders.select") }}
                </button>
                <ul class="dropdown-menu">
                  <li v-if="user_type === 'admin'">
                    <a class="dropdown-item" href="#" @click="approveOrder(order.id)">
                      <i class="bi bi-check2-circle"></i> {{ $t("orders.approve") }}
                    </a>
                  </li>
                  <li v-if="user_type === 'admin'">
                    <a class="dropdown-item" href="#" @click="cancelOrder(order.id)">
                      <i class="bi bi-x-circle"></i> {{ $t("orders.cancel") }}
                    </a>
                  </li>
                  <li v-if="user_type === 'common'">
                    <a class="dropdown-item" href="#" @click="editOrder(order)">
                      <i class="bi bi-pencil-square"></i> {{ $t("orders.edit") }}
                    </a>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <nav class="mt-2 align-self-end" aria-label="Page Navigation">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <button class="page-link" @click="prevPage" :disabled="currentPage === 1">
            {{ $t("pagination.previous") }}
          </button>
        </li>
        <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === currentPage }">
          <button class="page-link" @click="goToPage(page)">{{ page }}</button>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <button class="page-link" @click="nextPage" :disabled="currentPage === totalPages">
            {{ $t("pagination.next") }}
          </button>
        </li>
      </ul>
    </nav>
  </section>

  <LoadingSpinner v-if="loading" />
  <NewOrderModal ref="newOrderModal" @orderCreated="fetchOrders" />
</template>


<script setup>
import { ref, computed, onMounted } from "vue";
import { useI18n } from "vue-i18n";
import api from "../api";
import { formatDate } from "../utils/formatDate";
import { getStatusClass } from "../utils/statusUtils";
import LoadingSpinner from "./LoadingSpinner.vue";
import NewOrderModal from "./NewOrderModal.vue";

const newOrderModal = ref(null);
const user_type = ref(localStorage.getItem("user_type") || "common");
const { t } = useI18n();
const emit = defineEmits(["updatedOrder"]);

const orders = ref([]);
const loading = ref(false);
const errorMessage = ref("");
const currentPage = ref(1);
const itemsPerPage = ref(5);

const fetchOrders = async () => {
  loading.value = true;
  errorMessage.value = "";

  try {
    const response = await api.get("/travel_order/list");
    orders.value = response.data.orders.map((order) => ({
      id: order.id, 
      idPedido: order.id,
      solicitante: order.user.name,
      origem: order.origin,
      destino: order.destination,
      periodo: `${formatDate(order.departure_date)} - ${formatDate(order.return_date)}`,
      status: order.status.name,
      departure_date: order.departure_date, 
      return_date: order.return_date,
    }));
  } catch (error) {
    console.error("Erro ao buscar pedidos:", error);
    errorMessage.value = t("errors.fetch_orders");
  } finally {
    loading.value = false;
  }
};

const approveOrder = async (id) => {
  try {
    await api.put(`/admin/travel_order/update_status/${id}`, {status_id: 2});
    fetchOrders();
    emit("updatedOrder");
  } catch (error) {
    console.error("Erro ao aprovar pedido:", error);
  }
};

const cancelOrder = async (id) => {
  try {
    await api.put(`/admin/travel_order/update_status/${id}`, {status_id: 3});
    fetchOrders();
    emit("updatedOrder");
  } catch (error) {
    console.error("Erro ao cancelar pedido:", error);
  }
};

const editOrder = (order) => {
  if (newOrderModal.value) {
    newOrderModal.value.openModalForEdit(order);
  }
};

onMounted(fetchOrders);

const totalPages = computed(() => Math.ceil(orders.value.length / itemsPerPage.value));
const paginatedOrders = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return orders.value.slice(start, start + itemsPerPage.value);
});

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};
const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

defineExpose({ fetchOrders });
</script>



<style scoped>
.orders-table {
  background: white;
  padding: 1rem;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  margin-top: 1rem;
  min-height: 66vh;
  max-height: 66vh;
  display: flex;
  flex-direction: column;
  overflow: auto;
}

.table-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: auto;
  padding-bottom: 30px;
}

.table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.pagination {
  display: flex;
  justify-content: center;
  margin-top: 10px;
  padding-top: 10px;
}

.pagination button {
  background: var(--primary-color);
  color: white;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
  margin: 0 5px;
}

.pagination button:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.table th {
  color: #2c2d33;
}

.table td {
  color: #6e7079;
}

.badge-primary {
  background-color: #5570f1;
  color: white;
}
.badge-success {
  background-color: #519c66;
  color: white;
}
.badge-danger {
  background-color: #ea5018;
  color: white;
}
</style>
