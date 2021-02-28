module.exports = {
    filenameHashing: false,
    publicPath: "./",
    outputDir: "dist",
    chainWebpack: (config) => {
      config.plugins.delete("html");
      config.plugins.delete("preload");
      config.plugins.delete("prefetch");
      config.module
        .rule("images")
        .use("url-loader")
        .tap((options) => {
          options.name = "/img/[name].[ext]";
          options.publicPath =
            "../wp-content/plugins/vue-author-generator/app/dist/";
          return options;
        });
    },
    devServer: {
      writeToDisk: true,
      hot: false,
      disableHostCheck: true
    },
    productionSourceMap: false,
  };