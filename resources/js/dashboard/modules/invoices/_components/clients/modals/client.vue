<template>
	<modal ref="modal" title="Client Info">
		<template v-slot:body>
			<h1>body</h1>
		</template>
	</modal>
</template>
<script>
import { ref } from 'vue';

export default {

	setup() {
		const modal = ref(null);

		return {
			modal,

			show: () => {
				modal.value?.show();
			}
		};
	},
};
</script>
