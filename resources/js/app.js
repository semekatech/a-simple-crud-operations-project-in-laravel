import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler.js'
import Loader from "./controls/Loader.vue";
import SearchBox from "./controls/SearchBox.vue";
import MembersIndex from "./members/Index.vue";
import RoundedImage from "./controls/RoundedImage.vue";
import Member from "./members/Member.vue";
import UploadPhoto from "./members/UploadPhoto.vue";

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import View from "./members/View.vue";
import Profile from "./members/Profile.vue";


const app = createApp({});
app.component('loader', Loader);
app.component('search-box', SearchBox);
app.component('members', MembersIndex)
app.component('rounded-image', RoundedImage)
app.component('member', Member)
app.component('upload-photo', UploadPhoto)
app.component('member-view', View)
app.component('profile', Profile)

app.component('Datepicker', Datepicker);
app.mount("#app")
