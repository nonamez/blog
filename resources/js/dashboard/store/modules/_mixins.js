export default function(initialState) {
	return {
		mutations: {
			_set(state, data) {       
				for (let key in data) {
					if (key in state) {
						state[key] = data[key];
					}
				}
			},

			_reset(state) {
				const s = initialState();

				Object.keys(s).forEach(key => {
					state[key] = s[key];
				});
			}
		}
	};
}