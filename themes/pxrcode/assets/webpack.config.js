const path = require('path')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const OptimizeCssAssetWebpackPlugin = require('optimize-css-assets-webpack-plugin')
const TerserWebpackPlugin = require("terser-webpack-plugin")
const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

const isDev = process.env.NODE_ENV === 'development'
const isProd = !isDev
const filename = ext => `[name].${ext}`

const optimization = () => {
   const config = {
      splitChunks: {
         name: 'vendor',
         chunks: 'all',
         // maxSize: 500000,
      }
   }

   if (isProd) {
      config.minimizer = [
         new OptimizeCssAssetWebpackPlugin(),
         new TerserWebpackPlugin()
      ]
   }

   return config
}

const cssLoaders = extra => {
   const loaders = [
      {
         loader: MiniCssExtractPlugin.loader,
         options: {
            publicPath: (resourcePath, context) => {
               return path.relative(path.dirname(resourcePath), context) + '/';
            },
         }
      },
      {
         loader: "css-loader",
         options: {
            url: false
         }
      },
   ]

   if (extra) {
      loaders.push(extra)
   }

   return loaders
}

const babelOptions = preset => {
   const opts = {
      presets: [
         '@babel/preset-env',
      ],
      plugins: [
         '@babel/plugin-proposal-class-properties'
      ]
   }

   if (preset) {
      opts.presets.push(preset)
   }

   return opts
}

const jsLoaders = () => {
   const loaders = [{
      loader: 'babel-loader',
      options: babelOptions()
   }]

   // if (isDev) { 
   //   loaders.push('eslint-loader') // esLint debug on dev
   // }

   return loaders
}

const plugins = () => {
   const base = [
      new CleanWebpackPlugin(),
      new MiniCssExtractPlugin({
         filename: `./css/${filename('css')}`
      })

   ]

   // if (isProd) {
   //    base.push(new BundleAnalyzerPlugin()) // analyzer app size
   // }

   return base
}

module.exports = {
   context: path.resolve(__dirname, 'src'),
   mode: 'development',
   entry: {
      main: [
         '@babel/polyfill',
         '@/js/libs/velocity.lib.js',
         // '@/js/libs/swiper.lib.js',
         '@/js/main.js'
      ],
   },
   output: {
      filename: `./js/${filename('js')}`,
      path: path.resolve(__dirname, 'dist'),
      publicPath: ''
   },
   resolve: {
      extensions: ['.js'],
      alias: {
         '@style-models': path.resolve(__dirname, 'src/scss/style-models'),
         '@': path.resolve(__dirname, 'src'),
         '@csslib': path.resolve(__dirname, 'src/css-libs'),
         '@models': path.resolve(__dirname, 'src/js/models'),
      }
   },
   devServer: {
      historyApiFallback: true,
      contentBase: path.resolve(__dirname, 'dist'),
      open: true,
      compress: true,
      port: 3000,
      hot: true,
   },
   optimization: optimization(),
   devtool: isDev ? 'source-map' : false,
   plugins: plugins(),
   // target: 'web', // only for develomplent(enable npm run start)
   module: {
      rules: [
         {
            test: /\.css$/,
            use: cssLoaders()
         },
         {
            test: /\.s[ac]ss$/,
            use: cssLoaders("sass-loader")
         },
         {
            test: /\.js$/,
            exclude: /node_modules/,
            use: jsLoaders()
         },
         {
            test: /\.lib\.js$/,
            loader: 'imports-loader',
            exclude: /node_modules/,
            options: {
               wrapper: {
                  thisArg: 'window',
                  args: {
                     module: true,
                     exports: true,
                     define: true,
                  }
               },
            },
         },
      ]
   }
}