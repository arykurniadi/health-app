import axios from 'axios'

const state = () => ({
  patients: [],
  patientsPaginatedData: null,
  patient: null,
  isLoading: false,
  isCreating: false,
  createdData: null,
  isUpdating: false,
  updatedData: null,
  isDeleting: false,
  deletedData: null
})

const getters = {
	patientList: (state) => state.patients,
	isLoading: (state) => state.isLoading,
	patientsPaginatedData: (state) => state.patientsPaginatedData,
  patient: (state) => state.patient,
  isCreating: state => state.isCreating,
  createdData: state => state.createdData,
  isUpdating: (state) => state.isUpdating,
  updatedData: state => state.updatedData,
  isDeleting: state => state.isDeleting,
  deletedData: state => state.deletedData
}

const actions = {
	async getList({ commit }, query = null) {
		let search = ''
		const perPage = 20;
		let page = 1;
    if(query !== null){
      page = query?.page || 1;
      search = query?.search || '';		
    }

		commit('setPatientIsLoading', true)
    await axios
      .get(`${import.meta.env.VITE_APP_API_URL}/v1/crm/patient?search=${search}&page=${page}&perPage=${perPage}`)
      .then((res) => {
				const patients = res.data.result.data
				commit('setPatients', patients)		
				
        const pagination = {
          total: res.data.result.count,
          per_page: res.data.result.perPage,
					current_page: res.data.result.currentPage,
          total_pages: res.data.result.totalPage,
        }
				res.data.pagination = pagination				

				commit('setPatientsPaginated', res.data)
				commit('setPatientIsLoading', false)
      })
      .catch((err) => {
        console.log('error', err)
				commit('setPatientIsLoading', false)
      })
	},

  async getById({ commit }, id) {
    commit('setPatientIsLoading', true)
    await axios.get(`${import.meta.env.VITE_APP_API_URL}/v1/crm/patient/${id}`)
      .then(res => {        
        commit('setPatientIsLoading', false)
        commit('setPatientDetail', res.data.result)
      }).catch(err => {
        console.log('error', err);
        commit('setPatientIsLoading', false)
      });
  },

  async createPatient({ commit }, patient) {
    commit('setPatientIsCreating', true);    
    await axios.post(`${import.meta.env.VITE_APP_API_URL}/v1/crm/patient`, patient, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }      
    })
      .then(res => {
        commit('saveNewPatient', res.data.result);
        commit('setPatientIsCreating', false);    
      }).catch(err => {
        console.log('error', err);
        commit('setPatientIsCreating', false);    
        throw(err)
      });

  },

  async updatePatient({ commit }, patient) {
    const { id } = patient
    delete patient.id

    commit('setPatientIsUpdating', true);    

    await axios.put(`${import.meta.env.VITE_APP_API_URL}/v1/crm/patient/${id}`, patient, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }      
    })
      .then(res => {
        commit('setPatientIsUpdating', false);
        commit('saveUpdatedPatient', patient);
      }).catch(err => {
        console.log('error', err);        
        commit('setPatientIsUpdating', false);
        commit('saveUpdatedPatient', null);
        throw err
      });
  },

  async deletePatient({ commit }, id) {
    commit('setPatientIsDeleting', true)

    await axios.delete(`${import.meta.env.VITE_APP_API_URL}/v1/crm/patient/${id}`)
      .then(res => {
        commit('setDeletePatient', id);
        commit('setPatientIsDeleting', false)
      }).catch(err => {
        console.log('error', err);
        commit('setPatientIsDeleting', false)
      });

  },
}

const mutations = {
	setPatients(state, patients) {
		state.patients = patients
	},

	setPatientIsLoading(state, isLoading) {
		state.isLoading = isLoading
	},

	setPatientsPaginated(state, patientsPaginatedData) {
		state.patientsPaginatedData = patientsPaginatedData
	},

  setPatientDetail(state, patient) {
    state.patient = patient;
  },

  setPatientIsCreating(state, isCreating) {
    state.isCreating = isCreating
  },

  saveNewPatient: (state, patient) => {
    state.patients.unshift(patient)
    state.createdData = patient;
  },

  setPatientIsUpdating(state, isUpdating) {
    state.isUpdating = isUpdating
  },

  saveUpdatedPatient(state, patient) {
    state.patients.unshift(patient)
    state.updatedData = patient;
  },  

  setPatientIsDeleting(state, isDeleting) {
    state.isDeleting = isDeleting
  },

  setDeletePatient: (state, id) => {
    state.patientsPaginatedData.patients.filter(x => x.id !== id);    
  },

}

export default {
  // namespaced: true,
  state,
  getters,
  actions,
  mutations
}
