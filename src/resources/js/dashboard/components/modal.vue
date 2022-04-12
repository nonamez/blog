<template>
	<div class="modal" :id="ID_SELECTOR" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ title }}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="v-cloak" v-if="is_loading"></div>
				<div class="modal-body" v-if="!is_loading">
					<slot name="body"></slot>
				</div>
				<div class="modal-footer" v-if="!is_loading">
					<slot name="footer"></slot>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { getId } from 'helpers';

export default {
	props: {
		title: {
			type: String,
			default: '',
		}
	},

	emits: ['close'],

	setup(props,{emit}) {
		const ID = getId();
		const ID_SELECTOR = `#${ID}-modal`;

		const onClose = () => {
			emit('close');

			document.getElementById(ID_SELECTOR).removeEventListener('hide.bs.modal', onClose);
		};

		return {
			is_loading: null,

			ID,
			ID_SELECTOR,

			show: () => {
				const myModal = new window.bootstrap.Modal(document.getElementById(ID_SELECTOR), {
					keyboard: false
				});

				document.getElementById(ID_SELECTOR).addEventListener('hide.bs.modal', onClose);

				myModal.show();
			}
		};
	},
};
</script>
