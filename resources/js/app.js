require('./bootstrap');

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

window.Vue = require('vue').default;
import Vuex from 'vuex'
Vue.use(Vuex)
import VueObserveVisibility from 'vue-observe-visibility'
Vue.use(VueObserveVisibility)
Vue.prototype.$user = User // we use global user object and bind into Vue (set in layout app.blade.php)

// For automatic component registration
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import timeline from './store/timeline'
import likes from './store/likes'
import reposts from './store/reposts'

const store = new Vuex.Store({
    modules: {
        timeline,
        likes,
        reposts,
        //notifications
    }
})
const app = new Vue({
    el: '#app',
    store
});

Echo.channel('posts')
    .listen('.LikesWereUpdated', (e) => {
        //if user id on this event
        if (e.user_id === User.id) {
            store.dispatch('likes/syncLike', e.id)
        }

        store.commit('timeline/SET_LIKES', e)
    })
    .listen('.RepostWasUpdated', (e) => {
        if (e.user_id === User.id) {
            store.dispatch('reposts/syncRepost', e.id)
        }

        store.commit('timeline/SET_REPOSTS', e)
    })
    .listen('.PostWasDeleted', (e) => {
        store.commit('timeline/POP_POST', e.id)
    })
