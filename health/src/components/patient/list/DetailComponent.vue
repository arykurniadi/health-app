<template>
	<div class="row border-1 p-2">
    <div class="col-2 text-left">{{ item.nik }}</div>
    <div class="col-2 text-left">{{ item.name }}</div>
    <div class="col-1">{{ item.sex }}</div>
    <div class="col-1">{{ item.religion }}</div>
    <div class="col-2">{{ item.phone }}</div>
    <div class="col-3">{{ item.address }}</div>
    <div class="col-1" style="padding-left:0;padding-right:0;">
      <router-link
				:to="{ name: 'PatientEdit', params: { id: item.id } }"
        class="btn btn-primary mr-2"
        title="Edit Patient"
      >
				<i class="fa fa-pencil" />
			</router-link>			
      <button
        class="btn btn-danger mx-2"
        title="Delete"
				@click="deleteItemHandle(item.id)"
      >
        <i class="fa fa-trash" />
      </button>			
    </div>
	</div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
	name: "DetailComponent",
	
	props: {
		item: {
			type: Object,
			required: true,
		},
		index: {
			type: Number,
			required: true,
			default: 0,
		},
	},

  computed: { ...mapGetters(["isDeleting", "deletedData"]) },

	methods: {
    ...mapActions(["deletePatient", "getList"]),

		deleteItemHandle(id) {
      this.$swal
        .fire({
          text: "Are you sure to delete this data ?",
          icon: "error",
          cancelButtonText: "Cancel",
          confirmButtonText: "Yes, Confirm Delete",
          showCancelButton: true,
        })
        .then((result) => {
          if(result["isConfirmed"]){
            this.deletePatient(id)
              .then(() => {
                this.getList({
                  page: 1,
                  search: ''
                })					
                this.$swal.fire({
                  text: "Success, Data has been deleted.",
                  icon: "success",
                  position: 'top-end',
                  timer: 2000,
                });
              })
              .catch(() => {
                this.$swal.fire({
                  text: "Error, Data failure deleted",
                  icon: "error",
                  position: "top-end",
                  timer: 2000,
                });
              });
          }
        });			
		},
	},
}
</script>