const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const babel = require('gulp-babel');
const filter = require('gulp-filter');
const webpack = require('webpack-stream');
const browserSync = require('browser-sync').create();

// Пути
const paths = {
  src: {
    scss: 'src/scss/main.scss', // Компилируем только main.scss, остальные импортируются через @import
    js: 'src/js/**/*.js',
    jsMain: 'src/js/main.js' // Главный JS файл с импортами
  },
  dist: {
    css: 'assets/css',
    js: 'assets/js'
  }
};

// Инициализация BrowserSync
function initBrowserSync(done) {
  browserSync.init({
    proxy: 'http://pushw.test', // Замените на ваш локальный URL WordPress
    notify: false,
    open: false
  });
  done();
}

// Перезагрузка браузера
function reload(done) {
  browserSync.reload();
  done();
}

// Компиляция SCSS в CSS
function compileSCSS() {
  return gulp.src(paths.src.scss)
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: ['node_modules'],
      quietDeps: true,
      verbose: false
    }).on('error', sass.logError))
    .pipe(autoprefixer({
      cascade: false
    }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.dist.css))
    .pipe(cleanCSS())
    .pipe(rename({ suffix: '.min' }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.dist.css))
    .pipe(browserSync.stream());
}

// Компиляция JS файлов через webpack (для бандлинга модулей)
function compileJSFiles() {
  return gulp.src(paths.src.jsMain)
    .pipe(webpack({
      mode: 'development',
      output: {
        filename: 'main.js'
      },
      resolve: {
        extensions: ['.js']
      },
      module: {
        rules: [
          {
            test: /\.(css|scss)$/,
            use: 'ignore-loader' // Игнорируем CSS файлы
          }
        ]
      },
      devtool: 'source-map',
      target: ['web', 'es2015'], // Поддержка современных браузеров без Babel
      externals: {
        // Исключаем внешние зависимости, если они подключаются отдельно
      }
    }))
    .pipe(gulp.dest(paths.dist.js));
}

// Минификация JS файлов
function minifyJSFiles() {
  return gulp.src(paths.dist.js + '/main.js')
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.dist.js));
}

// Сборка всех файлов
const build = gulp.series(
  gulp.parallel(compileSCSS, compileJSFiles),
  minifyJSFiles
);

// Отслеживание изменений
function watch() {
  gulp.watch('src/scss/**/*.scss', compileSCSS); // Отслеживаем все .scss файлы, но компилируем только main.scss
  gulp.watch('src/js/**/*.js', gulp.series(compileJSFiles, minifyJSFiles, reload)); // Отслеживаем все .js файлы и перезагружаем браузер
  gulp.watch('**/*.php', reload); // Отслеживаем все .php файлы и перезагружаем браузер
}

// Экспорт задач
exports.compileSCSS = compileSCSS;
exports.compileJS = compileJSFiles;
exports.minifyJS = minifyJSFiles;
exports.build = build;
exports.watch = gulp.series(build, initBrowserSync, watch);
exports.default = build;

