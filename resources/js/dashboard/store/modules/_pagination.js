const state = {
	pagination: {
		prev_page_url: false,
		next_page_url: false,
		current_page: 1,
		last_page: 1
	}
};

const getters = {
	pagination_simple: state => {
		return (({
			prev_page_url,
			next_page_url,
			current_page,
			last_page
		}) => ({
			prev_page_url,
			next_page_url,
			current_page,
			last_page
		}))(state.pagination);
	}
};

export default {
	state,
	getters
};