<template>
  <div>
		<PatientListComponent />
	</div>
</template>
<script>
import ListComponent from '../../components/patient/list/ListComponent.vue'

export default {
  components: {
    PatientListComponent: ListComponent,
  },
}
</script>