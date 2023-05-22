/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import '../assets/js/config';
import '../assets/vendor/js/helpers';
// import '../assets/vendor/libs/jquery/jquery';
import '../assets/vendor/libs/popper/popper';
import '../assets/vendor/js/bootstrap';
import '../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar';
import '../assets/vendor/js/menu';
import '../assets/js/main';
// import '../assets/js/dashboards-analytics';
import 'https://buttons.github.io/buttons.js';

import jQuery from 'jquery';
window.$ = jQuery
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

$(function() {
    $('#subscription_id').on('change', function() {
        let subscription = JSON.parse($('#subscription_id').find(':selected').attr('data-subscription'))
        $('#subscription-max_products').val(subscription.max_products)
        $('#subscription-price').val(subscription.price)
        $('#subscription_type').val(subscription.name)
        
        if(subscription.name=='free') {
            $('#payment-gateway-container').addClass('d-none')
            $('#payment-number-container').addClass('d-none')        
        } else {
            $('#payment-gateway-container').removeClass('d-none')
            if(!$('#payment-number-container').hasClass('d-none')) {
                $('#payment-number-container').addClass('d-none')        
            } else {
                $('#payment-number-container').addClass('d-none')        
            }
        }
    })

    $('#payment-gateway-toggler').on('change', function() {
        if(!$(this).val()) {
            $('#payment-number-container').addClass('d-none')        
        } else {
            $('#payment-number-container').removeClass('d-none')        
        }
    });

    // set database name by default
    $('#database_name').val('tenant'+$(this).val())

    $('#default-domain').on('input', function() {

        const domain = $(this).val();
        console.log(domain)
        $('#database_name').val('tenant'+$(this).val())
    });
})

app.mount('#app');
