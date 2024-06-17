"use strict"

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const rename = require("gulp-rename");

function compileSass() {
    return gulp.src('./src/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        })
        .on('error', sass.logError))
        .pipe(rename({ suffix: '.min'}))
        .pipe(sourcemaps.write('.' ,{
            includeContent: false,
            sourceRoot: function (file) {
                return '../src/sass/';
            }
        }))
        .pipe(gulp.dest('css'))
};

function compileIcon() {
    return gulp.src('./src/icon/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        })
        .on('error', sass.logError))
        .pipe(rename({ basename: 'icon', suffix: '.min'}))
        .pipe(sourcemaps.write('.' ,{
            includeContent: false,
            sourceRoot: function (file) {
                return '../src/icon/';
            }
        }))
        .pipe(gulp.dest('css'))
};

function watchSass() {
    gulp.watch('./src/sass/**/*.scss', compileSass)
}

function watchIcon() {
    gulp.watch('./src/icon/**/*.scss', compileIcon)
}

gulp.task('default', watchSass)
gulp.task('sass', compileSass)

gulp.task('default', watchIcon)
gulp.task('icon', compileIcon)
