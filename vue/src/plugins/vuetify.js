// src/plugins/vuetify.js
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';

export default createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
    },
});
