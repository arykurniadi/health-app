<template>
	<div id="layout">
		<HeaderPartial />
		<div class="main-content">
			<div class="container mt-3">
				<router-view />
			</div>	
		</div>
		<FooterPartial />
	</div>
</template>

<script>
import FooterPartial from "./footer/FooterPartial.vue";
import HeaderPartial from "./header/HeaderPartial.vue";

export default {
	name: 'LayoutComponent',
	components: {		
		HeaderPartial,
		FooterPartial,
	},
}
</script>