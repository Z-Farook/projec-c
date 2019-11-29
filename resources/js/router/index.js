import Vue from 'vue'
import Router from 'vue-router'
import Home from '../pages/Home'
import Search from '../pages/Search'
import Movie from '../pages/Movie'
import Ticket from '../pages/Ticket'
import Seat from '../pages/Seat'
import Order from '../pages/Order'
import Summary from '../pages/Summary'
import Contact from '../pages/Contact'
import Actor from '../pages/Actor'
import Food from '../pages/Food'
import Favorites from '../pages/Favorites'
import Reservations from '../pages/Reservations'


Vue.use(Router);
//this the routre constructer with an array of parameters
// this is passed in Core.vue as  <router-view></router-view>
export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/favorieten',
            name: 'favorites',
            component: Favorites
        },
        
        {
            path: '/reservations',
            name: 'reservations',
            component: Reservations
        },
       // food and drink path
    // this imported in the "app.js" and then passed into the "new Vue" instance with a alias named "router" after the the attibute components{...} router,
        {
            path: '/food',
            name: 'food',
            component: Food
        },

        {
            path: '/contact',
            name: 'contact',
            component: Contact
        },

        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/ticket',
            name: 'ticket',
            props: true,
            component: Ticket
        },
        {
            path: '/order',
            name: 'order',
            props: true,
            component: Order
        },
        {
            path: '/summary',
            name: 'summary',
            props: true,
            component: Summary
        },
        {
            path: '/seat',
            name: 'seat',
            props: true,
            component: Seat
        },
        {
            path: '/zoeken',
            name: 'search',
            props: true,
            component: Search
        },
        {
            path: '/film/:id',
            name: 'movie',
            props: true,
            component: Movie
        },
        {
            path: '/acteur/:id',
            name: 'actor',
            props: true,
            component: Actor
            // TODO: Add Component
        },
        {
            path: '/over',
            name: 'about',
            // TODO: Add Component
        },
        {
            path: '*',
            name: '404 not found',
            // TODO: Add Component
        }
    ]
})