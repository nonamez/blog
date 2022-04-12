import { route } from 'helpers';
import mixins from 'store/modules/_mixins';
import pick from 'lodash/pick';

const _MIXINS = mixins(initialState);

function initialState() {
	return {
		id: null,
		routes: null,

		name: null,

		address: null,
		city: null,
		country: null,
		zip_code: null,

		email: null,
		phone: null,
		
		url: null,
		
		vat_code: null,
		company_code: null
	};
}

const state = initialState();

const getters = {
	data: (state) => {
		return pick(state, ['name', 'address', 'city', 'country', 'zip_code', 'email', 'phone', 'url', 'vat_code', 'company_code']);
	}
};

const mutations = {
	..._MIXINS.mutations,

	setName(state, name) {
		state.name = name;
	},

	setAddress(state, address) {
		state.address = address;
	},

	setCity(state, city) {
		state.city = city;
	},

	setCountry(state, country) {
		state.country = country;
	},

	setZipCode(state, zip_code) {
		state.zip_code = zip_code;
	},

	setEmail(state, email) {
		state.email = email;
	},

	setPhone(state, phone) {
		state.phone = phone;
	},

	setUrl(state, url) {
		state.url = url;
	},

	setVatCode(state, vat_code) {
		state.vat_code = vat_code;
	},

	setCompanyCode(state, company_code) {
		state.company_code = company_code;
	},
};

const actions = {
	find({commit}, client_id) {
		commit('setIsLoading', 'invoices-clients', {root: true});

		let url = route('dashboard.invoices.clients.find', client_id);

		return new Promise((resolve) => {
			axios.get(url).then(response => {
				commit('_set', response.data.data);

				resolve(response.data.data);
			}).catch(() => {
				commit('_reset');

				resolve([]);
			}).finally(() => {
				commit('setIsLoading', false, {root: true});
			});
		});
	},

	save({state, getters, commit}) {
		commit('setIsLoading', 'invoices-clients', {root: true});

		let url = state.routes ? state.routes.save : route('dashboard.invoices.clients.save');

		return new Promise((resolve) => {
			axios.post(url, getters.data).then(() => {
				resolve();
			}).finally(() => {
				commit('setIsLoading', false, {root: true});
			});
		});
	},
};

export default {
	namespaced: true,
	state,
	getters,
	mutations,
	actions
};