<template>
  <div class="home">
    <!-- <div class="p-4">
      <div class="row">
        <div class="col-md-2">
          <router-link to="/products" class="btn btn-primary p-4 dashboard-widget">
            All Products
            <br>
            <span class="badge badge-info">
              0
            </span>
          </router-link>
        </div>
        <div class="col-md-2">
          <router-link to="/products/create" class="btn btn-primary p-4 dashboard-widget">
            Create New Product <i class="fa fa-plus-circle" />
          </router-link>
        </div>
      </div>
    </div> -->
    <div>
      <PatientListComponent />
    </div>
  </div>
</template>

<script>
import ListComponent from '../components/patient/list/ListComponent.vue';

export default {
  name: "HomePage",
  components: {
    PatientListComponent: ListComponent,
  },
}
</script>