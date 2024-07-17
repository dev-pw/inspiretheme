"use strict";

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const rename = require("gulp-rename");

// Compilar Sass
function compileSass() {
    return gulp.src('./src/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(rename({ suffix: '.min' }))
        .pipe(sourcemaps.write('.', {
            includeContent: false,
            sourceRoot: function (file) {
                return '../src/sass/';
            }
        }))
        .pipe(gulp.dest('assets/css'));
}

// Compilar ícones
function compileIcon() {
    return gulp.src('./src/icon/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(rename({ basename: 'icon', suffix: '.min' }))
        .pipe(sourcemaps.write('.', {
            includeContent: false,
            sourceRoot: function (file) {
                return '../src/icon/';
            }
        }))
        .pipe(gulp.dest('assets/css'));
}

// Monitorar alterações em Sass e compilar automaticamente
function watchSass() {
    gulp.watch('./src/sass/**/*.scss', compileSass);
}

// Monitorar alterações em ícones e compilar automaticamente
function watchIcon() {
    gulp.watch('./src/icon/**/*.scss', compileIcon);
}

// Tarefa para compilar sass e ícones simultaneamente
gulp.task('default', gulp.parallel(watchSass, watchIcon));

// Tarefa para compilar apenas Sass
gulp.task('sass', compileSass);

// Tarefa para compilar apenas ícones
gulp.task('icon', compileIcon);

// Exportar as tarefas para que o Gulp 4 as reconheça
exports.default = gulp.parallel(watchSass, watchIcon);
exports.sass = compileSass;
exports.icon = compileIcon;
