const Encore = require('@symfony/webpack-encore');

// Configure the runtime environment
Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');

Encore
    // Directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // Public path used by the web server to access the output path
    .setPublicPath('/build')
    // Add the entry point for your app
    .addEntry('app', './assets/app.js') // Ensure the path to app.js is correct
    // Enable a single runtime chunk
    .enableSingleRuntimeChunk()
    // Clean the output folder before each build
    .cleanupOutputBeforeBuild()
    // Enable source maps during development
    .enableSourceMaps(!Encore.isProduction())
    .enablePostCssLoader()
    // Enable versioning in production
    .enableVersioning(Encore.isProduction());

module.exports = Encore.getWebpackConfig();
