<template>
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h6>Edit Patient</h6>
			</div>
			<div class="card-body">
				<div v-if="isLoading" class="placeholder-glow">
					<span class="placeholder col-6"></span>
					<span class="placeholder w-75"></span>
					<span class="placeholder w-75"></span>
					<span class="placeholder col-6"></span>
				</div>

				<form v-if="!isLoading" @submit.prevent="submit">
					<div class="form-group row my-1">
						<div class="col-12">
							<label>NIK</label>
							<input v-model="nik.value.value" id="nik" name="nik" type="text" class="form-control"
								:class="{ 'is-invalid': nik.errorMessage.value }" />
							<span class="invalid-feedback">{{ nik.errorMessage.value }}</span>
						</div>
					</div>
					<div class="form-group row my-1">
						<div class="col-12">
							<label>Name</label>
							<input v-model="name.value.value" id="name" name="name" type="text" class="form-control"
								:class="{ 'is-invalid': name.errorMessage.value }" />
							<span class="invalid-feedback">{{ name.errorMessage.value }}</span>
						</div>
					</div>
					<div class="form-group row my-1">
						<div class="col-12">
							<label>Phone</label>
							<input v-model="phone.value.value" id="phone" name="phone" type="text" class="form-control"
								:class="{ 'is-invalid': phone.errorMessage.value }" />
							<span class="invalid-feedback">{{ phone.errorMessage.value }}</span>
						</div>
					</div>
					<div class="form-group row my-1">
						<div class="col-12">
							<label>Sex</label>
							<div>
								<div class="form-check">
									<input v-model="sex.value.value" class="form-check-input" type="radio" name="sex" value="male" id="sex_male">
									<label class="form-check-label">Male</label>
								</div>								
								<div class="form-check">
									<input v-model="sex.value.value" class="form-check-input" type="radio" name="sex" value="female" id="sex_female">
									<label class="form-check-label">Female</label>
								</div>						
							</div>
						</div>
					</div>
					<div class="form-group row my-1">
						<div class="col-12">
							<label>Religion</label>
							<select v-model="religion.value.value" id="religion" name="religion" class="form-select" :class="{ 'is-invalid': religion.errorMessage.value }">
								<option selected></option>
								<option value="islam">Islam</option>
								<option value="kristen">Kristen</option>
								<option value="katolik">Katolik</option>
								<option value="hindu">Hindu</option>
								<option value="budha">Budha</option>
							</select>	
							<span class="invalid-feedback">{{ religion.errorMessage.value }}</span>					
						</div>
					</div>
					<div class="form-group row my-1">
						<div class="col-12">
							<label>Address</label>
							<textarea v-model="address.value.value" id="address" name="address" class="form-control" :class="{ 'is-invalid': address.errorMessage.value }"></textarea>
							<span class="invalid-feedback">{{ address.errorMessage.value }}</span>
						</div>
					</div>
					<div class="form-group">
						<router-link to="/patient" class="btn btn-secondary mr-2">
							Cancel
						</router-link>

						<button v-if="isUpdating" type="button" class="btn btn-primary mx-2 my-2">Loading...</button>
						<input v-if="!isUpdating" type="submit" class="btn btn-primary mx-2 my-2" value="Submit">
					</div>					
				</form>
			</div>
		</div>
	</div>	
</template>
<script>
import { onMounted, inject } from 'vue'
import { useRoute, useRouter } from "vue-router";
import { useStore, mapGetters } from 'vuex';
import { useField, useForm } from 'vee-validate'

export default {
	components: {},

	setup() {
		const route = useRoute();
		const router = useRouter();
		const store = useStore();
		const swal = inject('$swal')

		const { id } = route.params;

		const { handleSubmit, errors, setErrors } = useForm({
			validationSchema: {
				// nik(value) {
				// 	if (value?.length > 0) return true;

				// 	return 'NIK is required'
				// },
				name(value) {
					if (value?.length > 0) return true;

					return 'Name is required'
				},
				phone(value) {
					if (value?.length > 0) return true;

					return 'Phone is required'
				},
				address(value) {
					if (value?.length > 0) return true;

					return 'Address is required'
				},
				religion(value) {
					if (value) return true;

					return 'Please choice religion'
				},
			},
		})

		const nik = useField('nik');
		const name = useField('name');
		const phone = useField('phone');
		const address = useField('address');
		const sex = useField('sex');
		const religion = useField('religion');

		onMounted(async () => {
      try {
        await store.dispatch('getById', id);

				const patientData = store.getters.patient;
				nik.value.value = patientData.nik
				name.value.value = patientData.name
				phone.value.value = patientData.phone
				address.value.value = patientData.address
				sex.value.value = patientData.sex
				religion.value.value = patientData.religion
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    });		

		const submit = handleSubmit(async (values) => {
			try {
				const patient = { id, ...values }			
				await store.dispatch('updatePatient', patient)			
			} catch(e) {
				if(e.response.data.status.code === 400) {					
					if(e.response.data.result) {
						if(e.response.data.result.errorDetail) {
							setErrors(e.response.data.result?.errorDetail)
						}
					} else {
						swal.fire({
							text: e.response.data.status.message,
							icon: "error",
							position: "top-end",
							timer: 2000,
						});
					}
				}	
			}
		})

		return {
			nik,
			name,
			phone,
			address,
			sex,
			religion,
			submit,
			errors,
		}
	},

  computed: {
    ...mapGetters(["isUpdating", "updatedData", "isLoading"]),
  },

	watch: {
		isUpdating: function() {
			console.log('--> watch', this.isUpdating, this.updatedData);
			if(!this.isUpdating && this.updatedData !== null) {
				this.$swal.fire({
					text: "Success, Data has been updated successfully !",
					icon: "success",
					position: "top-end",
					timer: 2000,
				});
				this.$router.push({ name: "Patient" })
			}
		},
	},

	methods: {},	
}
</script>