// для запуска проекта нужно для начала скачать завиcимости
// для этого запускаем в папке web в терминале команду npm i
// это установит все  зависимости и можно будет делать сборку проекта

// собирает проект и запускает слежку изменения для пересборки на лету
// запускаем gulp dev

// собираем проект без слежки изменения файлов
// запускаем gulp build

const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const del = require('del');
const minify = require('gulp-minify');
const rename = require("gulp-rename");
const sourcemaps = require('gulp-sourcemaps');
const rigger = require('gulp-rigger'); // этот модуль собирает проект из кусочков js/html
sass.compiler = require('node-sass');
const browserSync = require('browser-sync').create();


function style() {
  return gulp.src('./src/scss/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass.sync({outputStyle: 'compressed', includePaths: ['node_modules']}).on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./build/css'))
    .pipe(browserSync.stream())
}

function watch() {
  browserSync.init({
    proxy: 'prof1group.test',
    open: false,
    notify: false
  });
  gulp.watch('./src/scss/**/*.scss', style);
  gulp.watch('./src/js/**/*.js', js);
}

function cleaner() {
  return del(['build/*']);
}

function js() {
  return gulp.src('./src/js/*.js')
    .pipe(rigger())
    .pipe(sourcemaps.init())
    // .pipe(minify({
    //   ext: {
    //     min: '.min.js'
    //   },
    // }))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('build/js/'));
}

gulp.task('sass', style);
gulp.task('watch', watch);
gulp.task('clean', cleaner);
gulp.task('scripts', js);


gulp.task('build', gulp.series(cleaner,
  gulp.parallel(style, js)
));


gulp.task('dev', gulp.series('build',
  gulp.parallel('watch')
));
