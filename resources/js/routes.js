
let login=require('./components/auth/login.vue').default;
let register=require('./components/auth/register.vue').default;
let forget=require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
///end authentication------

let employee = require('./components/employee/index.vue').default;
let storeemployee = require('./components/employee/create.vue').default;
let editemployee = require('./components/employee/edit.vue').default;



//product----
let storeproduct = require('./components/product/create.vue').default;
let product = require('./components/product/index.vue').default;
let editproduct = require('./components/product/edit.vue').default;




let home=require('./components/home').default;
 export const routes = [
    { path: '/', component: login,name:'/' },
    { path: '/register', component: register,name:'/register' },
    { path: '/forget', component: forget,name:'/forget' },
     { path: '/logout', component: logout , name:'logout' },
     { path: '/home', component: home , name:'home' },



     //product---
     { path: '/store-product', component: storeproduct, name:'store-product' },
     { path: '/product', component: product, name:'product' },
     { path: '/edit-product/:id', component: editproduct, name:'edit-product' },



]