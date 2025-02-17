<template>
    <div class="dashboard">
      <Header />
      <DashboardOverview />
      <OrdersTable />
      <NewOrderModal @orderCreated="refreshOrders" />
    </div>
  </template>
  
  <script setup>
  import Header from "../components/Header.vue";
  import DashboardOverview from "../components/DashboardOverview.vue";
  import OrdersTable from "../components/OrdersTable.vue";
  import NewOrderModal from "../components/NewOrderModal.vue";
  import { ref } from "vue";

  const ordersTable = ref(null);
  const refreshOrders = () => {
  if (ordersTable.value) {
    ordersTable.value.fetchOrders();
  }
};
  </script>
  
  <style scoped>
  .dashboard {
    padding: 2rem;
    background-color: var(--background-color);
    height: 100vh;
  }
  </style>