const webpack = require('webpack');

module.exports = {
    // ... other webpack/vue.config.js settings ...

    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
        }),
    ],
};
