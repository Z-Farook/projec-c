import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faSearch, faHeart, faHeartbeat, faStar, faPlus, faPen, faTrash } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faSearch);
library.add(faHeart);
library.add(faHeartbeat);
library.add(faStar);
library.add(faPlus);
library.add(faPen);
library.add(faTrash);

Vue.component('font-awesome-icon', FontAwesomeIcon);