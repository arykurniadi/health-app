<template>
	<div class="container">
		<div class="row">
      <router-link to="/patient/create" class="btn btn-primary col-1" title="Add Product">Add</router-link>			
		</div>
		<div class="row justify-content-center mt-2 mb-2">
			<div class="col-8">
				<h4 class="text-left mb-2">
					Patients
				</h4>
			</div>
			<div class="col-4">
				<input v-model="query.search" type="text" @keyup.enter="searchHandle" class="form-control"
					placeholder="Search ...">
			</div>
		</div>
		<div v-if="isLoading">
			<p class="placeholder-glow"><span class="placeholder col-12"></span></p>
			<p class="placeholder-wave"><span class="placeholder col-12"></span></p>			
			<p class="placeholder-glow"><span class="placeholder col-12"></span></p>
			<p class="placeholder-wave"><span class="placeholder col-12"></span></p>
			<p class="placeholder-glow"><span class="placeholder col-12"></span></p>
			<p class="placeholder-wave"><span class="placeholder col-12"></span></p>			
			<p class="placeholder-glow"><span class="placeholder col-12"></span></p>
			<p class="placeholder-wave"><span class="placeholder col-12"></span></p>
		</div>
		<div v-if="!isLoading">
			<div class="">
				<div class="row border-bottom border-top p-2 bg-light">
					<div class="col-2">Nik</div>
					<div class="col-2">Name</div>
					<div class="col-1">Sex</div>
					<div class="col-1">Religion</div>
					<div class="col-2">Phone</div>
					<div class="col-3">Address</div>					
					<div class="col-1">Action</div>
				</div>
			</div>
			<div v-for="(item, index) in patientList" :key="item.id">
				<PatientDetailComponent :index="index" :item="item" />
			</div>
			<div v-if="patientsPaginatedData !== null" class="vertical-center mt-2 mb-5">
				<v-pagination 
					v-model="query.page"
					:pages="patientsPaginatedData.pagination.total_pages"
					:range-size="2"
					active-color="#DCEDFF"
					@update:modelValue="getResults"					
				/>
			</div>
		</div>
	</div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import VPagination from "@hennge/vue3-pagination";
import DetailComponent from "../list/DetailComponent.vue"

export default {
	name: "ListComponent",

	components: {
		PatientDetailComponent: DetailComponent,
		VPagination,
	},

	data() {		
		return {
			query: {
				page: 1,
				search: "",
			}
		}
	},

	computed: { ...mapGetters(["patientList", "isLoading", "patientsPaginatedData"]) },

	methods: {
		...mapActions(["getList"]),

		getResults() {
			this.getList(this.query)
		},

		searchHandle() {
			this.getList(this.query)
		},
	},

	async created() {
		await this.getList(this.query)		
	},
}
</script>