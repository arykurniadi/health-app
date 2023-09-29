import { createStore, createLogger } from 'vuex';
import VuexPersistence from 'vuex-persist';
import localForage from 'localforage';
import patient from './modules/Patient';

const debug = import.meta.env.VITE_NODE_ENV !== 'production'

const vuexLocal = new VuexPersistence({
  asyncStorage: true,
  storage: {
    getItem: async (key) => {
      const raw = await localForage.getItem(key)
      const data = raw ? JSON.parse(raw) : {}
      return data
    },
    setItem: async (key, value) => {
      const valueString = JSON.stringify(value)
      localForage.setItem(key, valueString)
    },
    removeItem: async (key) => localForage.removeItem(key),
  },  
});

const Store = createStore({
  modules: {
    patient,
  },
  strict: debug,
  plugins: debug ? [createLogger(), vuexLocal.plugin] : [vuexLocal.plugin]
})

export default Store;