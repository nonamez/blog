require('./bootstrap');

Vue.component('admin-post', require('./components/post/post.js'));

const app = new Vue({
	el: '#app'
})