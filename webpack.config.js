var config = {
  entry: "./main.js",
  output: { path: "/", filename: "index.js" },
  devServer: { inline: true, port: 8080 },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        loader: "babel-loader",
        query: { presets: ["@babel/env", "@babel/react"],plugins: [
        "@babel/plugin-proposal-object-rest-spread",
        "@babel/plugin-proposal-class-properties",
        "@babel/plugin-transform-react-jsx"
      ] },
      }
    ]
  }
};
module.exports = config;
